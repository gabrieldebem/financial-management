<?php

namespace Tests\Feature;

use App\Enums\Direction;
use App\Jobs\SyncUserBalance;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class CreateTransactionActionTest extends TestCase
{
    use WithFaker;

    public function testCreateTransaction()
    {
        Bus::fake(SyncUserBalance::class);
        
        $user = User::factory()->create();

        $amount = $this->faker->numberBetween(100, 10000);
        $direction = $this->faker->randomElement(Direction::cases())->value;
        $description = $this->faker->sentence;
        $this->actingAs($user)
            ->post('/api/transactions', [
                'amount' => $amount,
                'direction' => $direction,
                'description' => $description,
            ])
            ->assertCreated();

        $this->assertDatabaseHas(Transaction::class, [
            'user_id' => $user->id,
            'amount' => $amount,
            'direction' => $direction,
            'description' => $description,
        ]);

        Bus::assertDispatched(SyncUserBalance::class);
    }

    public function testCantCreateTransactionForOtherUser()
    {
        $user = User::factory()->create();

        $amount = $this->faker->numberBetween(100, 10000);
        $direction = $this->faker->randomElement(Direction::cases())->value;
        $description = $this->faker->sentence;

        $otherUser = User::factory()->create();
        $this->actingAs($user)
            ->post('/api/transactions', [
                'user_id' => $otherUser->id,
                'amount' => $amount,
                'direction' => $direction,
                'description' => $description,
            ])
            ->assertCreated();

        $this->assertDatabaseHas(Transaction::class, [
            'user_id' => $user->id,
            'amount' => $amount,
            'direction' => $direction,
            'description' => $description,
        ]);

        $this->assertDatabaseMissing(Transaction::class, [
            'user_id' => $otherUser->id,
            'amount' => $amount,
            'direction' => $direction,
            'description' => $description,
        ]);
    }
}

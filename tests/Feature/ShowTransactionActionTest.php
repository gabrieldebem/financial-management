<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowTransactionActionTest extends TestCase
{
    use WithFaker;

    public function testCanShowTransaction()
    {
        $user = User::factory()->create();

        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user)
            ->get("/api/transactions/{$transaction->id}")
            ->assertOk()
            ->assertJson([
                'id' => $transaction->id,
                'user_id' => $user->id,
                'amount' => $transaction->amount,
                'direction' => $transaction->direction->value,
                'description' => $transaction->description,
            ]);
    }

    public function testCantShowTransactionFromOtherUser()
    {
        $user = User::factory()->create();

        $transaction = Transaction::factory()->create();

        $this->actingAs($user)
            ->get("/api/transactions/{$transaction->id}")
            ->assertNotFound();
    }
}

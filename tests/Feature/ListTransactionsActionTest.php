<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListTransactionsActionTest extends TestCase
{
    use WithFaker;

    public function testCanListTransactions()
    {
        $user = User::factory()->create();

        Transaction::factory()
            ->count(5)
            ->create([
                'user_id' => $user->id,
            ]);

        $this->actingAs($user)
            ->get('/api/transactions')
            ->assertOk()
            ->assertJsonCount(5, 'data');
    }

    public function testCantListTransactionsFromOtherUsers()
    {
        $user = User::factory()->create();

        Transaction::factory()
            ->count(5)
            ->create();

        $this->actingAs($user)
            ->get('/api/transactions')
            ->assertOk()
            ->assertJsonCount(0, 'data');
    }
}

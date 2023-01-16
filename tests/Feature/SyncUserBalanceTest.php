<?php

namespace Tests\Feature;

use App\Enums\Direction;
use App\Jobs\SyncUserBalance;
use App\Models\Transaction;
use App\Models\User;
use Tests\TestCase;

class SyncUserBalanceTest extends TestCase
{
    public function testCanSyncUserBalance()
    {
        $user = User::factory()->create();

        Transaction::factory()
            ->count(5)
            ->create([
                'user_id' => $user->id,
                'direction' => Direction::In,
                'amount' => 100,
            ]);

        dispatch_sync(new SyncUserBalance($user));

        $this->assertEquals(500, $user->refresh()->balance);
    }

    public function testCanSyncUserBalanceWithInAndOutTRansactions()
    {
        $user = User::factory()->create();

        Transaction::factory()
            ->count(8)
            ->create([
                'user_id' => $user->id,
                'direction' => Direction::In,
                'amount' => 100,
            ]);

        Transaction::factory()
            ->count(5)
            ->create([
                'user_id' => $user->id,
                'direction' => Direction::Out,
                'amount' => 100,
            ]);

        dispatch_sync(new SyncUserBalance($user));

        $this->assertEquals(300, $user->refresh()->balance);
    }
}

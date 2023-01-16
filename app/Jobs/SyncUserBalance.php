<?php

namespace App\Jobs;

use App\Enums\Direction;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncUserBalance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private User $user)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (blank($this->user->transactions)){
            return;
        }

        $balance = $this->user->balance;

        foreach ($this->user->transactions as $transaction){
            $balance = $transaction->direction === Direction::In
                ? $balance + $transaction->amount
                : $balance - $transaction->amount;
        }

        $this->user->update([
            'balance' => $balance,
        ]);
    }
}

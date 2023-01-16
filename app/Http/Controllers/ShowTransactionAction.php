<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class ShowTransactionAction extends Controller
{
    public function __invoke(Transaction $transaction)
    {
        return response()->json($transaction);
    }
}

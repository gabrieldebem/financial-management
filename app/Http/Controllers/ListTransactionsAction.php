<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Spatie\QueryBuilder\QueryBuilder;

class ListTransactionsAction extends Controller
{
    public function __invoke()
    {
        $transactions = QueryBuilder::for(Transaction::class)
            ->allowedFilters(['amount', 'description'])
            ->allowedSorts(['amount', 'description'])
            ->defaultSort('created_at')
            ->paginate();

        return response()->json($transactions);
    }
}

<?php
namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository extends AbstractRepository
{
    public $model = Transaction::class;
}

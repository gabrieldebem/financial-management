<?php

namespace App\Http\Controllers;

use App\Enums\Direction;
use App\Http\Requests\CreateTransactionRequest;
use App\Jobs\SyncUserBalance;
use App\Repositories\DTOs\CreateTransactionDto;
use App\Repositories\TransactionRepository;
use Illuminate\Http\JsonResponse;

class CreateTransactionAction extends Controller
{
    public function __construct(
        private TransactionRepository $transactionRepository,
    ) {}       
    
    public function __invoke(CreateTransactionRequest $request): JsonResponse
    {
        $data = new CreateTransactionDto(
            user_id: auth()->id(),
            amount: $request->amount,
            direction: Direction::from($request->direction),
            description: $request->description,
        );

        $transaction = $this->transactionRepository->create($data);

        dispatch(new SyncUserBalance(auth()->user()));

        return response()->json($transaction, 201);
    }
}

<?php

use App\Http\Controllers\AuthUserAction;
use App\Http\Controllers\CreateTransactionAction;
use App\Http\Controllers\CreateUserAction;
use App\Http\Controllers\ListTransactionsAction;
use App\Http\Controllers\ShowTransactionAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/users', CreateUserAction::class);
Route::post('/issue-token', AuthUserAction::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', function (Request $request) {
        return $request->user();
    });

    // Transactions
    Route::get('/transactions', ListTransactionsAction::class);
    Route::post('/transactions', CreateTransactionAction::class);
    Route::get('/transactions/{transaction}', ShowTransactionAction::class)
        ->whereUuid('transaction');
});

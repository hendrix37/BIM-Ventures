<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\CreateTransactionRequest;
use App\Http\Requests\Transaction\UpdateTransactionRequest;
use App\Http\Resources\Transaction\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct()
    {

    }

    public function index(): AnonymousResourceCollection 
    {
        $transactions = Transaction::useFilters()->dynamicPaginate();

        return TransactionResource::collection($transactions);
    }

    public function store(CreateTransactionRequest $request): JsonResponse
    {
        $transaction = Transaction::create($request->validated());

        return $this->responseCreated('Transaction created successfully', new TransactionResource($transaction));
    }

    public function show(Transaction $transaction): JsonResponse
    {
        return $this->responseSuccess(null, new TransactionResource($transaction));
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction): JsonResponse
    {
        $transaction->update($request->validated());

        return $this->responseSuccess('Transaction updated Successfully', new TransactionResource($transaction));
    }

    public function destroy(Transaction $transaction): JsonResponse
    {
        $transaction->delete();

        return $this->responseDeleted();
    }

}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\CreateTransactionRequest;
use App\Http\Requests\Transaction\UpdateTransactionRequest;
use App\Http\Resources\Transaction\TransactionResource;
use App\Models\Transaction;
use DB;
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

    public function list_transaction_by_mount(): JsonResponse
    {
        // $transactions = Transaction::select(
        //     DB::raw('YEAR(created_at) as year'),
        //     DB::raw('MONTH(created_at) as month'),
        //     DB::raw('COUNT(*) as transaction_count')
        // )
        // ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
        // ->orderBy(DB::raw('YEAR(created_at)'), 'asc')
        // ->orderBy(DB::raw('MONTH(created_at)'), 'asc')
        // ->get();

        $transactions = Transaction::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(CASE WHEN status = "paid" THEN amount ELSE 0 END) as paid'),
            DB::raw('COUNT(CASE WHEN status = "outstanding" THEN amount ELSE 0 END) as outstanding'),
            DB::raw('COUNT(CASE WHEN status = "overdue" THEN amount ELSE 0 END) as overdue')
        )
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('YEAR(created_at)'), 'asc')
            ->orderBy(DB::raw('MONTH(created_at)'), 'asc')
            ->get();


        return $this->responseSuccess('Success', $transactions);
    }
}

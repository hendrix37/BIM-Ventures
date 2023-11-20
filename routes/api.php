<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*===========================
=           transactions           =
=============================*/

Route::apiResource('/transactions', \App\Http\Controllers\API\TransactionController::class);
Route::get('/list-transaction-by-mount', [\App\Http\Controllers\API\TransactionController::class, 'list_transaction_by_mount']);

/*=====  End of transactions   ======*/

/*===========================
=           invoices           =
=============================*/

Route::apiResource('/invoices', \App\Http\Controllers\API\InvoiceController::class);

/*=====  End of invoices   ======*/

/*===========================
=           invoiceReceipts           =
=============================*/

Route::apiResource('/invoiceReceipts', \App\Http\Controllers\API\InvoiceReceiptController::class);

/*=====  End of invoiceReceipts   ======*/

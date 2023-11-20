<?php

use App\Exports\TransactionExport;
use App\Models\Invoice;
use App\Models\InvoiceReceipt;
use App\Models\Transaction;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/excel', function () {
    
    return Excel::download(new TransactionExport, 'transaction.xlsx');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return redirect('admin/login');
})->name('login');

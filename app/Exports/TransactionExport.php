<?php

namespace App\Exports;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransactionExport implements FromView
{
    protected $start_date;

    protected $end_date;

    public function __construct($start_date, $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $from = $this->start_date;
        $to = $this->end_date;

        $transactions = Transaction::whereBetween('created_at', [$from, $to])->get();
        $new_data = [];
        foreach ($transactions as $key => $transaction) {
            $apa = [
                'transaction' => [
                    'id' => $transaction->id,
                    'created_at' => Carbon::parse($transaction->created_at)->format('d F Y H:i:s'),
                    'status' => $transaction->status,
                    'rowspan' => $transaction->invoices->flatMap->receipts->count(),
                ],
            ];
            foreach ($transaction->invoices as $key => $value) {

                $apa['transaction']['invoices'][$key] = [

                    'rowspan' => $value->receipts->count(),
                    'invoice_number' => $value->invoice_number,
                ];
                if ($value->receipts->count() == 0) {
                    $apa['transaction']['rowspan']++;
                }
                foreach ($value->receipts as $key2 => $receipt) {

                    $apa['transaction']['invoices'][$key]['receipts'][] = [

                        'id' => $receipt->id,
                        'receipt_number' => $receipt->invoice_receipt_number,
                        'amount' => $receipt->amount,
                    ];
                }
            }
            $new_data[] = $apa;
        }

        return view('exports.transaction', [
            'data' => $new_data,
        ]);
    }
}

<table>
    <thead>
        <tr>
            <th>Transaksi Create</th>
            <th>Invoice</th>
            <th>Receipt</th>
            <th>Amount</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $transaction)
        @if (!empty($transaction['transaction']['invoices']))
            
            @php
                $invoices = $transaction['transaction']['invoices'];
            @endphp
            <tr>
                <td @if ($transaction['transaction']['rowspan']>0)
                    rowspan="{{ $transaction['transaction']['rowspan'] }}"
                @endif >{{ $transaction['transaction']['created_at'] }}</td>

                @if (!empty($invoices))

                    @foreach ($invoices as $invoice)
                        @if (!empty($invoice['receipts']))
                        <td rowspan="{{ $invoice['rowspan'] }}">{{ $invoice['invoice_number'] }}</td>

                            @foreach ($invoice['receipts'] as $receipt)
                                <td>{{ $receipt['receipt_number'] }}</td>
                                <td>{{ number_format($receipt['amount']) }}</td>
                                <td>{{ $transaction['transaction']['status'] }}</td>

                            </tr>
                            <tr>
                            @endforeach  

                        @else
                            <td>{{ $invoice['invoice_number'] }}</td>
                            <td>-</td>
                            <td>-</td>
                            <td>{{ $transaction['transaction']['status'] }}</td>
                        </tr>
                        <tr>
                        @endif
                    @endforeach
                @endif

            </tr>
            @endif

        @endforeach
    </tbody>
</table>
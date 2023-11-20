<?php

namespace Database\Seeders;

use App\Models\InvoiceReceipt;
use Illuminate\Database\Seeder;

class InvoiceReceiptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        InvoiceReceipt::factory(10)->create();
    }
}

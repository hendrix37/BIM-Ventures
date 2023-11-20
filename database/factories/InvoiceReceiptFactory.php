<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceReceiptFactory extends Factory
{
    public function definition(): array
    {
        $microtime = str_replace('.', '', microtime(true));
        $receipt_number = 'KW/' . now()->format('Ymd') . '/' . $microtime;

        return [
			'invoice_receipt_number' => $receipt_number,
            'payer_id' => $this->faker->randomElement(\App\Models\User::pluck('id')),
			'payer_name' => $this->faker->firstName(),
			'amount' => $this->faker->numberBetween(10000,100000),
            'invoice_id' => $this->faker->randomElement(\App\Models\Invoice::pluck('id')),
        ];
    }
}

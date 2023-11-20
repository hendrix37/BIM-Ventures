<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    public function definition(): array
    {
        $microtime = str_replace('.', '', microtime(true));
        $invoice_code = 'INV/' . now()->format('Ymd') . '/' . $microtime;
        return [
            'invoice_number' => $invoice_code,
            'payer_id' => $this->faker->randomElement(\App\Models\User::pluck('id')),
            'amount' => $this->faker->numberBetween(10000, 100000),
            'transaction_id' => $this->faker->randomElement(\App\Models\Transaction::pluck('id')),
        ];
    }
}

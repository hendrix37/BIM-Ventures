<?php

namespace Database\Factories;

use App\Enums\StatusType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'payer_id' => $this->faker->randomElement(\App\Models\User::pluck('id')),
            'amount' => $this->faker->numberBetween(10000, 100000),
            'due_date' => $this->faker->dateTime(),
            'vat' => $this->faker->randomFloat(),
            'is_vat' => $this->faker->boolean(),
            'status' => $this->faker->randomElement(StatusType::getAll()),
            'created_at' => Carbon::now()->addMonths($this->faker->numberBetween(1, 12))->addYears($this->faker->numberBetween(1, 5)),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'invoice_id' => Invoice::pluck('id')->random() ?? Invoice::factory(),
            'amount' => $this->faker->randomFloat(2, 500000, 10000000),
            'payment_date' => now(),
            'method' => $this->faker->randomElement(['bank_transfer', 'cash', 'check', 'other']),
            'reference' => 'TRANS-' . strtoupper($this->faker->bothify('??###')),
            'notes' => $this->faker->sentence(),
            'recorded_by' => User::pluck('id')->random() ?? User::factory(),
        ];
    }
}
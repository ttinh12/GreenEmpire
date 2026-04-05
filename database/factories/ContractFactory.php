<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory
{
    public function definition(): array
    {
        $value = $this->faker->randomFloat(2, 5000000, 100000000); // Giá trị từ 5tr - 100tr
        $vatRate = 10;
        $vatAmount = ($value * $vatRate) / 100;

        return [
            'code' => 'HD-' . strtoupper($this->faker->unique()->bothify('??###')),
            'customer_id' => Customer::pluck('id')->random() ?? Customer::factory(),
            'department_id' => Department::pluck('id')->random() ?? Department::factory(),
            'title' => 'Hợp đồng cung cấp nông sản ' . $this->faker->word(),
            'description' => $this->faker->sentence(),
            'value' => $value,
            'vat_rate' => $vatRate,
            'vat_amount' => $vatAmount,
            'total_value' => $value + $vatAmount,
            'start_date' => now(),
            'end_date' => now()->addMonths(12),
            'signed_date' => now(),
            'status' => $this->faker->randomElement(['draft', 'active', 'completed']),
            'payment_terms' => 'Thanh toán chuyển khoản 100%',
            'warranty_months' => 6,
            'created_by' => User::pluck('id')->random() ?? User::factory(),
        ];
    }
}
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;
use App\Models\Department;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
public function definition(): array
{
    $value = $this->faker->randomFloat(2, 5000000, 100000000);
    $vatRate = 10;
    $vatAmount = ($value * $vatRate) / 100;

    return [
        'code' => 'HD-' . strtoupper($this->faker->unique()->bothify('??###')),
        'customer_id' => Customer::inRandomOrder()->first()?->id ?? Customer::factory(),
        'department_id' => Department::inRandomOrder()->first()?->id ?? Department::factory(),
        'title' => 'Hợp đồng cung cấp nông sản ' . $this->faker->word(),
        'description' => $this->faker->sentence(),
        'value' => $value,
        'vat_rate' => $vatRate,
        'vat_amount' => $vatAmount,
        'total_value' => $value + $vatAmount,
        'start_date' => now(),
        'end_date' => now()->addMonths(12),
        'signed_date' => now(),
        
        // SỬA Ở ĐÂY: Dùng số thay vì chữ
        'status' => $this->faker->randomElement([1, 2, 3, 4, 5]), // 1: draft, 2: active, 3: completed...
        
        'payment_terms' => 'Thanh toán chuyển khoản 100%',
        'warranty_months' => 6,
        'created_by' => User::inRandomOrder()->first()?->id ?? User::factory(),
        // Bạn thiếu updated_by trong Factory, nên thêm vào luôn cho đủ bộ
        'updated_by' => User::inRandomOrder()->first()?->id ?? User::factory(),
    ];
}}

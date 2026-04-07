<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'code' => 'KH-' . $this->faker->unique()->numberBetween(1000, 9999),
            'name' => $this->faker->company() . ' ' . $this->faker->companySuffix(),

            // Sửa lại thành số tương ứng với comment trong migration của bạn
            'type' => $this->faker->randomElement([1, 2, 3, 4]), // 1:company, 2:school...

            'address' => $this->faker->address(),
            'province' => $this->faker->city(),
            'tax_code' => $this->faker->numerify('##########'),
            'website' => $this->faker->url(),
            'email' => $this->faker->unique()->companyEmail(),
            'phone' => $this->faker->phoneNumber(),

            // Đoạn này nên dùng optional() để tránh lỗi nếu DB trống
            'department_id' => Department::inRandomOrder()->first()?->id ?? Department::factory(),
            'account_manager_id' => User::inRandomOrder()->first()?->id ?? User::factory(),

            'source' => $this->faker->randomElement(['Facebook', 'Website', 'Giới thiệu', 'Sự kiện']),

            // Sửa lại thành số luôn
            'status' => $this->faker->randomElement([1, 2, 3]), // 1:active, 2:potential, 3:inactive

            'notes' => $this->faker->sentence(),
        ];
    }
}
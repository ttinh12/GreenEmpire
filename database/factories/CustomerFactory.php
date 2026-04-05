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
            'type' => $this->faker->randomElement(['company', 'school', 'government', 'individual']),
            'address' => $this->faker->address(),
            'province' => $this->faker->city(),
            'tax_code' => $this->faker->numerify('##########'),
            'website' => $this->faker->url(),
            'email' => $this->faker->unique()->companyEmail(),
            'phone' => $this->faker->phoneNumber(),
            'department_id' => Department::pluck('id')->random() ?? Department::factory(),
            'account_manager_id' => User::pluck('id')->random() ?? User::factory(),
            'source' => $this->faker->randomElement(['Facebook', 'Website', 'Giới thiệu', 'Sự kiện']),
            'status' => $this->faker->randomElement(['active', 'potential', 'inactive']),
            'notes' => $this->faker->sentence(),
        ];
    }
}
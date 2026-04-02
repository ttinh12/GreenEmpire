<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => \App\Models\Customer::factory(), // Tạo một customer mới và lấy ID của nó
            'name' => $this->faker->name(),
            'position' => $this->faker->jobTitle(),
            'department' => $this->faker->randomElement(['Sales', 'Marketing', 'Support', 'HR']),
            'phone' => $this->faker->phoneNumber(),
            'mobile' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'is_primary' => $this->faker->boolean(20), // 20% cơ hội là primary contact
            'notes' => $this->faker->optional()->paragraph(),
        ];
    }
}

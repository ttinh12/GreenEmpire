<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerNoteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'customer_id' => Customer::pluck('id')->random() ?? Customer::factory(),
            'user_id' => User::pluck('id')->random() ?? User::factory(),
            'type' => $this->faker->randomElement(['call', 'email', 'meeting', 'visit', 'reminder', 'other']),
            'title' => $this->faker->sentence(4),
            'content' => $this->faker->paragraph(),
            'note_date' => now(),
            'follow_up_date' => $this->faker->optional()->dateTimeBetween('now', '+1 month'),
            'is_pinned' => $this->faker->boolean(10), // 10% cơ hội được ghim
        ];
    }
}

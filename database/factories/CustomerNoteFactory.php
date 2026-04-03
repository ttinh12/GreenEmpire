<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomerNote>
 */
class CustomerNoteFactory extends Factory
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
            'user_id' => \App\Models\User::factory(), // Tạo một user mới và lấy ID của nó
            'type' => $this->faker->numberBetween(1, 6), // 1: call, 2: email, 3: meeting, 4: visit, 5: reminder, 6: other
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(),
            'note_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'follow_up_date' => $this->faker->optional()->dateTimeBetween('now', '+1 year'),
            'is_pinned' => $this->faker->boolean(10), // 10% cơ hội được ghim
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        $status = $this->faker->randomElement(['todo', 'in_progress', 'done', 'cancelled']);
        
        return [
            'customer_id' => Customer::pluck('id')->random() ?? Customer::factory(),
            'contract_id' => Contract::pluck('id')->random(), // Có thể null nếu là task ngoài hợp đồng
            'assignee_id' => User::pluck('id')->random() ?? User::factory(),
            'creator_id' => User::pluck('id')->random() ?? User::factory(),
            'title' => 'Nhiệm vụ: ' . $this->faker->sentence(5),
            'description' => $this->faker->paragraph(),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'priority' => $this->faker->randomElement(['high', 'medium', 'low']),
            'status' => $status,
            'completed_at' => $status === 'done' ? now() : null,
        ];
    }
}
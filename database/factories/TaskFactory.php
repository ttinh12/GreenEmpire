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
        // Quy ước theo Model Task của bạn: 1: Todo, 2: In Progress, 3: Review, 4: Done
        $status = $this->faker->randomElement([1, 2, 3, 4]);

        return [
            'customer_id' => Customer::inRandomOrder()->first()?->id ?? Customer::factory(),
            // contract_id có thể null, dùng optional() hoặc random từ list có sẵn
            'contract_id' => $this->faker->optional(0.7)->randomElement(Contract::pluck('id')->toArray()),

            'assignee_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'creator_id' => User::inRandomOrder()->first()?->id ?? User::factory(),

            'title' => 'Nhiệm vụ: ' . $this->faker->sentence(5),
            'description' => $this->faker->paragraph(),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),

            // Priority theo số: 1: Low, 2: Medium, 3: High, 4: Urgent
            'priority' => $this->faker->randomElement([1, 2, 3, 4]),

            'status' => $status,

            // Cập nhật các cột Kanban
            'position' => $this->faker->numberBetween(0, 10),
            'sort' => $this->faker->randomFloat(10, 0, 1000),

            // Thời gian
            'started_at' => $status > 1 ? now()->subHours(rand(1, 24)) : null,
            'completed_at' => $status === 4 ? now() : null,
        ];
    }
}
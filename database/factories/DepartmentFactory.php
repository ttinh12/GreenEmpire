<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory


{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->bothify('BM_##'),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'is_active' => $this->faker->boolean(90), // 90% chance of being active
        ];
    }
}

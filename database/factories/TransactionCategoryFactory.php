<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionCategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'code' => strtoupper($this->faker->unique()->lexify('CAT???')),
            'name' => $this->faker->word(),
            'type' => $this->faker->randomElement(['income', 'expense']),
            'is_active' => true,
        ];
    }
}
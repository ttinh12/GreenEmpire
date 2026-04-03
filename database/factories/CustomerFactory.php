<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
          return [
            'code' => 'KH' . $this->faker->unique()->numberBetween(1, 9999),
            'name' => $this->faker->company(),
            'type' => $this->faker->numberBetween(1, 4),
            'address' => $this->faker->address(),
            'province' => $this->faker->city(),
            'tax_code' => $this->faker->optional()->numerify('##########'),
            'website' => $this->faker->optional()->url(),
            'email' => $this->faker->optional()->email(),
            'phone' => $this->faker->phoneNumber(),
            'fax' => $this->faker->optional()->phoneNumber(),
            'department_id' => null,
            'account_manager_id' => null,
            'source' => $this->faker->randomElement(['Google', 'Facebook', 'Referral', 'Email']),
            'status' => $this->faker->numberBetween(1, 3),
            'notes' => $this->faker->optional()->paragraph(),
        ];
    }
}
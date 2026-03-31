<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Department;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),

            'email' => $this->faker->unique()->safeEmail(),

            'email_verified_at' => now(),

            'password' => bcrypt('123456'), // login demo

            'avatar_url' => $this->faker->imageUrl(200, 200, 'people'),

            'is_active' => $this->faker->boolean(90), // 90% active

            'last_login_at' => $this->faker->optional()->dateTime(),

            'department_id' => Department::inRandomOrder()->value('id'),

            'remember_token' => Str::random(10),

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}

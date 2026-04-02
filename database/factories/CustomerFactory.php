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
            'code' => $this->faker->unique()->bothify('CUST-####'),
            'name' => $this->faker->company(),
            'type' => $this->faker->randomElement(['Individual', 'Company']),
            'address' => $this->faker->address(),
            'province' => $this->faker->city(), // ✅ Đã sửa - dùng city() thay vì state()
            'tax_code' => $this->faker->optional()->bothify('TAX-#####'),
            'website' => $this->faker->optional()->url(),
            'email' => $this->faker->optional()->safeEmail(),
            'phone' => $this->faker->optional()->phoneNumber(),
            'fax' => $this->faker->optional()->phoneNumber(),
            'department_id' => Department::inRandomOrder()->value('id'),
            'account_manager_id' => User::inRandomOrder()->value('id'),
            'source' => $this->faker->randomElement(['Referral', 'Website', 'Cold Call', 'Other']),
            'status' => $this->faker->randomElement(['Active', 'Inactive']),
            'notes' => $this->faker->optional()->paragraph(),
        ];
    }
}
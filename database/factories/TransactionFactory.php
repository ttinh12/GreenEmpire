<?php

namespace Database\Factories;

use App\Models\TransactionCategory;
use App\Models\Department;
use App\Models\User;
use App\Models\Contract;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition(): array
    {
        $type = $this->faker->randomElement(['income', 'expense']);
        
        return [
            'reference_code' => 'TRX-' . strtoupper($this->faker->unique()->bothify('###??###')),
            'department_id' => Department::pluck('id')->random(),
            'category_id' => TransactionCategory::where('type', $type)->pluck('id')->random(),
            'type' => $type,
            'contract_id' => $type === 'income' ? Contract::pluck('id')->random() : null,
            'invoice_id' => $type === 'income' ? Invoice::pluck('id')->random() : null,
            'amount' => $this->faker->randomFloat(2, 100000, 20000000),
            'transaction_date' => now()->subDays(rand(0, 60)),
            'description' => $this->faker->sentence(),
            'created_by' => User::pluck('id')->random(),
            'approved_by' => User::pluck('id')->random(),
            'approved_at' => now(),
        ];
    }
}
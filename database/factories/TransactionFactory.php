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
    // Đồng bộ: 1 là income (thu), 2 là expense (chi)
    $type = $this->faker->randomElement([1, 2]); 
    
    return [
        'reference_code' => 'TRX-' . strtoupper($this->faker->unique()->bothify('###??###')),
        
        // Dùng inRandomOrder() cho an toàn
        'department_id' => Department::inRandomOrder()->first()?->id ?? Department::factory(),
        
        // Lọc category theo type (cũng bằng số)
        'category_id' => TransactionCategory::where('type', $type)->inRandomOrder()->first()?->id 
                         ?? TransactionCategory::factory(['type' => $type]),
        
        'type' => $type,
        
        // Chỉ gán Contract và Invoice nếu là khoản thu (income = 1)
        'contract_id' => $type === 1 ? (Contract::inRandomOrder()->first()?->id) : null,
        'invoice_id' => $type === 1 ? (Invoice::inRandomOrder()->first()?->id) : null,
        
        'amount' => $this->faker->randomFloat(2, 100000, 20000000),
        'transaction_date' => now()->subDays(rand(0, 60)),
        'description' => $this->faker->sentence(),
        
        'created_by' => User::inRandomOrder()->first()?->id ?? User::factory(),
        'approved_by' => User::inRandomOrder()->first()?->id ?? User::factory(),
        'approved_at' => now(),
    ];
}
}
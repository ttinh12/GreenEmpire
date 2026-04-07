<?php

namespace Database\Factories;

use App\Models\Contract;
use App\Models\Customer;
use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
public function definition(): array
{
    $subtotal = $this->faker->randomFloat(2, 1000000, 50000000);
    $vatRate = 10.00;
    $vatAmount = ($subtotal * $vatRate) / 100;
    $totalAmount = $subtotal + $vatAmount;
    
    // Sửa logic Status sang dạng SỐ
    // 1: draft, 2: sent, 3: paid, 4: partial, 5: overdue
    $status = $this->faker->randomElement([1, 2, 3, 4, 5]); 
    
    $paidAmount = 0;
    if ($status === 3) $paidAmount = $totalAmount; // Status là 3 (Paid)
    if ($status === 4) $paidAmount = $totalAmount / 2; // Status là 4 (Partial)

    return [
        'code' => 'INV-' . strtoupper($this->faker->unique()->bothify('??####')),
        // Dùng inRandomOrder() cho an toàn như tui đã hướng dẫn
        'contract_id' => Contract::inRandomOrder()->first()?->id ?? Contract::factory(),
        'customer_id' => Customer::inRandomOrder()->first()?->id ?? Customer::factory(),
        'department_id' => Department::inRandomOrder()->first()?->id ?? Department::factory(),
        
        'issue_date' => now()->subDays(rand(1, 30)),
        'due_date' => now()->addDays(rand(1, 15)),
        'subtotal' => $subtotal,
        'vat_rate' => $vatRate,
        'vat_amount' => $vatAmount,
        'total_amount' => $totalAmount,
        'paid_amount' => $paidAmount,
        
        'status' => $status,
        
        // Sửa Payment Method sang dạng SỐ
        // 1: bank_transfer, 2: cash, 3: check, 4: other
        'payment_method' => $this->faker->randomElement([1, 2]), 
        
        'bank_info' => 'Vietcombank - 001100xxxx - GreenEmpire Corp',
        'created_by' => User::inRandomOrder()->first()?->id ?? User::factory(),
        // Không khai báo 'remaining' ở đây
    ];
}}
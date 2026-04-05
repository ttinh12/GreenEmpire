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
        $subtotal = $this->faker->randomFloat(2, 1000000, 50000000); // 1tr - 50tr
        $vatRate = 10.00;
        $vatAmount = ($subtotal * $vatRate) / 100;
        $totalAmount = $subtotal + $vatAmount;
        
        // Giả lập một số hóa đơn đã thanh toán một phần hoặc toàn bộ
        $status = $this->faker->randomElement(['draft', 'sent', 'paid', 'partial', 'overdue']);
        $paidAmount = 0;
        if ($status === 'paid') $paidAmount = $totalAmount;
        if ($status === 'partial') $paidAmount = $totalAmount / 2;

        return [
            'code' => 'INV-' . strtoupper($this->faker->unique()->bothify('??####')),
            'contract_id' => Contract::pluck('id')->random() ?? Contract::factory(),
            'customer_id' => Customer::pluck('id')->random() ?? Customer::factory(),
            'department_id' => Department::pluck('id')->random(),
            'issue_date' => now()->subDays(rand(1, 30)),
            'due_date' => now()->addDays(rand(1, 15)),
            'subtotal' => $subtotal,
            'vat_rate' => $vatRate,
            'vat_amount' => $vatAmount,
            'total_amount' => $totalAmount,
            'paid_amount' => $paidAmount,
            'status' => $status,
            'payment_method' => $this->faker->randomElement(['bank_transfer', 'cash']),
            'bank_info' => 'Vietcombank - 001100xxxx - GreenEmpire Corp',
            'created_by' => User::pluck('id')->random() ?? User::factory(),
        ];
    }
}
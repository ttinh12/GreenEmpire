<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
public function definition(): array
{
    return [
        // Sử dụng cách lấy ID an toàn hơn
        'invoice_id' => Invoice::inRandomOrder()->first()?->id ?? Invoice::factory(),
        
        'amount' => $this->faker->randomFloat(2, 500000, 10000000),
        'payment_date' => now(),
        
        // SỬA Ở ĐÂY: Chuyển sang SỐ để khớp với Migration
        // 1: bank_transfer, 2: cash, 3: check, 4: other
        'method' => $this->faker->randomElement([1, 2, 3, 4]), 
        
        'reference' => 'TRANS-' . strtoupper($this->faker->bothify('??###')),
        'notes' => $this->faker->sentence(),
        
        // Cột này trong Migration là string, Factory không có cũng không sao nếu nullable
        // Nhưng nếu muốn giả lập đường dẫn ảnh/file đính kèm thì thêm:
        // 'attachment' => 'payments/proof_' . $this->faker->unixTime . '.jpg',
        
        'recorded_by' => User::inRandomOrder()->first()?->id ?? User::factory(),
    ];
}}
<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo 40 lượt thanh toán mẫu
        Payment::factory()->count(40)->create();
    }
}
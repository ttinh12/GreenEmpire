<?php

namespace Database\Seeders;

use App\Models\Invoice;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo 30 hóa đơn mẫu để Duy và Thịnh test logic VAT và thanh toán
        Invoice::factory()->count(30)->create();
    }
}
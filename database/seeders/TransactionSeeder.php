<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo 60 giao dịch để làm dữ liệu vẽ biểu đồ báo cáo
        Transaction::factory()->count(60)->create();
    }
}
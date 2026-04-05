<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo 30 khách hàng mẫu để làm phong phú dữ liệu hệ thống
        Customer::factory()->count(30)->create();
    }
}
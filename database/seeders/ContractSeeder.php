<?php

namespace Database\Seeders;

use App\Models\Contract;
use Illuminate\Database\Seeder;

class ContractSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo 20 hợp đồng mẫu để các thành viên test
        Contract::factory()->count(20)->create();
    }
}
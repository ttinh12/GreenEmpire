<?php

namespace Database\Seeders;

use App\Models\CustomerNote;
use Illuminate\Database\Seeder;

class CustomerNoteSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo 50 ghi chú ngẫu nhiên để hệ thống nhìn có vẻ "bận rộn"
        CustomerNote::factory()->count(50)->create();
    }
}
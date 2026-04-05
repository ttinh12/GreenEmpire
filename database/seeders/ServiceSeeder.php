<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
       // 2. Tạo thêm 10 dịch vụ ngẫu nhiên bằng Factory để test giao diện
    Service::factory()->count(15)->create();
    }
}
<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo 40 nhiệm vụ mẫu để Xuân Cường test giao diện quản lý
        Task::factory()->count(40)->create();
    }
}
<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Đảm bảo có ít nhất một phòng ban để gán cho User
        // Nếu bảng departments trống, tạo tạm 1 cái để không bị lỗi khóa ngoại
        $deptId = Department::value('id') ?? Department::factory()->create(['name' => 'Ban Giám Đốc'])->id;

        // 2. Tạo 1 User cố định để nhóm mình dễ đăng nhập test
        User::updateOrCreate(
            ['email' => 'admin@greenempire.com'], // Tránh trùng lặp nếu chạy seeder nhiều lần
            [
                'name' => 'Quản Trị Viên',
                'password' => Hash::make('123456'), // Mật khẩu dễ nhớ cho cả nhóm
                'department_id' => $deptId,
                'is_active' => 1,
                'email_verified_at' => now(),
            ]
        );

        // 3. Tạo thêm 10 User mẫu ngẫu nhiên bằng Factory
        User::factory()->count(10)->create();
    }
}
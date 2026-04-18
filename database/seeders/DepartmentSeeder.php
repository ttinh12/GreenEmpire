<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('departments')->insert([
            [
                'code'        => 'BGD',
                'name'        => 'Ban Giám đốc Xưởng',
                'description' => 'Điều hành và định hướng chiến lược xưởng CNTT',
                'is_active'   => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'code'        => 'DEV',
                'name'        => 'Nhóm Lập trình',
                'description' => 'Phát triển web, app và phần mềm theo yêu cầu khách hàng',
                'is_active'   => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'code'        => 'DES',
                'name'        => 'Nhóm Thiết kế UI/UX',
                'description' => 'Thiết kế giao diện, trải nghiệm người dùng và tài liệu truyền thông',
                'is_active'   => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'code'        => 'MKT',
                'name'        => 'Nhóm Marketing & Quảng cáo',
                'description' => 'SEO, Google Ads, Facebook Ads và content marketing',
                'is_active'   => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'code'        => 'AI',
                'name'        => 'Nhóm AI & Tự động hóa',
                'description' => 'Nghiên cứu, đào tạo AI và triển khai N8N workflow',
                'is_active'   => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'code'        => 'KD',
                'name'        => 'Nhóm Kinh doanh',
                'description' => 'Tư vấn, chăm sóc khách hàng và ký kết hợp đồng',
                'is_active'   => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);

        $this->command->info('✅ DepartmentSeeder: Đã tạo 6 phòng ban xưởng CNTT.');
    }
}
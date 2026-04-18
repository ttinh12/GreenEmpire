<?php

namespace Database\Seeders;

use App\Models\TransactionCategory;
use Illuminate\Database\Seeder;

class TransactionCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // ── Thu nhập (type = 1) ───────────────────────────
            ['code' => 'INC_WEB',   'name' => 'Doanh thu thiết kế & lập trình web',   'type' => 1, 'parent_id' => null, 'is_active' => 1],
            ['code' => 'INC_APP',   'name' => 'Doanh thu lập trình ứng dụng',          'type' => 1, 'parent_id' => null, 'is_active' => 1],
            ['code' => 'INC_SEO',   'name' => 'Doanh thu SEO & quảng cáo',             'type' => 1, 'parent_id' => null, 'is_active' => 1],
            ['code' => 'INC_AI',    'name' => 'Doanh thu đào tạo AI & N8N',            'type' => 1, 'parent_id' => null, 'is_active' => 1],
            ['code' => 'INC_MAINT', 'name' => 'Doanh thu bảo trì hệ thống',           'type' => 1, 'parent_id' => null, 'is_active' => 1],
            ['code' => 'INC_OTHER', 'name' => 'Thu nhập khác',                         'type' => 1, 'parent_id' => null, 'is_active' => 1],

            // ── Chi phí (type = 2) ───────────────────────────
            ['code' => 'EXP_SALA',  'name' => 'Chi trả thù lao thành viên',            'type' => 2, 'parent_id' => null, 'is_active' => 1],
            ['code' => 'EXP_HOST',  'name' => 'Chi phí hosting & tên miền',            'type' => 2, 'parent_id' => null, 'is_active' => 1],
            ['code' => 'EXP_ADS',   'name' => 'Chi phí chạy quảng cáo (ngân sách KH)','type' => 2, 'parent_id' => null, 'is_active' => 1],
            ['code' => 'EXP_TOOL',  'name' => 'Chi phí công cụ & phần mềm',           'type' => 2, 'parent_id' => null, 'is_active' => 1],
            ['code' => 'EXP_TRAIN', 'name' => 'Chi phí đào tạo nội bộ',               'type' => 2, 'parent_id' => null, 'is_active' => 1],
            ['code' => 'EXP_OTHER', 'name' => 'Chi phí khác',                          'type' => 2, 'parent_id' => null, 'is_active' => 1],
        ];

        foreach ($categories as $data) {
            TransactionCategory::create($data);
        }

        $this->command->info('✅ TransactionCategorySeeder: Đã tạo ' . count($categories) . ' danh mục tài chính.');
    }
}
<?php

namespace Database\Seeders;

use App\Models\TransactionCategory;
use Illuminate\Database\Seeder;

class TransactionCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Thu nhập
            ['code' => 'INC_SALE', 'name' => 'Doanh thu bán hàng', 'type' => 'income'],
            ['code' => 'INC_SERV', 'name' => 'Thu phí dịch vụ', 'type' => 'income'],
            ['code' => 'INC_OTHE', 'name' => 'Thu nhập khác', 'type' => 'income'],
            
            // Chi phí
            ['code' => 'EXP_SALA', 'name' => 'Chi trả lương nhân viên', 'type' => 'expense'],
            ['code' => 'EXP_OFFI', 'name' => 'Chi phí văn phòng', 'type' => 'expense'],
            ['code' => 'EXP_MARK', 'name' => 'Chi phí Marketing', 'type' => 'expense'],
            ['code' => 'EXP_SHIP', 'name' => 'Phí vận chuyển', 'type' => 'expense'],
        ];

        foreach ($categories as $cat) {
            TransactionCategory::create($cat);
        }
    }
}
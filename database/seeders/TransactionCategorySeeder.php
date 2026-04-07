<?php

namespace Database\Seeders;

use App\Models\TransactionCategory;
use Illuminate\Database\Seeder;

class TransactionCategorySeeder extends Seeder
{
public function run(): void
{
    $categories = [
        // Thu nhập (Dùng số 1 đại diện cho 'income')
        ['code' => 'INC_SALE', 'name' => 'Doanh thu bán hàng', 'type' => 1],
        ['code' => 'INC_SERV', 'name' => 'Thu phí dịch vụ', 'type' => 1],
        
        // Chi phí (Dùng số 2 đại diện cho 'expense')
        ['code' => 'EXP_SALA', 'name' => 'Chi trả lương nhân viên', 'type' => 2],
        ['code' => 'EXP_OFFI', 'name' => 'Chi phí văn phòng', 'type' => 2],
    ];

    foreach ($categories as $cat) {
        TransactionCategory::create($cat);
    }
}}
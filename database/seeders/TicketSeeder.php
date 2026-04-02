<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy danh sách ID của users để gán vào khóa ngoại
        $userIds = User::pluck('id')->toArray();

        if (empty($userIds)) {
            $this->command->info('Chưa có User nào, hãy chạy UserSeeder trước!');
            return;
        }

        $tickets = [
            [
                'title' => 'Lỗi không đăng nhập được hệ thống',
                'name' => 'Lỗi đăng nhập',
                'content' => 'Khách hàng báo lỗi 500 khi nhấn vào nút đăng nhập từ sáng nay.',
                'user_id' => $userIds[array_rand($userIds)],
                'assign_id' => $userIds[array_rand($userIds)],
                'priority' => 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Yêu cầu xuất hóa đơn đỏ cho hợp đồng Green-01',
                'name' => 'Yêu cầu xuất hóa đơn',
                'content' => 'Công ty GreenEmpire yêu cầu gửi hóa đơn điện tử qua email.',
                'user_id' => $userIds[array_rand($userIds)],
                'assign_id' => null, // Chưa giao cho ai
                'priority' => 2,
                'status' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Cập nhật lại đơn giá gạo tháng 3',
                'name' => 'Cập nhật đơn giá',
                'content' => 'Điều chỉnh giá từ 18.000đ lên 19.500đ theo thị trường.',
                'user_id' => $userIds[array_rand($userIds)],
                'assign_id' => $userIds[array_rand($userIds)],
                'priority' => 3,
                'status' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Ticket::insert($tickets);
        $this->command->info('Đã tạo xong dữ liệu mẫu cho Ticket!');
    }
}
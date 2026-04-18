<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = User::pluck('id')->toArray();

        if (empty($userIds)) {
            $this->command->warn('⚠️ Chưa có User, hãy chạy UserSeeder trước!');
            return;
        }

        $admin  = User::where('email', 'admin@greenempire.com')->value('id') ?? $userIds[0];
        $cuong  = User::where('email', 'cuong.dev@greenempire.com')->value('id') ?? $userIds[0];
        $tinh   = User::where('email', 'tinh.dev@greenempire.com')->value('id') ?? $userIds[0];
        $duy    = User::where('email', 'duy.dev@greenempire.com')->value('id') ?? $userIds[0];
        $staff  = User::where('email', 'staff@greenempire.com')->value('id') ?? $userIds[0];

        $tickets = [
            [
                'ticket_code' => 'TK-001',
                'title'       => 'Website khách hàng Minh Phát bị lỗi 500',
                'name'        => 'Nguyễn Xuân Cường',
                'content'     => 'Sau khi deploy lên server production, trang chủ báo lỗi 500 Internal Server Error. Đã kiểm tra log, lỗi liên quan đến kết nối database.',
                'status'      => 1,
                'priority'    => 1,
                'user_id'     => $cuong,
                'assign_id'   => $cuong,
                'created_by'  => $admin,
                'created_at'  => now()->subDays(2),
                'updated_at'  => now()->subDays(2),
            ],
            [
                'ticket_code' => 'TK-002',
                'title'       => 'Khách EduStar yêu cầu thêm tính năng xuất Excel',
                'name'        => 'Trần Thanh Tịnh',
                'content'     => 'Sau buổi demo, khách hàng EduStar muốn bổ sung chức năng xuất danh sách học viên ra file Excel. Cần xác nhận có nằm trong scope hợp đồng không.',
                'status'      => 2,
                'priority'    => 2,
                'user_id'     => $tinh,
                'assign_id'   => $tinh,
                'created_by'  => $tinh,
                'created_at'  => now()->subDays(5),
                'updated_at'  => now()->subDays(1),
            ],
            [
                'ticket_code' => 'TK-003',
                'title'       => 'N8N workflow VietMove bị dừng giữa chừng',
                'name'        => 'Lê Hoàng Duy',
                'content'     => 'Workflow tự động gửi email xác nhận đơn hàng của VietMove dừng hoạt động từ tối qua. Kiểm tra thấy node HTTP Request bị timeout khi gọi API của khách.',
                'status'      => 2,
                'priority'    => 1,
                'user_id'     => $duy,
                'assign_id'   => $duy,
                'created_by'  => $admin,
                'created_at'  => now()->subDays(1),
                'updated_at'  => now()->subHours(3),
            ],
            [
                'ticket_code' => 'TK-004',
                'title'       => 'Yêu cầu xuất hóa đơn đỏ cho hợp đồng EduStar',
                'name'        => 'Nhân viên hỗ trợ',
                'content'     => 'Công ty EduStar yêu cầu xuất hóa đơn VAT điện tử đợt 1 trị giá 15.000.000đ. Cần kế toán xử lý và gửi file PDF qua email trước ngày 20.',
                'status'      => 3,
                'priority'    => 2,
                'user_id'     => $staff,
                'assign_id'   => $admin,
                'created_by'  => $staff,
                'created_at'  => now()->subDays(3),
                'updated_at'  => now()->subDays(3),
            ],
            [
                'ticket_code' => 'TK-005',
                'title'       => 'Cập nhật nội dung trang About cho Phú Cường',
                'name'        => 'Nhân viên hỗ trợ',
                'content'     => 'Khách hàng Phú Cường muốn thay ảnh banner và cập nhật lại đội ngũ nhân sự trên trang Giới thiệu. Đã nhận file ảnh qua Zalo.',
                'status'      => 3,
                'priority'    => 3,
                'user_id'     => $staff,
                'assign_id'   => $cuong,
                'created_by'  => $staff,
                'created_at'  => now()->subDays(7),
                'updated_at'  => now()->subDays(4),
                'completed_at' => now()->subDays(4),
            ],
            [
                'ticket_code' => 'TK-006',
                'title'       => 'Google Ads Spa Ngọc Lan bị từ chối duyệt quảng cáo',
                'name'        => 'Quản lý dự án',
                'content'     => 'Chiến dịch quảng cáo cho Spa Ngọc Lan bị Google từ chối vì vi phạm chính sách nội dung liên quan đến dịch vụ làm đẹp. Cần điều chỉnh nội dung ad copy và landing page.',
                'status'      => 2,
                'priority'    => 2,
                'user_id'     => User::where('email', 'manager@greenempire.com')->value('id') ?? $admin,
                'assign_id'   => $tinh,
                'created_by'  => $admin,
                'created_at'  => now()->subDays(4),
                'updated_at'  => now()->subDays(2),
            ],
        ];

        foreach ($tickets as $data) {
            Ticket::create($data);
        }

        $this->command->info('✅ TicketSeeder: Đã tạo ' . count($tickets) . ' ticket hỗ trợ.');
    }
}
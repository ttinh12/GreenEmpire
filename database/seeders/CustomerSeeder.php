<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $kd      = Department::where('code', 'KD')->value('id');
        $manager = User::where('email', 'manager@greenempire.com')->value('id');
        $cuong   = User::where('email', 'cuong.dev@greenempire.com')->value('id');
        $tinh    = User::where('email', 'tinh.dev@greenempire.com')->value('id');

        $customers = [
            [
                'code'               => 'KH001',
                'name'               => 'Công ty TNHH Thương mại Minh Phát',
                'type'               => 1,
                'address'            => '123 Nguyễn Văn Linh, Quận 7, TP.HCM',
                'province'           => 'TP. Hồ Chí Minh',
                'tax_code'           => '0312456789',
                'website'            => 'https://minhphat.vn',
                'email'              => 'contact@minhphat.vn',
                'phone'              => '028 3822 1234',
                'department_id'      => $kd,
                'account_manager_id' => $manager,
                'source'             => 'Giới thiệu',
                'status'             => 1,
                'notes'              => 'Khách hàng lâu năm, cần website thương mại điện tử và chạy ads.',
            ],
            [
                'code'               => 'KH002',
                'name'               => 'Trường THPT Phan Bội Châu',
                'type'               => 2,
                'address'            => '456 Lê Lợi, Phan Thiết, Bình Thuận',
                'province'           => 'Bình Thuận',
                'tax_code'           => '3400123456',
                'website'            => null,
                'email'              => 'phanboisthpt@edu.vn',
                'phone'              => '0252 3812 345',
                'department_id'      => $kd,
                'account_manager_id' => $tinh,
                'source'             => 'Trực tiếp',
                'status'             => 1,
                'notes'              => 'Cần phần mềm quản lý học sinh và website giới thiệu trường.',
            ],
            [
                'code'               => 'KH003',
                'name'               => 'Hộ kinh doanh Spa Ngọc Lan',
                'type'               => 2,
                'address'            => '78 Trần Hưng Đạo, Ninh Kiều, Cần Thơ',
                'province'           => 'Cần Thơ',
                'tax_code'           => null,
                'website'            => null,
                'email'              => 'ngoclan.spa@gmail.com',
                'phone'              => '0292 3945 678',
                'department_id'      => $kd,
                'account_manager_id' => $cuong,
                'source'             => 'Facebook',
                'status'             => 1,
                'notes'              => 'Muốn thiết kế landing page và chạy Facebook Ads.',
            ],
            [
                'code'               => 'KH004',
                'name'               => 'Công ty Cổ phần Logistics VietMove',
                'type'               => 1,
                'address'            => '99 Hoàng Diệu, Hải Châu, Đà Nẵng',
                'province'           => 'Đà Nẵng',
                'tax_code'           => '0401987654',
                'website'            => 'https://vietmove.vn',
                'email'              => 'it@vietmove.vn',
                'phone'              => '0236 3654 321',
                'department_id'      => $kd,
                'account_manager_id' => $manager,
                'source'             => 'Google',
                'status'             => 1,
                'notes'              => 'Cần phần mềm quản lý vận chuyển và tích hợp N8N tự động hóa.',
            ],
            [
                'code'               => 'KH005',
                'name'               => 'Công ty TNHH Giáo dục EduStar',
                'type'               => 1,
                'address'            => '12 Cách Mạng Tháng 8, Ninh Kiều, Cần Thơ',
                'province'           => 'Cần Thơ',
                'tax_code'           => '1800345678',
                'website'            => 'https://edustar.edu.vn',
                'email'              => 'admin@edustar.edu.vn',
                'phone'              => '0292 3712 000',
                'department_id'      => $kd,
                'account_manager_id' => $tinh,
                'source'             => 'Hội thảo',
                'status'             => 1,
                'notes'              => 'Muốn triển khai đào tạo AI cho giáo viên và học sinh.',
            ],
            [
                'code'               => 'KH006',
                'name'               => 'Nhà hàng Bến Ninh Kiều',
                'type'               => 2,
                'address'            => '2 Hai Bà Trưng, Ninh Kiều, Cần Thơ',
                'province'           => 'Cần Thơ',
                'tax_code'           => null,
                'website'            => null,
                'email'              => 'benninhhkieu.nt@gmail.com',
                'phone'              => '0292 3812 999',
                'department_id'      => $kd,
                'account_manager_id' => $cuong,
                'source'             => 'Zalo OA',
                'status'             => 1,
                'notes'              => 'Cần website đặt bàn online và SEO local.',
            ],
            [
                'code'               => 'KH007',
                'name'               => 'Công ty TNHH SX Nội thất Phú Cường',
                'type'               => 1,
                'address'            => '45 Quốc lộ 1A, Bình Thủy, Cần Thơ',
                'province'           => 'Cần Thơ',
                'tax_code'           => '1801234567',
                'website'            => 'https://nothattphucuong.vn',
                'email'              => 'sale@phucuong.vn',
                'phone'              => '0292 3955 777',
                'department_id'      => $kd,
                'account_manager_id' => $manager,
                'source'             => 'Giới thiệu',
                'status'             => 1,
                'notes'              => 'Cần website catalogue sản phẩm và Google Ads.',
            ],
            [
                'code'               => 'KH008',
                'name'               => 'Phòng khám Đa khoa Gia Phúc',
                'type'               => 1,
                'address'            => '34 Mậu Thân, Ninh Kiều, Cần Thơ',
                'province'           => 'Cần Thơ',
                'tax_code'           => '1800987654',
                'website'            => null,
                'email'              => 'giaPhuc.clinic@gmail.com',
                'phone'              => '0292 3822 555',
                'department_id'      => $kd,
                'account_manager_id' => $tinh,
                'source'             => 'Giới thiệu',
                'status'             => 2,
                'notes'              => 'Đang thảo luận phần mềm quản lý lịch hẹn và bệnh nhân.',
            ],
        ];

        foreach ($customers as $data) {
            Customer::create($data);
        }

        $this->command->info('✅ CustomerSeeder: Đã tạo ' . count($customers) . ' khách hàng.');
    }
}
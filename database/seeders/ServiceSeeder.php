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
        // Lấy ID của một User bất kỳ để gán vào created_by
        $adminId = User::first()?->id ?? 1;

        $services = [
            [
                'name' => 'Cung cấp Gạo ST25 hữu cơ',
                'description' => 'Gạo đặc sản Sóc Trăng, trồng theo tiêu chuẩn Organic, không thuốc trừ sâu.',
                'base_price' => 35000,
                'unit' => 'kg',
                'image_url' => 'services/st25.jpg',
            ],
            [
                'name' => 'Tư vấn lắp đặt hệ thống tưới tiêu',
                'description' => 'Thiết kế và lắp đặt hệ thống tưới nhỏ giọt tự động cho trang trại.',
                'base_price' => 5000000,
                'unit' => 'gói',
                'image_url' => 'services/irrigation.jpg',
            ],
            [
                'name' => 'Phân tích thổ nhưỡng định kỳ',
                'description' => 'Kiểm tra độ pH và dinh dưỡng trong đất để đưa ra lộ trình bón phân tối ưu.',
                'base_price' => 1200000,
                'unit' => 'mẫu',
                'image_url' => 'services/soil-test.jpg',
            ],
            [
                'name' => 'Bảo trì máy cày & thiết bị nông nghiệp',
                'description' => 'Dịch vụ bảo dưỡng tận nơi cho các thiết bị máy móc công suất lớn.',
                'base_price' => 850000,
                'unit' => 'lượt',
                'image_url' => 'services/maintenance.jpg',
            ],
            [
                'name' => 'Phát triển Website quản lý trang trại',
                'description' => 'Xây dựng hệ thống quản lý kho và bán hàng nông sản trực tuyến.',
                'base_price' => 15000000,
                'unit' => 'dự án',
                'image_url' => 'services/web-dev.jpg',
            ],
        ];

        foreach ($services as $item) {
            Service::create([
                'name' => $item['name'],
                'slug' => Str::slug($item['name']),
                'description' => $item['description'],
                'base_price' => $item['base_price'],
                'unit' => $item['unit'],
                'status' => 1,
                'image_url' => $item['image_url'],
                'created_by' => $adminId,
            ]);
        }
    }
}
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
        $adminId = User::where('email', 'admin@greenempire.com')->value('id') ?? 1;

        $services = [
            [
                'name'        => 'Thiết kế website chuẩn SEO',
                'slug'        => 'thiet-ke-website-chuan-seo',
                'description' => '<p>Thiết kế website responsive, tối ưu tốc độ, chuẩn cấu trúc SEO On-page. Bao gồm giao diện tùy chỉnh theo thương hiệu, tích hợp Google Analytics và sitemap tự động.</p>',
                'base_price'  => 8000000,
                'unit'        => 'dự án',
                'status'      => Service::STATUS_ACTIVE,
                'created_by'  => $adminId,
            ],
            [
                'name'        => 'Lập trình web theo yêu cầu',
                'slug'        => 'lap-trinh-web-theo-yeu-cau',
                'description' => '<p>Phát triển ứng dụng web full-stack theo đặc tả của khách hàng. Công nghệ: Laravel, React, Vue.js. Bàn giao source code và tài liệu kỹ thuật đầy đủ.</p>',
                'base_price'  => 15000000,
                'unit'        => 'dự án',
                'status'      => Service::STATUS_ACTIVE,
                'created_by'  => $adminId,
            ],
            [
                'name'        => 'Viết phần mềm quản lý doanh nghiệp',
                'slug'        => 'viet-phan-mem-quan-ly-doanh-nghiep',
                'description' => '<p>Xây dựng phần mềm CRM, ERP, quản lý kho, bán hàng theo quy trình thực tế của doanh nghiệp. Hỗ trợ sau bàn giao 6 tháng.</p>',
                'base_price'  => 25000000,
                'unit'        => 'dự án',
                'status'      => Service::STATUS_ACTIVE,
                'created_by'  => $adminId,
            ],
            [
                'name'        => 'Dịch vụ SEO tổng thể',
                'slug'        => 'dich-vu-seo-tong-the',
                'description' => '<p>Tối ưu website lên top Google bền vững. Bao gồm: nghiên cứu từ khóa, tối ưu On-page, xây dựng backlink chất lượng, báo cáo hàng tháng.</p>',
                'base_price'  => 3500000,
                'unit'        => 'tháng',
                'status'      => Service::STATUS_ACTIVE,
                'created_by'  => $adminId,
            ],
            [
                'name'        => 'Chạy quảng cáo Google Ads',
                'slug'        => 'chay-quang-cao-google-ads',
                'description' => '<p>Setup và quản lý chiến dịch Google Ads (Search, Display, Shopping). Tối ưu ngân sách, theo dõi chuyển đổi, báo cáo hiệu quả theo tuần.</p>',
                'base_price'  => 2000000,
                'unit'        => 'tháng',
                'status'      => Service::STATUS_ACTIVE,
                'created_by'  => $adminId,
            ],
            [
                'name'        => 'Chạy quảng cáo Facebook & TikTok Ads',
                'slug'        => 'chay-quang-cao-facebook-tiktok-ads',
                'description' => '<p>Lên chiến lược, thiết kế creative, target đúng tệp khách hàng trên Facebook và TikTok. Tối ưu CPM, CPC, ROAS theo từng giai đoạn.</p>',
                'base_price'  => 2500000,
                'unit'        => 'tháng',
                'status'      => Service::STATUS_ACTIVE,
                'created_by'  => $adminId,
            ],
            [
                'name'        => 'Đào tạo AI cho doanh nghiệp',
                'slug'        => 'dao-tao-ai-cho-doanh-nghiep',
                'description' => '<p>Chương trình đào tạo ứng dụng AI vào quy trình vận hành: ChatGPT, Gemini, Claude, Midjourney. Thực hành trực tiếp trên bài toán thực tế của doanh nghiệp.</p>',
                'base_price'  => 5000000,
                'unit'        => 'khóa',
                'status'      => Service::STATUS_ACTIVE,
                'created_by'  => $adminId,
            ],
            [
                'name'        => 'Triển khai tự động hóa N8N',
                'slug'        => 'trien-khai-tu-dong-hoa-n8n',
                'description' => '<p>Xây dựng workflow tự động hóa quy trình kinh doanh với N8N: kết nối CRM, email marketing, Zalo OA, Google Sheets, Slack và hơn 400 ứng dụng khác.</p>',
                'base_price'  => 6000000,
                'unit'        => 'dự án',
                'status'      => Service::STATUS_ACTIVE,
                'created_by'  => $adminId,
            ],
            [
                'name'        => 'Bảo trì & hỗ trợ kỹ thuật website',
                'slug'        => 'bao-tri-ho-tro-ky-thuat-website',
                'description' => '<p>Gói bảo trì định kỳ: backup dữ liệu, cập nhật plugin, vá lỗi bảo mật, theo dõi uptime 24/7, hỗ trợ kỹ thuật qua Zalo/email trong giờ hành chính.</p>',
                'base_price'  => 800000,
                'unit'        => 'tháng',
                'status'      => Service::STATUS_ACTIVE,
                'created_by'  => $adminId,
            ],
            [
                'name'        => 'Thiết kế UI/UX ứng dụng di động',
                'slug'        => 'thiet-ke-ui-ux-ung-dung-di-dong',
                'description' => '<p>Nghiên cứu người dùng, wireframe, prototype và thiết kế giao diện app iOS/Android. Bàn giao file Figma có đầy đủ component system và design token.</p>',
                'base_price'  => 10000000,
                'unit'        => 'dự án',
                'status'      => Service::STATUS_ACTIVE,
                'created_by'  => $adminId,
            ],
            [
                'name'        => 'Lập trình app di động (Flutter)',
                'slug'        => 'lap-trinh-app-di-dong-flutter',
                'description' => '<p>Phát triển ứng dụng di động đa nền tảng iOS và Android bằng Flutter. Tích hợp API, push notification, thanh toán online và phát hành lên App Store / CH Play.</p>',
                'base_price'  => 30000000,
                'unit'        => 'dự án',
                'status'      => Service::STATUS_ACTIVE,
                'created_by'  => $adminId,
            ],
            [
                'name'        => 'Tư vấn chuyển đổi số',
                'slug'        => 'tu-van-chuyen-doi-so',
                'description' => '<p>Phân tích quy trình hiện tại, đề xuất lộ trình số hóa phù hợp ngân sách và mục tiêu. Bao gồm lựa chọn công nghệ, kế hoạch triển khai và đào tạo nhân sự.</p>',
                'base_price'  => 4000000,
                'unit'        => 'buổi',
                'status'      => Service::STATUS_ACTIVE,
                'created_by'  => $adminId,
            ],
        ];

        foreach ($services as $data) {
            Service::create($data);
        }

        $this->command->info('✅ ServiceSeeder: Đã tạo ' . count($services) . ' dịch vụ CNTT.');
    }
}
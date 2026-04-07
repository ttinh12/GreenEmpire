<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Dùng inRandomOrder() để an toàn hơn cho team
            'invoice_id' => Invoice::inRandomOrder()->first()?->id ?? Invoice::factory(),

            'item_order' => $this->faker->numberBetween(1, 5),
            'description' => $this->faker->randomElement([
                'Dịch vụ cài đặt phần mềm nông nghiệp',
                'Cung cấp thiết bị cảm biến độ ẩm',
                'Phí duy trì hệ thống GreenEmpire tháng ' . now()->month,
                'Tư vấn chuyển đổi số nông nghiệp'
            ]),
            'unit' => $this->faker->randomElement(['gói', 'giờ', 'lô', 'bộ']),

            // Dùng số thực cho khớp với kiểu decimal(10, 2) trong Migration
            'quantity' => $this->faker->randomFloat(2, 1, 10),
            'unit_price' => $this->faker->randomFloat(2, 500000, 10000000),

            'vat_rate' => 10.00,
            // Tuyệt đối không thêm 'amount' vào đây
        ];
    }
}
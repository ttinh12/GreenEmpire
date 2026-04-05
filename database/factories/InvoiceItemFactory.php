<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'invoice_id' => Invoice::pluck('id')->random() ?? Invoice::factory(),
            'item_order' => $this->faker->numberBetween(1, 5),
            'description' => $this->faker->randomElement([
                'Dịch vụ cài đặt phần mềm', 
                'Cung cấp thiết bị nông nghiệp', 
                'Phí duy trì hệ thống tháng ' . now()->month,
                'Tư vấn chuyển đổi số'
            ]),
            'unit' => $this->faker->randomElement(['gói', 'giờ', 'lô', 'bộ']),
            'quantity' => $this->faker->numberBetween(1, 10),
            'unit_price' => $this->faker->numberBetween(500000, 10000000),
            'vat_rate' => 10.00,
        ];
    }
}
<?php

namespace Database\Factories;

use App\Models\Contract;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractItemFactory extends Factory
{
public function definition(): array
{
    return [
        // Dùng inRandomOrder() để an toàn hơn
        'contract_id' => Contract::inRandomOrder()->first()?->id ?? Contract::factory(),
        
        'item_order' => $this->faker->numberBetween(1, 5),
        'description' => $this->faker->randomElement([
            'Cung cấp phân bón NPK', 
            'Hệ thống tưới tiêu tự động', 
            'Hạt giống lúa chất lượng cao',
            'Dịch vụ tư vấn kỹ thuật'
        ]),
        'unit' => $this->faker->randomElement(['bao', 'bộ', 'kg', 'giờ']),
        
        // Quantity và unit_price nên dùng số thực hoặc số lớn cho khớp decimal
        'quantity' => $this->faker->randomFloat(2, 1, 100), 
        'unit_price' => $this->faker->randomFloat(2, 50000, 5000000),
        
        'notes' => $this->faker->sentence(),
        // KHÔNG THÊM 'amount' VÀO ĐÂY NHÉ!
    ];
}}
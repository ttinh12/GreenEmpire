<?php

namespace Database\Factories;

use App\Models\Contract;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'contract_id' => Contract::pluck('id')->random() ?? Contract::factory(),
            'item_order' => $this->faker->numberBetween(1, 5),
            'description' => $this->faker->randomElement([
                'Cung cấp phân bón NPK', 
                'Hệ thống tưới tiêu tự động', 
                'Hạt giống lúa chất lượng cao',
                'Dịch vụ tư vấn kỹ thuật'
            ]),
            'unit' => $this->faker->randomElement(['bao', 'bộ', 'kg', 'giờ']),
            'quantity' => $this->faker->numberBetween(1, 50),
            'unit_price' => $this->faker->numberBetween(100000, 2000000),
            'notes' => $this->faker->sentence(),
        ];
    }
}
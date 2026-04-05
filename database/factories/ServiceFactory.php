<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ServiceFactory extends Factory
{
    public function definition(): array
    {
        // Thêm faker->words hoặc số ngẫu nhiên để tên luôn khác biệt
        $name = $this->faker->sentence(3) . ' ' . $this->faker->unique()->numberBetween(1, 9999);

        return [
            'name' => $name,
            'slug' => Str::slug($name), // Slug sẽ tự duy nhất vì name đã có số
            'description' => $this->faker->paragraph(),
            'base_price' => $this->faker->randomFloat(2, 10000, 10000000),
            'unit' => $this->faker->randomElement(['kg', 'gói', 'giờ', 'lượt', 'dự án']),
            'status' => 1,
            'image_url' => 'services/default.jpg',
            // Đảm bảo lấy ID user có sẵn hoặc tạo mới
            'created_by' => User::pluck('id')->random() ?? User::factory(),
        ];
    }
}
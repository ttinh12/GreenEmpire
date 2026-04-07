<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition(): array
    {
        return [
            // Lấy ID khách hàng hiện có hoặc tạo mới
            'customer_id' => Customer::inRandomOrder()->first()?->id ?? Customer::factory(),
            
            'name' => $this->faker->name(),
            'position' => $this->faker->randomElement(['Giám đốc', 'Trưởng phòng', 'Kế toán', 'Nhân viên thu mua']),
            'department' => $this->faker->randomElement(['Kinh doanh', 'Kỹ thuật', 'Hành chính', 'Sản xuất']),
            'phone' => $this->faker->phoneNumber(),
            'mobile' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            
            // 20% cơ hội là người liên hệ chính
            'is_primary' => $this->faker->boolean(20), 
            
            'notes' => $this->faker->sentence(),
        ];
    }
}
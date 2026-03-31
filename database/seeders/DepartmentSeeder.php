<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

use App\Models\Department;

class DepartmentSeeder extends Seeder
{



    /**
     * Run the database seeds.
     */
   public function run(): void
{
    DB::table('departments')->insert([
        [
            'code' => 'IT',
            'name' => 'Phòng Công nghệ thông tin',
            'description' => 'Quản lý hệ thống và phần mềm',
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'code' => 'HR',
            'name' => 'Phòng Nhân sự',
            'description' => 'Quản lý nhân sự',
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'code' => 'MK',
            'name' => 'Phòng Marketing',
            'description' => 'Marketing và truyền thông',
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'code' => 'KD',
            'name' => 'Phòng Kinh doanh',
            'description' => 'Quản lý khách hàng và bán hàng',
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'code' => 'KT',
            'name' => 'Phòng Kế toán',
            'description' => 'Quản lý tài chính',
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);
}

}
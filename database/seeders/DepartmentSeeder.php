<?php

namespace Database\Seeders;



use Illuminate\Database\Seeder;

use App\Models\Department;

class DepartmentSeeder extends Seeder
{



    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Department::factory()->count(10)->create();

        Department::create([
            'code' => 'BM_DT',
            'name' => 'Bo mon Dien tu',
            'description' => 'Bo mon dien tu chuyen ve linh vuc dien tu va tu dong hoa',
            'is_active' => 1,
        ],);
    }
}

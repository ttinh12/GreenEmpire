<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deptId = Department::value('id') ?? Department::factory()->create(['name' => 'Ban Giám Đốc'])->id;

        // 1. Super Admin (thêm vào để đồng bộ Shield)
        User::updateOrCreate(
            ['email' => 'superadmin@greenempire.com'],
            [
                'id'                => 1, // Cố định ID = 1 cho Super Admin
                'name'              => 'Super Quản Trị Viên',
                'password'          => Hash::make('123456'),
                'department_id'     => $deptId,
                'is_active'         => 1,
                'email_verified_at' => now(),
            ]
        );

        // 2. Admin
        User::updateOrCreate(
            ['email' => 'admin@greenempire.com'],
            [
                'name'              => 'Quản Trị Viên',
                'password'          => Hash::make('123456'),
                'department_id'     => $deptId,
                'is_active'         => 1,
                'email_verified_at' => now(),
            ]
        );

        // 3. Manager
        User::updateOrCreate(
            ['email' => 'manager@greenempire.com'],
            [
                'name'              => 'Quản Lý',
                'password'          => Hash::make('123456'),
                'department_id'     => $deptId,
                'is_active'         => 1,
                'email_verified_at' => now(),
            ]
        );

        // 4. Staff
        User::updateOrCreate(
            ['email' => 'staff@greenempire.com'],
            [
                'name'              => 'Nhân Viên',
                'password'          => Hash::make('123456'),
                'department_id'     => $deptId,
                'is_active'         => 1,
                'email_verified_at' => now(),
            ]
        );

        // 5. Random users
        User::factory()->count(10)->create();

        // Gán roles (chạy sau khi Shield đã setup)
        $superAdminUser = User::where('email', 'superadmin@greenempire.com')->first();
        $adminUser      = User::where('email', 'admin@greenempire.com')->first();
        $managerUser    = User::where('email', 'manager@greenempire.com')->first();
        $staffUser      = User::where('email', 'staff@greenempire.com')->first();

        // Gán role theo Shield chuẩn
        if (\Spatie\Permission\Models\Role::where('name', 'super_admin')->exists()) {
            $superAdminUser->syncRoles(['super_admin']); // Cấp toàn quyền
        }

        if (\Spatie\Permission\Models\Role::where('name', 'admin')->exists()) {
            $adminUser->syncRoles(['admin']);
            $managerUser->syncRoles(['manager']);
            $staffUser->syncRoles(['staff']);
        }
    }
}
<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $bgd = Department::where('code', 'BGD')->value('id');
        $dev = Department::where('code', 'DEV')->value('id');
        $des = Department::where('code', 'DES')->value('id');
        $mkt = Department::where('code', 'MKT')->value('id');
        $ai  = Department::where('code', 'AI')->value('id');
        $kd  = Department::where('code', 'KD')->value('id');

        // ── Tài khoản hệ thống ─────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'superadmin@greenempire.com'],
            [
                'id'                => 1,
                'name'              => 'Quản trị hệ thống',
                'password'          => Hash::make('123456'),
                'department_id'     => $bgd,
                'is_active'         => 1,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@greenempire.com'],
            [
                'name'              => 'Trưởng xưởng CNTT',
                'password'          => Hash::make('123456'),
                'department_id'     => $bgd,
                'is_active'         => 1,
                'email_verified_at' => now(),
            ]
        );

        // ── Nhóm Lập trình ─────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'cuong.dev@greenempire.com'],
            [
                'name'              => 'Nguyễn Xuân Cường',
                'password'          => Hash::make('123456'),
                'department_id'     => $dev,
                'is_active'         => 1,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'tinh.dev@greenempire.com'],
            [
                'name'              => 'Trần Thanh Tịnh',
                'password'          => Hash::make('123456'),
                'department_id'     => $dev,
                'is_active'         => 1,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'duy.dev@greenempire.com'],
            [
                'name'              => 'Lê Hoàng Duy',
                'password'          => Hash::make('123456'),
                'department_id'     => $dev,
                'is_active'         => 1,
                'email_verified_at' => now(),
            ]
        );

        // ── Nhóm Thiết kế ──────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'xum.design@greenempire.com'],
            [
                'name'              => 'Phạm Công Xum',
                'password'          => Hash::make('123456'),
                'department_id'     => $des,
                'is_active'         => 1,
                'email_verified_at' => now(),
            ]
        );

        // ── Nhóm Marketing ─────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'manager@greenempire.com'],
            [
                'name'              => 'Quản lý dự án',
                'password'          => Hash::make('123456'),
                'department_id'     => $kd,
                'is_active'         => 1,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff@greenempire.com'],
            [
                'name'              => 'Nhân viên hỗ trợ',
                'password'          => Hash::make('123456'),
                'department_id'     => $kd,
                'is_active'         => 1,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'ai.trainer@greenempire.com'],
            [
                'name'              => 'Giảng viên AI & N8N',
                'password'          => Hash::make('123456'),
                'department_id'     => $ai,
                'is_active'         => 1,
                'email_verified_at' => now(),
            ]
        );

        // ── Gán role ───────────────────────────────────────────────────
        $roleExists = fn($name) => \Spatie\Permission\Models\Role::where('name', $name)->exists();

        if ($roleExists('super_admin')) {
            User::where('email', 'superadmin@greenempire.com')->first()?->syncRoles(['super_admin']);
        }
        if ($roleExists('admin')) {
            User::where('email', 'admin@greenempire.com')->first()?->syncRoles(['admin']);
            User::where('email', 'manager@greenempire.com')->first()?->syncRoles(['manager']);
            User::where('email', 'staff@greenempire.com')->first()?->syncRoles(['staff']);
        }

        $this->command->info('✅ UserSeeder: Đã tạo thành viên xưởng CNTT.');
    }
}
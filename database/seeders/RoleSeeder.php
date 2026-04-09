<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ========== 1. SUPER ADMIN (full quyền) ==========
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions(Permission::all());

        // ========== 2. ADMIN (full quyền) ==========
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions(Permission::all());

        // ========== 3. MANAGER (quyền hạn chế) ==========
        $manager = Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'web']);
        $manager->syncPermissions(Permission::whereIn('name', [
            // Customer
            'ViewAny:Customer',
            'View:Customer',
            'Create:Customer',
            'Update:Customer',
            // Contact
            'ViewAny:Contact',
            'View:Contact',
            'Create:Contact',
            'Update:Contact',
            // CustomerNote
            'ViewAny:CustomerNote',
            'View:CustomerNote',
            'Create:CustomerNote',
            'Update:CustomerNote',
            // Task
            'ViewAny:Task',
            'View:Task',
            'Create:Task',
            'Update:Task',
            'Delete:Task',
            'DeleteAny:Task',
            'Restore:Task',
            'RestoreAny:Task',
            'Reorder:Task',
            // Ticket
            'ViewAny:Ticket',
            'View:Ticket',
            'Create:Ticket',
            'Update:Ticket',
            'Delete:Ticket',
            'DeleteAny:Ticket',
            // Department - chỉ xem
            'ViewAny:Department',
            'View:Department',
            // User - chỉ xem
            'ViewAny:User',
            'View:User',
            // Profile - tự quản lý profile của mình
            'View:UserProfile',
            'Update:UserProfile',
        ])->get());

        // ========== 4. STAFF (quyền cơ bản nhất) ==========
        $staff = Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);
        $staff->syncPermissions(Permission::whereIn('name', [
            // Chỉ xem Customer, Contact
            'ViewAny:Customer',
            'View:Customer',
            'ViewAny:Contact',
            'View:Contact',
            // Task - xem + sửa task của mình
            'ViewAny:Task',
            'View:Task',
            'Update:Task',
            'Reorder:Task',
            // Ticket - tạo + sửa
            'ViewAny:Ticket',
            'View:Ticket',
            'Create:Ticket',
            'Update:Ticket',
            // Department, User - chỉ xem
            'ViewAny:Department',
            'View:Department',
            'ViewAny:User',
            'View:User',
            // Profile
            'View:UserProfile',
            'Update:UserProfile',
        ])->get());

        $this->command->info('✅ Roles và Permissions đã được gán thành công!');
        $this->command->info('📊 super_admin: ' . $superAdmin->permissions->count() . ' permissions');
        $this->command->info('📊 admin: ' . $admin->permissions->count() . ' permissions');
        $this->command->info('📊 manager: ' . $manager->permissions->count() . ' permissions');
        $this->command->info('📊 staff: ' . $staff->permissions->count() . ' permissions');
    }
}

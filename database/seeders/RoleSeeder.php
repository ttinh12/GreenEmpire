<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Xóa cache để cập nhật quyền mới
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. ĐỊNH NGHĨA VÀ TẠO PERMISSIONS (Quan trọng nhất - bước này giúp bảng hết trống)
        $allPermissions = [
            // Customer
            'ViewAny:Customer',
            'View:Customer',
            'Create:Customer',
            'Update:Customer',
            'Delete:Customer',
            // Ticket
            'ViewAny:Ticket',
            'View:Ticket',
            'Create:Ticket',
            'Update:Ticket',
            'Delete:Ticket',
            'DeleteAny:Ticket',
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
            // Service
            'ViewAny:Service',
            'View:Service',
            'Create:Service',
            'Update:Service',
            'Delete:Service',
            // User, Dept, v.v...
            'ViewAny:User',
            'View:User',
            'ViewAny:Department',
            'View:Department',
            'ViewAny:Contact',
            'View:Contact',
            'Create:Contact',
            'Update:Contact',
            'ViewAny:CustomerNote',
            'View:CustomerNote',
            'Create:CustomerNote',
            'Update:CustomerNote',
        ];

        foreach ($allPermissions as $permission) {
            // Lệnh này sẽ tạo permission vào bảng 'permissions' nếu nó chưa có
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // 3. TẠO ROLE VÀ GÁN QUYỀN (Lúc này bảng đã có dữ liệu nên gán mới ăn)

        // Admin: Toàn quyền
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions(Permission::all());

        // Manager: Quyền hạn chế hơn
        $manager = Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'web']);
        $manager->syncPermissions(Permission::whereIn('name', [
            'ViewAny:Customer',
            'View:Customer',
            'Create:Customer',
            'Update:Customer',
            'ViewAny:Ticket',
            'View:Ticket',
            'Create:Ticket',
            'Update:Ticket',
            'ViewAny:Task',
            'View:Task',
            'Create:Task',
            'Update:Task',
            'Delete:Task',
            'ViewAny:User',
            'View:User',
        ])->get());

        // Staff: Quyền cơ bản
        $staff = Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);
        $staff->syncPermissions(Permission::whereIn('name', [
            'ViewAny:Ticket',
            'View:Ticket',
            'Create:Ticket',
            'Update:Ticket',
            'ViewAny:Task',
            'View:Task',
            'Update:Task',
        ])->get());

        $this->command->info('✅ Roles và Permissions đã được tạo và gán thành công!');
    }
}

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

        // Tất cả permissions Shield đã generate (110 permissions)
        $resources = [
            'Contact', 'Customer', 'CustomerNote', 'Department',
            'Role', 'Service', 'Task', 'Ticket', 'User',
        ];

        $actions = [
            'ViewAny', 'View', 'Create', 'Update', 'Delete',
            'DeleteAny', 'ForceDelete', 'ForceDeleteAny',
            'Restore', 'RestoreAny', 'Reorder', 'Replicate',
        ];

        // Tạo permissions cho tất cả resources
        foreach ($resources as $resource) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name'       => "{$action}:{$resource}",
                    'guard_name' => 'web',
                ]);
            }
        }

        // Widgets
        Permission::firstOrCreate(['name' => 'View:MyCalendarWidget',        'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'View:TicketPerformanceWidget', 'guard_name' => 'web']);

        // -------------------------------------------------------
        // ADMIN: Toàn quyền
        // -------------------------------------------------------
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions(Permission::all());

        // -------------------------------------------------------
        // MANAGER: Quản lý nghiệp vụ, không đụng Role/Dept/ForceDelete
        // -------------------------------------------------------
        $manager = Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'web']);
        $manager->syncPermissions([
            // Customer
            'ViewAny:Customer', 'View:Customer', 'Create:Customer',
            'Update:Customer', 'Delete:Customer', 'Replicate:Customer',
            // Ticket
            'ViewAny:Ticket', 'View:Ticket', 'Create:Ticket',
            'Update:Ticket', 'Delete:Ticket', 'DeleteAny:Ticket',
            // Task
            'ViewAny:Task', 'View:Task', 'Create:Task',
            'Update:Task', 'Delete:Task', 'DeleteAny:Task',
            'Restore:Task', 'Reorder:Task',
            // Service
            'ViewAny:Service', 'View:Service',
            'Create:Service', 'Update:Service',
            // Contact
            'ViewAny:Contact', 'View:Contact',
            'Create:Contact', 'Update:Contact', 'Delete:Contact',
            // CustomerNote
            'ViewAny:CustomerNote', 'View:CustomerNote',
            'Create:CustomerNote', 'Update:CustomerNote',
            // User & Department (chỉ xem)
            'ViewAny:User', 'View:User',
            'ViewAny:Department', 'View:Department',
            // Widgets
            'View:MyCalendarWidget', 'View:TicketPerformanceWidget',
        ]);

        // -------------------------------------------------------
        // STAFF: Chỉ làm việc với Ticket & Task được giao
        // -------------------------------------------------------
        $staff = Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);
        $staff->syncPermissions([
            // Ticket
            'ViewAny:Ticket', 'View:Ticket',
            'Create:Ticket', 'Update:Ticket',
            // Task
            'ViewAny:Task', 'View:Task', 'Update:Task',
            // CustomerNote (chỉ xem & thêm)
            'ViewAny:CustomerNote', 'View:CustomerNote',
            'Create:CustomerNote',
            // Widget
            'View:MyCalendarWidget',
        ]);

        $this->command->info('✅ Roles và Permissions đã được tạo thành công!');
    }
}
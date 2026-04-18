<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            DepartmentSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            ServiceSeeder::class,
            TransactionCategorySeeder::class,
            CustomerSeeder::class,
            TicketSeeder::class,
            ContractSeeder::class,
            ContractItemSeeder::class,
            InvoiceSeeder::class,
            InvoiceItemSeeder::class,
            PaymentSeeder::class,
            TransactionSeeder::class,
            TaskSeeder::class,
            CustomerNoteSeeder::class,
            ContactSeeder::class,
        ]);

        // Cấp quyền super_admin cho tài khoản đầu tiên (id=1)
        Artisan::call('shield:super-admin', [
            '--user'  => 1,
            '--panel' => 'admin',
        ]);

        $this->command->info('');
        $this->command->info('🎉 Seeding hoàn tất! Tài khoản đăng nhập:');
        $this->command->table(
            ['Role', 'Email', 'Mật khẩu'],
            [
                ['Super Admin', 'superadmin@greenempire.com', '123456'],
                ['Admin',       'admin@greenempire.com',      '123456'],
                ['Manager',     'manager@greenempire.com',    '123456'],
                ['Staff',       'staff@greenempire.com',      '123456'],
            ]
        );
    }
}
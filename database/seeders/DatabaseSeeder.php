<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            DepartmentSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            ServiceSeeder::class,
            TransactionCategorySeeder::class,
            TicketSeeder::class,
            CustomerSeeder::class,
            ContractSeeder::class,
            ContractItemSeeder::class,
            InvoiceSeeder::class,
            InvoiceItemSeeder::class,
            PaymentSeeder::class,
            TransactionSeeder::class,
            TaskSeeder::class,
            CustomerNoteSeeder::class,

        ]);

        // user random
        User::factory()->count(5)->create();

        // Gán super_admin (chạy sau UserSeeder để user đã tồn tại)
        Artisan::call('shield:super-admin', [
            '--user'  => 1,
            '--panel' => 'admin',
        ]);
    }
}

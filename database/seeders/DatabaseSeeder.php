<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
        RoleSeeder::class,
    ]); 

    // user random
    User::factory()->count(5)->create();
    
}
}

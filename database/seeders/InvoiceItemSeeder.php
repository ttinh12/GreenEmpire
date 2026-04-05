<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Database\Seeder;

class InvoiceItemSeeder extends Seeder
{
    public function run(): void
    {
        $invoices = Invoice::all();

        foreach ($invoices as $invoice) {
            InvoiceItem::factory()
                ->count(rand(1, 3))
                ->create(['invoice_id' => $invoice->id]);
        }
    }
}
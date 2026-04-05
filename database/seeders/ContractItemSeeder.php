<?php

namespace Database\Seeders;

use App\Models\Contract;
use App\Models\ContractItem;
use Illuminate\Database\Seeder;

class ContractItemSeeder extends Seeder
{
    public function run(): void
    {
        $contracts = Contract::all();

        foreach ($contracts as $contract) {
            // Mỗi hợp đồng tạo ngẫu nhiên từ 2 đến 4 hạng mục con
            ContractItem::factory()
                ->count(rand(2, 4))
                ->create(['contract_id' => $contract->id]);
        }
    }
}
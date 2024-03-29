<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Warehouse::create([
            'name' => 'Rep. Elettrico HQ',
            'description' => "Capannone A - Pianoro",
            'fallback_emails' => 'info@uff-acquisti-HQ.com',
        ]);

//        \App\Models\Warehouse::create([
//            'name' => 'Rep. Elettrico Neri',
//            // 'description' => "Capannone A - Pianoro",
//            'fallback_emails' => 'info@uff-acquisti-NERI.com',
//        ]);
    }
}

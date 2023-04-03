<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=1; $i < 22; $i+=2) {
            Stock::create([
                'product_id' => $i,
                'quantity' => rand(1, 30),
            ]);
        }
    }
}

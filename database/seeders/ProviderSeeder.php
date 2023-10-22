<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Provider::create([
            'name' => 'FABBI IMOLA',
            'emails' => 'orders@stika.com',
            'provider_code' => '120035'
        ]);

        \App\Models\Provider::create([
            'name' => 'TECO',
            'emails' => 'orders@stika.com',
            'provider_code' => '101895'
        ]);
    }
}

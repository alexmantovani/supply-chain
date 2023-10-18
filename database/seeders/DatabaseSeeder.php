<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = \App\Models\User::factory()->create([
            'name' => 'Alex Mantovani',
            'email' => 'a@a.a',
            'password' => Hash::make('12345678'),
        ]);
        $user->assignRole(['super-admin', 'RUA']);

        $user = \App\Models\User::factory()->create([
            'name' => 'Mirko Benni',
            'email' => 'mirko@mirko.com',
            'password' => Hash::make('MsrLLu&tD2'),
        ]);
        $user->assignRole('RRE');

        $user = \App\Models\User::factory()->create([
            'name' => 'Nicolò Cuoghi',
            'email' => 'nicolo@nicolo.com',
            'password' => Hash::make('%Z8wPtSJ54'),
        ]);
        $user->assignRole('RRE');

        $user = \App\Models\User::factory()->create([
            'name' => 'Giulia Passini',
            'email' => 'giulia@giulia.com',
            'password' => Hash::make('i7X&G&FG7D'),
        ]);
        $user->assignRole('RUA');

        $user = \App\Models\User::factory()->create([
            'name' => 'Lorenzo Miti',
            'email' => 'lorenzo@lorenzo.com',
            'password' => Hash::make('HJGj7&hy1'),
        ]);
        $user->assignRole('RUA');

        // $provider = \App\Models\Provider::create([
        //     'name' => 'Marchesini warehouse',
        //     'description' => "Magazzino generale Marchesini Group",
        //     'email' => 'orders@stika.com',
        //     'provider_code' => '1234567'
        // ]);

        // for ($i = 1; $i <= 2; $i++) {
        //     \App\Models\Warehouse::create([
        //         'name' => 'Magazzino ' . $i,
        //         'description' => fake()->sentence(),
        //     ]);
        // }

        // \App\Models\User::factory(100)->create();

        $this->call([
            WarehouseSeeder::class,
            ProviderSeeder::class, // Questa deve essere chiamata prima del ProductSeeder
            ProductStatusSeeder::class,
            ProductSeeder::class,
        ]);
    }
}

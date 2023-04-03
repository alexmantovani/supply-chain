<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'name' => 'Mario Pompeo',
            'email' => 'a@a.a',
            'password' => Hash::make('12345678'),
        ]);

        $user = \App\Models\User::factory()->create([
            'name' => 'Vincenzo Rossi',
            'email' => 'b@b.b',
            'password' => Hash::make('12345678'),
        ]);

        $user = \App\Models\User::factory()->create([
            'name' => 'Luca Favero',
            'email' => 'luca@luca.com',
            'password' => Hash::make('qwertyuiop'),
        ]);

        \App\Models\User::factory(100)->create();
        \App\Models\Dealer::factory(100)->create();

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            ProductSeeder::class,
            StockSeeder::class,
        ]);

        \App\Models\Refill::factory(7)->create();

    }
}

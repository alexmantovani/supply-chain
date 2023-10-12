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
        // // Permessi
        // Permission::create(['name' => 'edit warehouse']);
        // Permission::create(['name' => 'create warehouse']);
        // Permission::create(['name' => 'delete warehouse']);
        // Permission::create(['name' => 'change warehouse']);
        // Permission::create(['name' => 'handle order']);

        // Permission::create(['name' => 'admin site']);

        // // Ruoli
        // $role = Role::create(['name' => 'super-admin']);

        // $role = Role::create(['name' => 'admin']);
        // $role->givePermissionTo('change warehouse');
        // $role->givePermissionTo('handle order');


        $user = \App\Models\User::factory()->create([
            'name' => 'Alex Mantovani',
            'email' => 'a@a.a',
            'password' => Hash::make('12345678'),
        ]);
        $user->assignRole(['super-admin', 'admin']);

        $user = \App\Models\User::factory()->create([
            'name' => 'Mirko Benni',
            'email' => 'mirko@mirko.com',
            'password' => Hash::make('MsrLLu&tD2'),
        ]);
        $user->assignRole('admin');

        $user = \App\Models\User::factory()->create([
            'name' => 'Nicolò Cuoghi',
            'email' => 'nicolo@nicolo.com',
            'password' => Hash::make('%Z8wPtSJ54'),
        ]);
        $user->assignRole('admin');

        $user = \App\Models\User::factory()->create([
            'name' => 'Giulia Passini',
            'email' => 'giulia@giulia.com',
            'password' => Hash::make('i7X&G&FG7D'),
        ]);
        $user->assignRole('admin');


        // $provider = \App\Models\Provider::create([
        //     'name' => 'Marchesini warehouse',
        //     'description' => "Magazzino generale Marchesini Group",
        //     'email' => 'orders@stika.com',
        //     'provider_code' => '1234567'
        // ]);

        for ($i = 1; $i <= 2; $i++) {
            \App\Models\Warehouse::create([
                'name' => 'Magazzino ' . $i,
                'description' => fake()->sentence(),
            ]);
        }

        // \App\Models\User::factory(100)->create();

        $this->call([
            ProductStatusSeeder::class,
            ProductSeeder::class,
        ]);
    }
}

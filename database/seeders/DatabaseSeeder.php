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
            'name' => 'Mario Pompeo',
            'email' => 'a@a.a',
            'password' => Hash::make('12345678'),
        ]);
        $user->assignRole(['super-admin', 'admin']);

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
        $user->assignRole('admin');


        $provider = \App\Models\Provider::create([
            'name' => 'Marchesini warehouse',
            'description' => "Magazzino generale Marchesini Group",
            'email' => 'orders@stika.com',
        ]);

        for ($i = 1; $i <= 5; $i++) {
            \App\Models\Warehouse::create([
                'name' => 'Magazzino ' . $i,
                'description' => fake()->sentence(),
            ]);
        }

        \App\Models\User::factory(100)->create();

        $this->call([
            ProductStatusSeeder::class,
            ProductSeeder::class,
        ]);
    }
}

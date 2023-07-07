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

        // Prima azienda
        $company = \App\Models\Company::factory()
            ->has(\App\Models\User::factory()->count(30))
            ->has(\App\Models\Warehouse::factory()->count(1))
            ->create();

        $user = \App\Models\User::factory()->create([
            'name' => 'Mario Pompeo',
            'email' => 'a@a.a',
            'password' => Hash::make('12345678'),
        ]);
        $user->companies()->attach($company->id);
        $user->assignRole(['super-admin', 'admin']);

        $user = \App\Models\User::factory()->create([
            'name' => 'Vincenzo Rossi',
            'email' => 'b@b.b',
            'password' => Hash::make('12345678'),
        ]);
        $user->companies()->attach($company->id);
        $user->assignRole(['supervisor']);

        $user = \App\Models\User::factory()->create([
            'name' => 'Luca Favero',
            'email' => 'luca@luca.com',
            'password' => Hash::make('qwertyuiop'),
        ]);
        $user->companies()->attach($company->id);
        $user->assignRole('admin');


        $provider = \App\Models\Provider::create([
            'name' => 'Marchesini warehouse',
            'description' => "Magazzino generale Marchesini Group",
            'email' => 'orders@stika.com',
            'company_id' => $company->id,
        ]);

        for ($i = 1; $i <= 5; $i++) {
            \App\Models\Warehouse::create([
                'name' => 'Magazzino ' . $i,
                'description' => fake()->sentence(),
                'company_id' => $company->id,
            ]);
        }

        // Seconda azienda
        $company = \App\Models\Company::factory()
            ->has(\App\Models\User::factory()->count(30))
            ->has(\App\Models\Warehouse::factory()->count(5))
            ->create();

        $user = \App\Models\User::factory()->create([
            'name' => 'Utente azienda 2',
            'email' => '2@2.2',
            'password' => Hash::make('12345678'),
        ]);
        $user->companies()->attach($company->id);
        $user->assignRole(['super-admin', 'admin']);

        // \App\Models\User::factory(100)->create();

        // Utente 3 che è associato ad entrambe le compagnie
        $user = \App\Models\User::factory()->create([
            'name' => 'Utente a 2 aziende',
            'email' => '3@3.3',
            'password' => Hash::make('12345678'),
        ]);
        $user->companies()->attach(1, ['is_active' => true]);
        $user->companies()->attach(2);

        $user->assignRole(['admin']);

        $this->call([
            ProductStatusSeeder::class,
            ProductSeeder::class,
        ]);
    }
}

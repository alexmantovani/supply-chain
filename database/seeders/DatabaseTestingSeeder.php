<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseTestingSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Creo 5 utenti
        \App\Models\User::factory(5)->create();

        // Creo 2 provider
        \App\Models\Provider::factory()->create();
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

        // TODO: il provider_id non esiste più in dealer
        // Creo i venditori
        \App\Models\Dealer::factory(10)->create([
            'provider_id' => 1,
        ]);
        \App\Models\Dealer::factory(10)->create([
            'provider_id' => 2,
        ]);

        // Creo i prodotti
        // 3 legati a produttori che rifornisce il 1° provider
        \App\Models\Product::factory(3)->create([
            'dealer_id' => 1,
        ]);
        // 2 legati a produttori che rifornisce la MG
        \App\Models\Product::factory(2)->create([
            'dealer_id' => 20,
        ]);


        \App\Models\Refill::factory()->create([
            'product_id' => 5, // Prodotto di un produttore rifornito dal magazzino MG
            'warehouse_id' => 1, // Richiesta effettuata dal magazzino 1
        ]);


        /*
        \App\Models\Dealer::factory(100)->create([
            'provider_id' => $provider->id,
        ]);

        // \App\Models\User::factory(10)->create();

        $this->call([
            ProductSeeder::class,
        ]);

        \App\Models\Refill::factory(7)->create();
        */
    }
}

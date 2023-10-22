<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Dealer;
use App\Models\ProductStatus;
use App\Models\Provider;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Acqusizione dati DB Altena
        // if (($handle = fopen(resource_path('extras/distinta_materiale.csv'), "r")) !== FALSE) {
        //     while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        //         $code = $data[0];
        //         if ($code == 'Articolo') continue;

        //         // Dati relativi al prodotto
        //         $name = $data[1];
        //         $dealer = $data[5];
        //         $status = $data[2];
        //         if ($status == '') $status = 'OK';

        //         $productStatus = ProductStatus::firstWhere('code', $status);

        //         // Dati relativi al produttore
        //         $dealer = $data[5];
        //         $dealer_model = $data[6];
        //         $dealer_code = $data[7];

        //         $dealer = Dealer::updateOrCreate([
        //             'provider_id' => 1, // TODO: Per ora lo forso sempre al Magazzino centrale MG
        //             'name' => $dealer,
        //  //       ], [
        //  //           'model' => $dealer_model,
        //  //           'code' => $dealer_code,
        //         ]);

        //         Product::create([
        //             'uuid' => $code,
        //             'name' => $name,
        //             'dealer_id' => $dealer->id,
        //             'status_id' => $productStatus->id,
        //             'model' => $dealer_model,
        //             'code' => $dealer_code,
        //         ]);
        //     }
        //     fclose($handle);
        // }

        if (($handle = fopen(resource_path('extras/codici_kanban_elettrico_v2.csv'), "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $code = $data[0];
                if ($code == 'Codice') continue;

                $uuid = $data[0];
                if (strlen($uuid) == 0) continue;

                $name = $data[1];
                $provider = $data[2];
                $qty = $data[3];
                $udm = $data[4];
                $productStatus = ProductStatus::firstWhere('code', 'OK');

                // Gestisco il provider
                $provider = Provider::firstOrCreate([
                    'name' => $provider,
                ]);

                // Per ora li assegno tutti ad un produttore vuoto
                $dealer = Dealer::firstOrCreate([
                    'name' => '',
                    // 'provider_id' => $provider->id,
                ]);

                // Gestisco il prodotto
                Product::create([
                    'uuid' => $uuid,
                    'name' => $name,
                    'status_id' => $productStatus->id,
                    'dealer_id' => $dealer->id,
                    'unit_of_measure' => $udm,
                ]);

            }
            fclose($handle);
        }
    }
}

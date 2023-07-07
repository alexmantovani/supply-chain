<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Dealer;
use App\Models\ProductStatus;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Compagnia 1
        $companyId = 1;
        if (($handle = fopen(resource_path('extras/distinta_materiale_e.csv'), "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $code = $data[0];
                if ($code == 'Articolo') continue;

                // Dati relativi al prodotto
                $name = $data[1];
                $dealer = $data[5];
                $status = $data[2];
                if ($status == '') $status = 'OK';

                $productStatus = ProductStatus::firstWhere('code', $status);

                // Dati relativi al produttore
                $dealer = $data[5];
                $dealer_model = $data[6];
                $dealer_code = $data[7];

                $dealer = Dealer::updateOrCreate([
                    'provider_id' => 1, // TODO: Per ora lo forso sempre al Magazzino centrale MG
                    'company_id' => $companyId,
                    'name' => $dealer,
                ], [
                    'model' => $dealer_model,
                    'code' => $dealer_code,
                ]);

                Product::create([
                    'uuid' => $code,
                    'name' => $name,
                    'dealer_id' => $dealer->id,
                    'status_id' => $productStatus->id,
                    'company_id' => $companyId,
                ]);
            }
            fclose($handle);
        }

        // Compagnia 2
        $companyId = 2;
        if (($handle = fopen(resource_path('extras/distinta_materiale_d.csv'), "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $code = $data[0];
                if ($code == 'Articolo') continue;

                // Dati relativi al prodotto
                $name = $data[1];
                $dealer = $data[5];
                $status = $data[2];
                if ($status == '') $status = 'OK';

                $productStatus = ProductStatus::firstWhere('code', $status);

                // Dati relativi al produttore
                $dealer = $data[5];
                $dealer_model = $data[6];
                $dealer_code = $data[7];

                $dealer = Dealer::updateOrCreate([
                    'provider_id' => 1, // TODO: Per ora lo forso sempre al Magazzino centrale MG
                    'company_id' => $companyId,
                    'name' => $dealer,
                ], [
                    'model' => $dealer_model,
                    'code' => $dealer_code,
                ]);

                Product::create([
                    'uuid' => $code,
                    'name' => $name,
                    'dealer_id' => $dealer->id,
                    'status_id' => $productStatus->id,
                    'company_id' => $companyId,
                ]);
            }
            fclose($handle);
        }
    }
}

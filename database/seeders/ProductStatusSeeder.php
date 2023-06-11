<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $list = [
            [
                'code' => 'OK',
                'name' => 'Ordinabile',
                'description' => 'Prodotto ordinabile',
                'group' => 'Ordinabili',
                'ordinable' => true,
            ],
            [
                'code' => 'TST',
                'name' => 'In test',
                'description' => 'Prodotto in test non ordinabile',
                'group' => 'In test',
                'ordinable' => false,
            ],
            [
                'code' => 'ANN',
                'name' => 'Annullato',
                'description' => 'Annullato',
                'group' => 'Annullati',
                'ordinable' => false,
            ],
            [
                'code' => 'ANR',
                'name' => 'Annullato',
                'description' => 'Annullato ricambi',
                'group' => 'Annullati',
                'ordinable' => false,
            ],
            [
                'code' => 'ANPV',
                'name' => 'Annullato',
                'description' => 'Annullato post vendita',
                'group' => 'Annullati',
                'ordinable' => false,
            ],
            [
                'code' => 'NOO',
                'name' => 'Non ordinabile',
                'description' => 'Non ordinabile',
                'group' => 'Annullati',
                'ordinable' => false,
            ],
            [
                'code' => 'ESA',
                'name' => 'In esaurimento',
                'description' => 'In esaurimento',
                'group' => 'In esaurimento',
                'ordinable' => false,
            ],
            [
                'code' => 'ESR',
                'name' => 'In esaurimento',
                'description' => 'In esaurimento ricambi',
                'group' => 'In esaurimento',
                'ordinable' => false,
            ],
            [
                'code' => 'ESPV',
                'name' => 'In esaurimento',
                'description' => 'In esaurimento',
                'group' => 'In esaurimento',
                'ordinable' => false,
            ],
            [
                'code' => 'PHO',
                'name' => 'Phase out',
                'description' => 'Eliminare gradualmente',
                'group' => 'In esaurimento',
                'ordinable' => false,
            ],
            [
                'code' => 'PFO',
                'name' => 'Problemi di fornitura',
                'description' => 'Problemi di fornitura',
                'group' => 'Poca fornitura',
                'ordinable' => true,
            ],
            [
                'code' => 'NDT',
                'name' => 'boo',
                'description' => 'boo',
                'group' => 'In esaurimento',
                'ordinable' => false,
            ],
        ];
        foreach ($list as $status) {
            \App\Models\ProductStatus::factory()->create($status);
        }
    }
}

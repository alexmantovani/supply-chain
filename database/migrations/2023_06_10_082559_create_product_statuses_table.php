<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_statuses', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('group')->nullable();
            $table->boolean('ordinable')->default(true);

            $table->timestamps();
        });

        // Riempo la tabella con i dati
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
        DB::table('product_statuses')->insert($list);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_statuses');
    }
};

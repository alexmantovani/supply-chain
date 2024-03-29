<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dealers', function (Blueprint $table) {
            $table->id();

            // Ogni produttore ha UN fornitore al quale fare richiesta di materiale
            // Tolto perchè associato al prodotto
            // $table->foreignId('provider_id');

            $table->string('name');
            $table->string('email')->nullable();

            // TODO: Verificare se voglio qui o nel prodotto
            $table->string('model')->nullable();
            $table->string('code')->nullable();

            // $table->string('contact_number_primary');
            // $table->string('contact_number_optional')->nullable();
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('city')->nullable();
            // $table->string('state');
            // $table->integer('country_id');
            // $table->integer('city_id');
            $table->string('image_url', 100)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dealers');
    }
};

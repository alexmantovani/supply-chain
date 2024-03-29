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
        Schema::create('providers', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->string('emails')->nullable(); // emails (una o più separate da ',') di chi gestisce il magazzino
            $table->string('provider_code')->nullable(); // codice del fornitore da inserire nell'invio degli ordini
            $table->string('image_url')->nullable(); // Logo del fornitore

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};

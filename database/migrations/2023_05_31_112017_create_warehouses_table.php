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
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique();
            $table->string('description')->nullable();

            $table->string('emails')->nullable(); // emails (una o più separate da ',') di chi gestisce il magazzino

            // Email a cui verranno inviati gli ordini nel caso nel prodotto non sia stato specificato il fornitore
            $table->string('fallback_emails'); // emails (una o più separate da ',') di chi gestisce il magazzino

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};

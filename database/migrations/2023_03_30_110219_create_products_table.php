<?php

use App\Models\Product;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Costruttore
            $table->foreignId('dealer_id')->nullable();
            // Stato del prodotto (ordinabile, non ordinabile...)
            $table->foreignId('status_id');
            // $table->foreignId('provider_id')->nullable();
            // $table->foreignId('default_provider_id')->nullable();

            $table->string('uuid')->unique();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('image_url')->nullable();

            $table->string('model')->nullable();
            $table->string('code')->nullable();

            $table->string('note')->nullable();
            $table->string('unit_of_measure')->nullable();
            $table->string('package')->default(1); // Confezione

            // La quantità di riordino di default è stata messa in una tabella a parte "product_warehouse"
            // perchè ogni magazzino avendo dimensioni diverse ha sicuramente quantità di riordino diverse.
            // Questo campo è il default che viene utilizzato nel caso la tabella pivot sia vuota.
            // $table->string('refill_quantity')->nullable();
            // $table->string('default_refill_quantity')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

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
            $table->foreignId('provider_id')->nullable();

            $table->string('uuid')->unique();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('image_url')->nullable();

            $table->string('model')->nullable();
            $table->string('code')->nullable();

            $table->string('note')->nullable();
            $table->string('unit_of_measure')->nullable();

            // La quantità di riordino di default è stata messa in una tabella a parte "product_defaults"
            // perchè ogni magazzino avendo dimensioni diverse ha sicuramente quantità di riordino diverse.
            $table->string('refill_quantity')->default(0);

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

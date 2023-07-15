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

            $table->foreignId('company_id');

            $table->foreignId('dealer_id')->nullable();
            $table->foreignId('status_id');

            $table->string('uuid')->unique();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('image_url')->nullable();

            $table->unsignedBigInteger('order_code')->nullable();
            $table->string('model')->nullable();
            $table->string('note')->nullable();

            // $table->string('refill_quantity')->default(0);

            // Se cancello il dealer allora cancello anche tutti i prodotti ad esso associati
            $table->foreign('dealer_id')->references('id')->on('dealers')->onDelete('cascade');

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

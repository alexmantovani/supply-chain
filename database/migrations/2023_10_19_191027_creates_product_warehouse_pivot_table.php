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
        Schema::create('product_warehouse', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id');
            $table->foreignId('warehouse_id');

            $table->unsignedBigInteger('refill_quantity')->nullable();
            $table->foreignId('provider_id')->nullable();
            $table->unsignedBigInteger('step')->default(1); // Passi di incremento nella quantità da ordinare

            $table->unique(['product_id', 'warehouse_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_warehouse');
    }
};

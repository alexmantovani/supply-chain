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
        Schema::create('refills', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable();
            $table->foreignId('product_id');
            $table->foreignId('warehouse_id');
            $table->foreignId('order_id')->nullable();

            $table->unsignedBigInteger('quantity')->nullable();
            $table->enum('status', ['low', 'urgent', 'ordered', 'completed'])->default('low');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refills');
    }
};

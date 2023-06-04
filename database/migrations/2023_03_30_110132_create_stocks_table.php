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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id');
            $table->foreignId('warehouse_id')->default(1);

            $table->unsignedBigInteger('quantity')->nullable();
            $table->unsignedBigInteger('receive_quantity')->nullable();
            $table->date('receive_at')->nullable();
            $table->unsignedBigInteger('sold_quantity')->nullable();
            $table->date('sold_at')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};

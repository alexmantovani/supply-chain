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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // $table->integer('item_category_id');
            $table->foreignId('dealer_id')->nullable();

            $table->string('uuid')->unique();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('image_url')->nullable();
            $table->unsignedBigInteger('order_code')->nullable();
            $table->string('model')->nullable();
            $table->string('note')->nullable();

            $table->string('refill_quantity')->nullable();
            $table->enum('status', ['unknown', 'available', 'aborted', 'obsolete'])->default('unknown');

            // $table->unique('dealer_id', 'name');

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

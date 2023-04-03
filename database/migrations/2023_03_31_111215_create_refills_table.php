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

            $table->foreignId('user_id');
            $table->foreignId('product_id');

            $table->unsignedBigInteger('quantity')->default(1);
            $table->enum('status', ['low', 'urgent', 'ordered', 'processed'])->default('low');

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

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

            // Siccome faccio troppa fatica a recuperarlo dalla tabella pivot lo tengo anche qui
            $table->foreignId('provider_id')->nullable(); // TODO: Capire se nullable() o default(0)

            $table->unsignedBigInteger('quantity')->nullable();
            // low - quando un prodotto viene messo nella lista dei refill ma non è stato ancora ordinato
            // ordered - quando un prodotto è stato ordinato
            // completed - quando un prodotto ordinato è stato consegnato al magazzino
            // aborted - quando un prodotto segnato tra i refills è stato eliminato
            $table->enum('status', ['low', 'urgent', 'ordered', 'completed', 'aborted'])->default('low');

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

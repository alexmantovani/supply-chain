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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // L'ordine lo si invia sempre al fornitore e non al produttore
            $table->foreignId('provider_id')->nullable();
            $table->foreignId('warehouse_id');

            $table->string('uuid')->unique();

            // aborted: quando l'ordine è stato annullato
            // waiting: quando l'ordine è stato inviato e si sta aspettando l'arrivo del materiale
            // pending: quando parte del materiale è rientrato ma ne manca ancora una parte
            // completed: quando l'ordine è stato completato
            // closed: quando l'ordine è stato chiuso malgrado non sia arrivato tutto il materiale
            $table->enum('status', ['aborted', 'waiting', 'pending', 'completed', 'closed'])->default('waiting');

            // L'ordine è stato fatto con urgenza
            $table->boolean('urgent')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

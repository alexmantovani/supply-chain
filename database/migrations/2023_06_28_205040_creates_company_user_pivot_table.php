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
        Schema::create('company_user', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id');
            $table->foreignId('user_id');

            // Indica il magazzino su cui sta operando
            $table->foreignId('warehouse_id')->nullable();

            // Indica se l'utente ha attivato questa compagnia
            $table->boolean('is_active')->nullable();

            // Ruoli dell'utente che ha in questa compagnia (separati da ,)
            $table->string('roles')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_user');
    }
};

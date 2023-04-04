<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable();

            $table->enum('type', ['none', 'info', 'warning', 'alert'])->default('none');
            $table->string('description');
            $table->string('color')->default('#212529');

            $table->foreignId('loggable_id');
            $table->string('loggable_type');

            // TODO: Aggiungere il colore da dare al testo

            // TODO: Cancellare i log relativi all'elemento eliminato (cascade)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}

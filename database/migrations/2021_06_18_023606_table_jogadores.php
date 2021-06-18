<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableJogadores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('jogadores')) {
            // ID, Nome e CPF (não precisa validar);
            Schema::create('jogadores', function (Blueprint $table) {
                $table->id('idjogadores');
                $table->string('nome');
                $table->integer('nivel');
                $table->string('categoria');
                $table->integer('confirmar')->default(0); // 0 - nao confirmado - 1 - confirmado
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jogadores');
    }
}

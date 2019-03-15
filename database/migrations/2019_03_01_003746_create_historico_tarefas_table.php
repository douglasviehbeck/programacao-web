<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricoTarefasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historicosTarefas', function (Blueprint $table) {
            $table->increments('historicoTarefaId');
            $table->integer('tarefaId')->unsigned();
            $table->foreign('tarefaId')->references('tarefaId')->on('tarefas');
            $table->integer('usuarioId')->unsigned();
            $table->foreign('usuarioId')->references('usuarioId')->on('usuarios');
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
        Schema::dropIfExists('historico_tarefas');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTarefasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarefas', function (Blueprint $table) {
            $table->increments('tarefaId');
            $table->string('titulo');
            $table->string('descricao');
            $table->integer('usuarioCriadorId')->unsigned();
            $table->foreign('usuarioCriadorId')->references('usuarioId')->on('usuarios');
            $table->integer('usuarioId')->unsigned()->nullable();
            $table->foreign('usuarioId')->references('usuarioId')->on('usuarios');
            $table->integer('situacaoId')->unsigned();
            $table->foreign('situacaoId')->references('situacaoId')->on('situacoes');
            $table->integer('projetoId')->unsigned();
            $table->foreign('projetoId')->references('projetoId')->on('projetos');
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
        Schema::dropIfExists('tarefas');
    }
}

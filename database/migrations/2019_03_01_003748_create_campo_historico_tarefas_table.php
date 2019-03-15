<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampoHistoricoTarefasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('camposHistoricosTarefas', function (Blueprint $table) {
            $table->increments('campoHistoricoTarefaId');
            $table->string('nomeCampo');
            $table->string('antes')->nullable();
            $table->string('depois');
            $table->integer('historicoTarefaId')->unsigned();
            $table->foreign('historicoTarefaId')->references('historicoTarefaId')->on('historicosTarefas');
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
        Schema::dropIfExists('campo_historico_tarefas');
    }
}

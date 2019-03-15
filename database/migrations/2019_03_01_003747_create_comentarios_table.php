<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComentariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->increments('comentarioId');
            $table->string('comentario');
            $table->integer('usuarioId')->unsigned();
            $table->foreign('usuarioId')->references('usuarioId')->on('usuarios');
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
        Schema::dropIfExists('comentarios');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjetoUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projetosUsuarios', function (Blueprint $table) {
            $table->increments('projetoUsuarioId');
            $table->integer('usuarioId')->unsigned();
            $table->foreign('usuarioId')->references('usuarioId')->on('usuarios');
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
        Schema::dropIfExists('projeto_usuarios');
    }
}

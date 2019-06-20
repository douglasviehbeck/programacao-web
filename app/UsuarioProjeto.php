<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioProjeto extends Model
{
    protected $primaryKey = 'projetoUsuarioId';
    protected $table = 'projetosUsuarios';
    protected $fillable = [
        'projetoId',
        'usuarioId',
    ];
}

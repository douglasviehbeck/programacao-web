<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    protected $primaryKey = 'projetoId';
    protected $table = 'projetos';
    protected $fillable = [
        'projetoId',
        'nome',
        'descricao',
        'usuarioId',
    ];

    public function criador()
    {
        return $this->belongsTo(Usuario::class, 'usuarioId', 'usuarioId');
    }
}

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

    public function usuariosProjeto()
    {
        return $this->hasMany(UsuarioProjeto::class, 'projetoId', 'projetoId');
    }

    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'projetosUsuarios', 'projetoId', 'usuarioId', 'projetoId', 'usuarioId')->withPivot('created_at as dataPermissao')->withTimestamps();
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    protected $primaryKey = 'tarefaId';
    protected $fillable = [
        'tarefaId',
        'titulo',
        'descricao',
        'situacaoId',
        'usuarioCriadorId',
        'usuarioId',
        'projetoId',
    ];

    public function situacao()
    {
        return $this->belongsTo(Situacao::class, 'situacaoId', 'situacaoId');
    }

    public function criador()
    {
        return $this->belongsTo(Usuario::class, 'usuarioCriadorId', 'usuarioId');
    }

    public function atribuido()
    {
        return $this->belongsTo(Usuario::class, 'usuarioId', 'usuarioId');
    }

    public function historico()
    {
        return $this->hasMany(HistoricoTarefa::class, 'tarefaId', 'tarefaId');
    }
}

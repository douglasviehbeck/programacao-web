<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoricoTarefa extends Model
{
    protected $table = 'historicosTarefas';
    protected $primaryKey = 'historicoTarefaId';
    protected $fillable = [
        'historicoTarefaId',
        'usuarioId',
        'comentario',
    ];

    public function campos()
    {
        return $this->hasMany(CampoHistoricoTarefa::class, 'historicoTarefaId', 'historicoTarefaId');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuarioId', 'usuarioId');
    }
}

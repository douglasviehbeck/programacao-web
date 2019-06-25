<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampoHistoricoTarefa extends Model
{
    protected $table = 'camposHistoricosTarefas';
    protected $primaryKey = 'campoHistoricoTarefaId';
    protected $fillable = [
        'campoHistoricoTarefaId',
        'nomeCampo',
        'antes',
        'depois',
    ];
}

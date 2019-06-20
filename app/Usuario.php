<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuario extends Model implements \Illuminate\Contracts\Auth\Authenticatable, JWTSubject
{
    use Authenticatable, Notifiable;

    protected $primaryKey = 'usuarioId';

    public function projetos()
    {
        return $this->belongsToMany(Projeto::class, 'projetosUsuarios', 'usuarioId', 'projetoId', 'usuarioId', 'projetoId')->withTimestamps();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}

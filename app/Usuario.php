<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Usuario extends Model implements \Illuminate\Contracts\Auth\Authenticatable
{
    use Authenticatable, Notifiable;

    protected $primaryKey = 'usuarioId';
}

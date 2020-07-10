<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table      = 'usuario';
    protected $primaryKey = 'id_usuario';
    public $timestamps    = true;

    public $fillable = ['nome', 
                        'email',
                        'senha'
                       ];
}


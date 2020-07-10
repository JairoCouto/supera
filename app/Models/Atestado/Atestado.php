<?php

namespace App\Models\Atestado;

use Illuminate\Database\Eloquent\Model;

class Atestado extends Model
{
    protected $table      = 'atestado';
    protected $primaryKey = 'id_atestado';
    public $timestamps    = true;

    public $fillable = ['codigo_atestado', 
                        'paciente'
                       ];
}


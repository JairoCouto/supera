<?php

namespace App\Models\Contrato;

use Illuminate\Database\Eloquent\Model;

class ContratoUsuario extends Model
{
    protected $table      = 'contrato_usuario';
    protected $primaryKey = 'id_contrato_usuario';
    public $timestamps    = true;

    public $fillable = ['id_contrato', 
                        'cpf',
                        'nome'
                       ];
}


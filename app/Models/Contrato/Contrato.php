<?php

namespace App\Models\Contrato;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $table      = 'contrato';
    protected $primaryKey = 'id_contrato';
    public $timestamps    = true;

    public $fillable = ['cnpj', 
                        'razao_social',
                        'nome_fantasia',
                        'email',
                        'logomarca',
                        'status'
                       ];
}


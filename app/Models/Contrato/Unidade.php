<?php

namespace App\Models\Contrato;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    protected $table      = 'unidade';
    protected $primaryKey = 'id_unidade';
    public $timestamps    = true;

    public $fillable = ['id_contrato', 
                        'integracao',
                        'email',
                        'municipio',
                        'uf',
                        'logomarca',
                        'tipo',
                        'status'
                       ];
}


<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aquisicao extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $table = 'aquisicao';

    protected $fillable = [
        'id',
        'quantidade',
        'valor',
        'eventoId',
        'clienteId',
        'bilheteId',
        'metodoPagamentoId',
        'created_at',
        'estado'
    ];
}

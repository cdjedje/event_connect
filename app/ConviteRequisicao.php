<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConviteRequisicao extends Model {

    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'conviterequisicao';
    protected $fillable = [
        'id', 'bilheteId', 'eventoId', 'clienteId','aquisicaoId','quantidade', 'estado'
    ];

}

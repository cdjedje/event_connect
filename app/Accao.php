<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accao extends Model {

    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'accao';
    protected $fillable = [
        'id','eventoId', 'clienteId', 'tipo',
    ];

}

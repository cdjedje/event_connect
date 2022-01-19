<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requisicao extends Model
{
    protected $table = 'bilhete';
    protected $fillable = [
        'nome', 'tipo','preco','quantidade','estado','eventoId'
    ];
}

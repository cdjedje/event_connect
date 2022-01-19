<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bilhete extends Model
{
    
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'bilhete';
    protected $fillable = [
        'id','nome', 'tipo', 'preco','quantidade','estado','eventoId','quantidadeMax'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model {

    protected $keyType = 'string';
    protected $table = 'categoria';
    protected $fillable = [
        'nome', 'descricao',
    ];

}

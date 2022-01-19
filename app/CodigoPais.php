<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodigoPais extends Model {

    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'codigopais';
    protected $fillable = [
        'id', 'pais',
    ];

}

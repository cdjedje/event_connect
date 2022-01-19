<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Local extends Model {

    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'local';
    protected $fillable = [
        'id', 'nome', 'nivel',
    ];

}

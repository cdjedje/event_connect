<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscricao extends Model
{
    //
    protected $table = 'subscricao';
    public $timestamps = false;
    
    protected $fillable = [
        'email', 'created_at'
    ];
}

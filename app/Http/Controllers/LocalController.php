<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Local;

class LocalController extends Controller
{
    
    //buscar categoria para o Layout [app] no menu
    public static function local() {
        return Local::all();
    }
}

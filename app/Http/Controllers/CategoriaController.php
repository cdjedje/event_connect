<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;

class CategoriaController extends Controller
{   
    //buscar categoria para o Layout [app] no menu
    public static function categorias() {
        return Categoria::all();
    }
    
    
}

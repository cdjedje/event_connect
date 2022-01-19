<?php

namespace App\Http\Controllers;

use App\Subscricao;
use Illuminate\Http\Request;

use function GuzzleHttp\json_encode;

class SubscricaoController extends Controller
{
    //

    public function save(Request $request)
    {
        $currentDate = date("Y-m-d H:i:s");

        $subscricao = new Subscricao();
        $subscricao->email = $request->input('email');
        $subscricao->created_at = $currentDate;
        $subscricao->save();

        echo json_encode(true);
    }
}

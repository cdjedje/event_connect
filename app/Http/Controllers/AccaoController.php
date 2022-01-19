<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Accao;
use App\Pkey;
use DB;

class AccaoController extends Controller {

    //recebendo id do evento e efectuar o LIKE
    public function gosto($id_evento) {
        $this->tipo($id_evento, 'LIKE');
    }

    //recebendo id do evento e marcar o tipo como visualizado
    public function visualizado($id_evento) {
        $this->tipo($id_evento, 'VISUALIZACAO');
    }

    //recebendo id do evento e marcar o tipo como interesse
    public function interesse($id_evento) {
        $this->tipo($id_evento, 'INTERESSE');
    }

    //mudar o tipo da accao
    public function tipo($id_evento, $tipo) {
        if (session()->has('nomeCliente')) {
            $accao = DB::table('accao')
                    ->where('eventoId', '=', $id_evento)
                    ->where('clienteId', '=',  session('idCliente'))
                    ->where('tipo', '=', $tipo)
                    ->first();
            if ($accao==null) {
                $key = new Pkey();
                Accao::create([
                    'id' => $key->idGenerator(),
                    'eventoId' => $id_evento,
                    'clienteId' =>  session('idCliente'),
                    'tipo' => $tipo,
                ]);
            } else if ($accao->tipo!='VISUALIZACAO') {
                DB::table('accao')->where('id', $accao->id)->delete();
            }
            return response()->json('feito');
        }
    }

}

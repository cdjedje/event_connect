<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Pkey;
use LaravelQRCode\Facades\QRCode;
use App\ConviteRequisicao;
use App\Bilhete;

class AquisicaoController extends Controller {

    public function __construct() {
        //  $this->middleware('auth');
    }

    //formlario de requisicao do bilhete
    public function requisitar($id_evento) {
        $evento = DB::table('evento')
                ->join('categoria', 'evento.categoriaId', '=', 'categoria.id')
                ->join('local', 'evento.localId', '=', 'local.id')
                ->select('evento.*', 'local.nome as local', 'categoria.nome as categoria')
                ->where('evento.id', $id_evento)
                ->first();
        $bilhetes = DB::table('bilhete')->where('bilhete.eventoId', $id_evento)->get();
        $auxiliar = new Pkey();
        $eventImagePath = $auxiliar->getEventImagePath();

        return view('requisicao.requisitar', compact('evento', 'bilhetes', 'eventImagePath'));
    }

    public function requisitarError($id_evento, $status) {
        $evento = DB::table('evento')
                ->join('categoria', 'evento.categoriaId', '=', 'categoria.id')
                ->join('local', 'evento.localId', '=', 'local.id')
                ->select('evento.*', 'local.nome as local', 'categoria.nome as categoria')
                ->where('evento.id', $id_evento)
                ->first();
        $bilhetes = DB::table('bilhete')->where('bilhete.eventoId', $id_evento)->get();
        $auxiliar = new Pkey();
        $eventImagePath = $auxiliar->getEventImagePath();
        $error = true;

        return view('requisicao.requisitar', compact('evento', 'bilhetes', 'eventImagePath', 'error'));
    }

    public function getBilhete($id) {
        $bilhete = DB::table('bilhete')->where('id', $id)->first();
        return response()->json($bilhete);
    }

    public function meus_bilhetes() {
        $bilhetes = DB::table('aquisicao')
                ->join('evento', 'aquisicao.eventoId', '=', 'evento.id')
                ->join('metodopagamento', 'aquisicao.metodoPagamentoId', '=', 'metodopagamento.id')
                ->join('local', 'evento.localId', '=', 'local.id')
                ->join('categoria', 'evento.categoriaId', '=', 'categoria.id')
                ->select('aquisicao.*', 'aquisicao.id as id_aquisicao', 'local.nome as local', 'evento.*', 'evento.id as codigo', 'categoria.nome as categoria', 'metodopagamento.nome as tipo')
                ->where('aquisicao.clienteId', session('idCliente'))
                ->orderBy('evento.created_at', 'desc')
                ->paginate(16);
        return view('requisicao.meusBilhetes', compact('bilhetes'));
    }

    public function qrCode($id_aquisicao) {
        $file = public_path('qrCode/' . $id_aquisicao . '.png');
        QRCode::text($id_aquisicao)->setOutfile($file)->png();
        $aquisicao = DB::table('aquisicao')
                ->join('evento', 'aquisicao.eventoId', '=', 'evento.id')
                ->join('local', 'evento.localId', '=', 'local.id')
                ->join('categoria', 'evento.categoriaId', '=', 'categoria.id')
                ->select('aquisicao.*', 'aquisicao.id as id_aquisicao', 'local.nome as local', 'evento.*', 'evento.id as codigo', 'categoria.nome as categoria')
                ->where('aquisicao.id', $id_aquisicao)
                ->first();
        $auxiliar = new Pkey();
        $eventImagePath = $auxiliar->getEventImagePath();
        return view('requisicao.qrCode', compact('aquisicao', 'eventImagePath'));
    }

    //verificar a disponibilidade dos convites
    public function isConviteDisponivel($id_bilhete) {
        $bilhete = Bilhete::find($id_bilhete);
        return response()->json($bilhete);
    }

    //salvar uma requisicao de convite
    public function requisitar_convite(Request $request) {
//        $bilhete = Bilhete::find($request->id_bilhete);
//        if ($bilhete->quantidade >= $request->qtd_participantes) {
//            $bilhete->update([
//                'quantidade' => $bilhete->quantidade - $request->qtd_participantes,
//            ]);
//        }
        $key = new Pkey();
        ConviteRequisicao::create([
            'id' => $key->idGenerator(),
            'bilheteId' => $request->id_bilhete,
            'eventoId' => $request->id_evento,
            'clienteId' => session('idCliente'),
            'aquisicaoId' => $key->idGenerator(),
            'quantidade' => $request->qtd_participantes,
            'estado' => 'PENDENTE',
        ]);
        //return redirect('requisitar-convite-fim/' . $request->eventoId);
    }

    //visualizar mensagem de convite requisitado com sucesso depois da submissao
    public function convite_mensagem_sucesso($id_evento) {
        $evento = DB::table('evento')
                ->join('categoria', 'evento.categoriaId', '=', 'categoria.id')
                ->join('local', 'evento.localId', '=', 'local.id')
                ->select('evento.*', 'local.nome as local', 'categoria.nome as categoria')
                ->where('evento.id', $id_evento)
                ->first();
        $auxiliar = new Pkey();
        $eventImagePath = $auxiliar->getEventImagePath();
        return view('requisicao.convite_mensagem_sucesso', compact('evento', 'eventImagePath'));
    }

}

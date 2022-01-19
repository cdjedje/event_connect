<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Cliente;
use App\Http\Requests\ClienteRequest;
use App\Pkey;
use Illuminate\Support\Facades\Hash;
use App\Mail\VerificacaoEmail;
use Mail;
use App\CodigoPais;
use App\Local;
use App\Http\Middleware\CheckSession;

class ClienteController extends Controller {

    public function __construct() {
        //$this->middleware('auth');
    }

    public function registar_cliente() {
        $codigopais = CodigoPais::all();
        return view('auth.register', compact('codigopais'));
    }

    //registar cliente (passo 1)
    protected function salvar_novo(ClienteRequest $request) {
        $id = new Pkey();
        $cliente = Cliente::create([
                    'id' => $id->idGenerator(),
                    'nome' => $request->nome,
                    'apelido' => $request->apelido,
                    'email' => $request->email,
//                    'sexo' => $request->sexo,
                    'senha' => Hash::make($request->password),
//                    'dataNascimento' => $request->dataNascimento,
//                    'codigoTelefonePais' => $request->codigoTelefonePais,
//                    'numTelefone' => $request->numTelefone,
//                    'localId' => $request->localId,
                    'provedor' => 'eventconnect',
                    'verified_at' => null,
                    'estado' => 'PENDENTE',
        ]);
        if ($cliente) {
            if ($cliente->email != null || $cliente->email != '') {
                session(['idCliente' => $cliente->id]);
                return redirect('cliente-verificacao');
            } else {
                session(['numTelefone' => $cliente->numTelefone]);
                return redirect('cliente-verificacao-phone');
            }
        }
    }

    //form de reenviar link de verificacao caso o email nao seja enviado (passo 2)
    public function verificacao() {
        return view('auth.verify');
    }

    //form de reenviar codigo de verificacao por telefone
    public function verificacao_phone() {
        return view('auth.verify_phone');
    }

    //POST para reenviar o email de verificacao(passo 3)
    public function reenviarVerificacao() {
        Mail::send(new VerificacaoEmail());
        return redirect('cliente-verificacao')->with('sucessoEnviarEmail', 'Email enviado com sucesso, consulte a sua caixa de emails ');
    }

    //confirmar a verificacao do email inserindo a data no verificafy_at (Passo 3)
    public function verificarEmail($idCliente) {
        $cliente = Cliente::find($idCliente);
        if ($cliente) {
            session()->forget('idCliente');
            $cliente->update([
                'verified_at' => date('Y-m-d H:m:s'),
                'estado' => 'ACTIVO',
            ]);
            session([
                'idCliente' => $cliente->id,
                'nomeCliente' => $cliente->nome,
                'emailCliente' => $cliente->email,
                'contactoCliente' => $cliente->numTelefone,
                'verified_at' => $cliente->verified_at,
            ]);
        }
        return redirect('/');
    }

    public function verificarNumeroTelefoneConfirmado() {
        $cliente = Cliente::where('numTelefone', session('numTelefone'))->first();
        if ($cliente) {
            session()->forget('numTelefone');
            $cliente->update([
                'verified_at' => date('Y-m-d H:m:s'),
                'estado' => 'ACTIVO',
            ]);
            session([
                'idCliente' => $cliente->id,
                'nomeCliente' => $cliente->nome,
                'emailCliente' => $cliente->email,
                'contactoCliente' => $cliente->numTelefone,
                'verified_at' => $cliente->verified_at,
            ]);
        }
        return redirect('/');
    }

    public function perfil($message = null) {
        $cliente = Cliente::find(session('idCliente'));
        $local= Local::find($cliente->localId); 
        $residencia ='';
        if($local!=null){
            $residencia=$local->nome;
        }
        $eventos = DB::table('aquisicao')
                ->join('evento', 'aquisicao.eventoId', '=', 'evento.id')
                ->join('metodopagamento', 'aquisicao.metodoPagamentoId', '=', 'metodopagamento.id')
                ->join('local', 'evento.localId', '=', 'local.id')
                ->join('categoria', 'evento.categoriaId', '=', 'categoria.id')
                ->select('aquisicao.*', 'aquisicao.id as id_aquisicao', 'local.nome as local', 'evento.*', 'evento.id as codigo', 'categoria.nome as categoria', 'metodopagamento.nome as tipo')
                ->where('aquisicao.clienteId', session('idCliente'))
                ->orderBy('evento.created_at', 'desc')
                ->paginate(16);

        $auxiliar = new Pkey();
        $eventImagePath = $auxiliar->getEventImagePath();
        return view('auth.perfil', compact('eventos', 'cliente', 'message', 'eventImagePath','residencia'));
    }

    //form editar perfil do cliente
    public function editar() {
        $cliente = Cliente::find(session('idCliente'));
        return view('auth.editar', compact('cliente'));
    }

    //salvar a edicacao do cliente
    public function salvar_edicao(Request $requet) { 
        $cliente = Cliente::find(session('idCliente'));
        if ($cliente)
            $cliente->update([
                'nome' => $requet->nome,
                'apelido' => $requet->apelido,
                'sexo' => $requet->sexo,
                'dataNascimento' => $requet->dataNascimento,
                'numTelefone' => $requet->numTelefone,
                'localId' => $requet->cidadeId,
            ]);
        return redirect('/perfil')->with('sucessoEdicao', 'Perfil editado com sucesso');
    }

    public function salvar_foto(Request $request) {
        /*
         * $request->validate([
          'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          ]);
         */
        $imageName = uniqid() . '.' . $request->image->extension();
        $request->image->move(public_path('images/cliente/'), $imageName);

        $cliente = Cliente::find(session('idCliente'));
        $cliente->foto = $imageName;
        $cliente->save();

        return back()->with('successo', 'Imagem carregado com sucesso...');
        //->with('image', $imageName);
    }

    public function imageUploadAPI(Request $request) {
        //upload
        $request->validate([
            'profileImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:3072',
        ]);
        $imageName = uniqid(). '.' . $request->profileImage->extension();
        $request->profileImage->move(public_path('images/cliente'), $imageName);

        //update
        $cliente = Cliente::where('id', '=', $request->clienteId)->first();
        $cliente->foto = $imageName;
        $cliente->save();

        return response()->json(["status" => true, "cliente" => $cliente]);
    }

}

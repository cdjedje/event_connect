<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Categoria;
use App\Pkey;
use App\Cliente;
use function GuzzleHttp\json_encode;

class EventoController extends Controller
{

    public function __construct()
    {
    }

    //listar eventos na pagina inicial
    public function index()
    {
        $locals = DB::table('local')->get();
        $categorias = DB::table('categoria')->get();
        $eventos = DB::table('evento')
            ->join('categoria', 'evento.categoriaId', '=', 'categoria.id')
            ->join('local', 'evento.localId', '=', 'local.id')
            ->select('evento.*', 'local.nome as local', 'categoria.nome as categoria')
            ->where([
                ['evento.estado', '<>', 'APAGADO'],
                ['evento.estado', '<>', 'CONFIG'],
                ['evento.dataInicio', '>=', date('Y-m-d')],
            ])
            ->orWhere([
                ['evento.estado', '<>', 'APAGADO'],
                ['evento.estado', '<>', 'CONFIG'],
                ['evento.dataFim', '>=', date('Y-m-d')],
            ])
            ->orderBy('evento.created_at', 'desc')
            ->paginate(16);


        $auxiliar = new Pkey();
        $eventImagePath = $auxiliar->getEventImagePath();

        $accao = DB::table('accao')
            ->where('clienteId', '=', session('idCliente'))
            ->where('tipo', '<>', 'VISUALIZACAO')
            ->get();

        return view('eventos.index', compact('locals', 'eventos', 'categorias', 'eventImagePath', 'accao'));
    }

    //listar eventos por categoria
    public function eventos($id_categoria)
    {
        $locals = DB::table('local')->get();
        $categorias = DB::table('categoria')->get();
        $eventos = DB::table('evento')
            ->join('categoria', 'evento.categoriaId', '=', 'categoria.id')
            ->join('local', 'evento.localId', '=', 'local.id')
            ->select('evento.*', 'local.nome as local', 'categoria.nome as categoria')
            ->where([
                ['evento.estado', '<>', 'APAGADO'],
                ['evento.dataInicio', '>=', date('Y-m-d')],
                ['evento.categoriaId', '=', $id_categoria],
                ['evento.estado', '<>', 'CONFIG'],
            ])
            ->orWhere([
                ['evento.estado', '<>', 'APAGADO'],
                ['evento.dataFim', '>=', date('Y-m-d')],
                ['evento.categoriaId', '=', $id_categoria],
                ['evento.estado', '<>', 'CONFIG'],
            ])
            ->orderBy('evento.created_at', 'desc')
            ->paginate(16);
        $titulo = 'Eventos encontrados (' . $eventos->count() . ' Resultados)';
        if ($eventos->isEmpty())
            $titulo = 'Nenhum evento foi encontrado';
        $auxiliar = new Pkey();
        $eventImagePath = $auxiliar->getEventImagePath();
        $accao = DB::table('accao')
            ->where('clienteId', '=', session('idCliente'))
            ->where('tipo', '<>', 'VISUALIZACAO')
            ->get();

        return view('eventos.procurar_eventos', compact('locals', 'eventos', 'categorias', 'titulo', 'eventImagePath', 'accao'));
    }

    //buscar eventos pelo formulario de pesquisa
    public function filtrarEventos(Request $request)
    {
        $locals = DB::table('local')->get();
        $categorias = DB::table('categoria')->get();
        $query = DB::table('evento');
        $query->join('categoria', 'evento.categoriaId', '=', 'categoria.id');
        $query->join('local', 'evento.localId', '=', 'local.id');
        $query->select('evento.*', 'local.nome as local', 'categoria.nome as categoria');
        $query->where('evento.estado', '<>', 'APAGADO');
        if ($request->input('data1') != null)
            $query->where('evento.dataInicio', '<=', $request->input('data1'));
        if ($request->input('data2') != null)
            $query->where('evento.dataFim', '>=', $request->input('data2'));
        if ($request->input('localId') != 'todos')
            $query->where('evento.localId', '=', $request->input('localId'));
        if ($request->input('categoriaId') != 'todos')
            $query->where('evento.categoriaId', '=', $request->input('categoriaId'));
        $query->orderBy('evento.created_at', 'desc');
        $eventos = $query->paginate(16);

        $titulo = 'Eventos encontrados (' . $eventos->count() . ' Resultados)';
        if ($eventos->isEmpty())
            $titulo = 'Nenhum evento foi encontrado';
        $auxiliar = new Pkey();
        $eventImagePath = $auxiliar->getEventImagePath();
        $accao = DB::table('accao')
            ->where('clienteId', '=', session('idCliente'))
            ->where('tipo', '<>', 'VISUALIZACAO')
            ->get();

        return view('eventos.procurar_eventos', compact('locals', 'eventos', 'categorias', 'titulo', 'eventImagePath', 'accao'));
    }

    //detalhes do evento
    public function detalhes($url)
    {
        $evento = DB::table('evento')
            ->join('categoria', 'evento.categoriaId', '=', 'categoria.id')
            ->join('local', 'evento.localId', '=', 'local.id')
            ->select('evento.*', 'local.nome as local', 'categoria.nome as categoria')
            ->where('evento.url', $url)
            ->first();
        $contarPedidos = DB::table('conviterequisicao')->where('eventoId', $evento->id)->where('clienteId', session('idCliente'))->count();

        $bilhetes = DB::table('bilhete')->where('eventoId', $evento->id)->get();

        $auxiliar = new Pkey();
        $eventImagePath = $auxiliar->getEventImagePath();
        $cliente = null;
        if (!session()->has('nomeCliente')) {
            $cliente = Cliente::find(session('idCliente'));
        }
        $accao = DB::table('accao')
            ->where('clienteId', '=', session('idCliente'))
            ->where('eventoId', '=', $evento->id)
            ->where('tipo', '<>', 'VISUALIZACAO')
            ->get();
        return view('eventos.detalhe', compact('evento', 'bilhetes', 'eventImagePath', 'cliente', 'contarPedidos', 'accao'));
    }

    public function eventosPesquisa(Request $request)
    {
        $locals = DB::table('local')->get();
        $categorias = DB::table('categoria')->get();
        $text = $request->input('term');
        $eventos = array();

        //select all events with text very similar to the search text
        $eventosBaseadOnText = DB::select("SELECT evento.*, local.nome as local, categoria.nome as categoria FROM evento,categoria,local where evento.localId=local.id and evento.categoriaId=categoria.id and (LOWER(evento.nome) LIKE '%" . strtolower($text) . "%' or LOWER(evento.descricao) LIKE '%" . strtolower($text) . "%')");

        $excludeIdSQLFromEventoBT = "";
        $indice = 0;
        foreach ($eventosBaseadOnText as $eventosBT) {
            $indice++;
            if ($indice != sizeof($eventosBaseadOnText)) {
                $excludeIdSQLFromEventoBT .= " evento.id != '" . $eventosBT->id . "' or ";
            } else {
                $excludeIdSQLFromEventoBT .= " evento.id != '" . $eventosBT->id . "'";
            }
            array_push($eventos, $eventosBT);
        }

        $LikeClause = "";
        $searchParams = explode(" ", $text);

        $index = 0;
        foreach ($searchParams as $searchParam) {
            $index++;
            if ($index != sizeof($searchParams)) {
                $LikeClause .= "LOWER(evento.nome) LIKE '%" . strtolower($searchParam) . "%' or LOWER(evento.descricao) LIKE '%" . strtolower($searchParam) . "%' or ";
            } else {
                $LikeClause .= "LOWER(evento.nome) LIKE '%" . strtolower($searchParam) . "%' or LOWER(evento.descricao) LIKE '%" . strtolower($searchParam) . "%'";
            }
        }
        // var_dump($LikeClause);

        $eventosNotBasedOnText = DB::select("SELECT evento.*, local.nome as local, categoria.nome as categoria FROM evento,categoria,local where evento.localId=local.id and evento.categoriaId=categoria.id and (" . $LikeClause . ") and (" . $excludeIdSQLFromEventoBT . ")");

        foreach ($eventosNotBasedOnText as $eventosNBT) {
            array_push($eventos, $eventosNBT);
        }

        $titulo = 'Resultados da pesquisa: ' . $text;
        $accao = DB::table('accao')
            ->where('clienteId', '=', session('idCliente'))
            ->where('tipo', '<>', 'VISUALIZACAO')
            ->get();
        $auxiliar = new Pkey();
        $eventImagePath = $auxiliar->getEventImagePath();
        return view('eventos.procurar_eventos', compact('locals', 'eventos', 'categorias', 'titulo', 'accao', 'eventImagePath'));
    }

    //listar eventos favoritos
    public function favoritos()
    {
        $eventos = DB::table('accao')
            ->join('evento', 'accao.eventoId', '=', 'evento.id')
            ->join('local', 'evento.localId', '=', 'local.id')
            ->join('categoria', 'evento.categoriaId', '=', 'categoria.id')
            ->select('evento.*', 'local.nome as local', 'categoria.nome as categoria')
            ->where('accao.tipo', '<>', 'VISUALIZACAO')
            ->where('accao.clienteId', session('idCliente'))
            ->orderBy('evento.created_at', 'desc')
            ->distinct()->paginate(16);
        $auxiliar = new Pkey();
        $eventImagePath = $auxiliar->getEventImagePath();
        $accao = DB::table('accao')
            ->where('clienteId', '=', session('idCliente'))
            ->where('tipo', '<>', 'VISUALIZACAO')
            ->get();

        return view('eventos.favoritos', compact('eventos', 'eventImagePath', 'accao'));
    }

    //lista de convites requisitados pelos clientes
    public function convites()
    {
        $convites = DB::table('conviterequisicao')
            ->join('evento', 'conviterequisicao.eventoId', '=', 'evento.id')
            ->join('local', 'evento.localId', '=', 'local.id')
            ->join('categoria', 'evento.categoriaId', '=', 'categoria.id')
            ->join('bilhete', 'conviterequisicao.bilheteId', '=', 'bilhete.id')
            ->select('evento.*', 'evento.nome as titulo', 'conviterequisicao.*', 'bilhete.*', 'local.nome as local', 'categoria.nome as categoria', 'conviterequisicao.quantidade as qtd', 'conviterequisicao.estado as thisEstado')
            ->where('conviterequisicao.clienteId', session('idCliente'))
            ->orderBy('conviterequisicao.created_at', 'desc')
            ->distinct()->paginate(16);
        $auxiliar = new Pkey();
        $eventImagePath = $auxiliar->getEventImagePath();
        return view('eventos.convites', compact('convites', 'eventImagePath'));
    }
}

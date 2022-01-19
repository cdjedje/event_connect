<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\Cliente;
use Socialite;
use App\Pkey;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    //recebendo por parâmetro o nome do provedor (google, facebook)

    public function redirectToProvider() {
        //return Socialite::driver($provedor)->redirect();
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obter informação do user através do provedor.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback() {
        //$user = Socialite::driver($provedor)->user();
        $user = Socialite::driver('facebook')->user();

        $cliente = $this->findOrCreateUser($user, 'facebook');
        $this->createSession($cliente);
        return redirect('/');
    }

    public function findOrCreateUser($user, $provedor) {
        $authUser = Cliente::where('provedorId', $user->id)->first();
        //->orWhere('numTelefone',$user->phone);

        if ($authUser) {
            return $authUser;
        }
        $id = new Pkey();

        $fullNames = explode(" ", $user->name);
        $firstName = "";
        for ($i = 0; $i < sizeof($fullNames) - 1; $i++) {
            $firstName .= $fullNames[$i];
        }

        $lastName = $fullNames[sizeof($fullNames) - 1];

        return Cliente::create([
                    'id' => $id->idGenerator(),
                    'nome' => $firstName,
                    'apelido' => $lastName,
                    'email' => $user->email,
                    'provedor' => $provedor,
                    'provedorId' => $user->id,
                    'verified_at' => date('Y-m-d H:i:s'),
                    'estado' => "ACTIVO",
        ]);
    }

    protected function credentials(Request $request) {
        if (is_numeric($request->get('email'))) {
            return ['numTelefone' => $request->get('email'), 'password' => $request->get('password')];
        } elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->get('email'), 'password' => $request->get('password')];
        }
    }

    public function login(Request $request) {
        $cliente = Cliente::where('email', $request->email)
                        ->orWhere('numTelefone', $request->email)->first();
        session()->flash('email', $request->email);
        if ($cliente) {
            if (Hash::check($request->password, $cliente->senha)) {
                if ($cliente) {
                    if ($cliente->estado != 'ACTIVO') {
                        session(['idCliente' => $cliente->id]);
                        if ($cliente->numTelefone != null && ($cliente->email == null || $cliente->email == '')) {
                            session(['numTelefone' => $cliente->numTelefone]);
                            return redirect('cliente-verificacao-phone');
                        } else {
                            return redirect('cliente-verificacao');
                        }
                    }
                }
                $this->createSession($cliente);
                return redirect('/');
            } else
                return redirect('login')->with('falha_senha', 'Senha errada');
        }
        return redirect('login')->with('falha_email', 'Email ou contacto errado');
    }

    public function createSession(Cliente $cliente) {
        session([
            'idCliente' => $cliente->id,
            'nomeCliente' => $cliente->nome . " " . $cliente->apelido,
            'emailCliente' => $cliente->email,
            'contactoCliente' => $cliente->numTelefone,
            'verified_at' => $cliente->verified_at,
        ]);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->forget(['idCliente', 'nomeCliente', 'emailCliente', 'contactoCliente']);
        return redirect('/');
    }

}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Pkey;

class RegisterController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        
        return Validator::make($data, [
                    'nome' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                    'dataNascimento' => ['required', 'string'],
                    'numTelefone' => ['required', 'string', 'max:255'],
                    'localId' => ['required', 'string', 'max:255'],
                        ], [
                    'nome.required' => 'Nome é obrigatório',
                    'nome.string' => 'Nome deve ter um  conjunto de caracteres',
                    'nome.max' => 'Nome deve ter no maximo 255 caracteres',
                    'email.required' => 'Email é obrigatório',
                    'email.email' => 'Email invalido',
                    'email.max' => 'Email deve ter no maximo 255 caracteres',
                    'password.required' => 'Senha é obrigatório',
                    'password.min' => 'Minimo 8 caracteres',
                    'password.confirmed' => 'A senha não confirma',
                    'dataNascimento.required' => 'Data de nascimento é obrigatório',
                    'numTelefone.required' => 'Numero de telefone é obrigatório',
                    'localId.required' => 'Seleccione o Local',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data) {
        $id = new Pkey();
        return User::create([
                    'id' => $id->idGenerator(),
                    'nome' => $data['nome'],
                    'email' => $data['email'],
                    'sexo' => $data['sexo'],
                    'password' => Hash::make($data['password']),
                    'dataNascimento' => $data['dataNascimento'],
                    'numTelefone' => $data['numTelefone'],
                    'localId' => $data['localId'],
                    'provedor' => 'eventconnect',
                    'email_verified_at' => null,
        ]);
    }

}

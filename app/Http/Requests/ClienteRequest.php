<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use App\Cliente;
use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest {

    /**
     * 
     * 
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request) {
        if ($request->numTelefone != null && $request->email != null) {
            return [
                'email' => 'required|string|email|max:255|unique:cliente',
                'nome' => 'required|string|max:255',
                'apelido' => 'required|string|max:255',
//                'numTelefone' => 'required|string|max:9|unique:cliente',
//                'dataNascimento' => 'required|date|before:2005-12-31',
//                'localId' => 'required|string|max:255',
                'password' => 'required|string|min:8|confirmed',
            ];
        }
        if ($request->email != null || $request->email != '') {
            return [
                'email' => 'required|string|email|max:255|unique:cliente',
                'nome' => 'required|string|max:255',
                'apelido' => 'required|string|max:255',
                //'numTelefone' => 'required|string|max:15|unique:cliente',
//                'dataNascimento' => 'required|date|before:2005-12-31',
//                'localId' => 'required|string|max:255',
                'password' => 'required|string|min:8|confirmed',
            ];
        }
        if ($request->numTelefone != null || $request->numTelefone != '') {
            return [
                // 'email' => 'required|string|email|max:255|unique:cliente',
                'nome' => 'required|string|max:255',
                'apelido' => 'required|string|max:255',
//                'numTelefone' => 'required|string|max:9|unique:cliente',
//                'dataNascimento' => 'required|date|before:2005-12-31',
//                'localId' => 'required|string|max:255',
                'password' => 'required|string|min:8|confirmed',
            ];
        }
        return [
            'email' => 'required|string|email|max:255|unique:cliente',
            'nome' => 'required|string|max:255',
            'apelido' => 'required|string|max:255',
//            'numTelefone' => 'required|string|max:9|unique:cliente',
//            'dataNascimento' => 'required|date|before:2005-12-31',
//            'localId' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages() {
        return [
            'nome.required' => 'Nome é obrigatório',
            'nome.string' => 'Nome deve ter um  conjunto de caracteres',
            'nome.max' => 'Nome deve ter no maximo 255 caracteres',
            'apelido.required' => 'Apelido é obrigatório',
            'apelido.string' => 'Apelido deve ter um  conjunto de caracteres',
            'apelido.max' => 'Apelido deve ter no maximo 255 caracteres',
            'email.required' => 'Email é obrigatório',
            'email.email' => 'Email invalido',
            'email.max' => 'Email deve ter no maximo 255 caracteres',
            'email.unique' => 'Este email já está registado',
            'password.required' => 'Senha é obrigatório',
            'password.min' => 'Minimo 8 caracteres',
            'password.confirmed' => 'A senha não confirma',
//            'dataNascimento.required' => 'Data de nascimento é obrigatório',
//            'numTelefone.required' => 'Numero de telefone é obrigatório',
//            'numTelefone.unique' => 'Este numero já está registado',
//            'numTelefone.max' => 'No maximo deve ser 9 digitos',
//            'localId.required' => 'Seleccione o Local',
//            'dataNascimento.before' => 'Valido para Maior de 15 anos',
        ];
    }

}

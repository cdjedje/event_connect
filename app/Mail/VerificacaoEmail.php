<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use App\Cliente;

class VerificacaoEmail extends Mailable {

    use Queueable,
        SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
       // if (session()->has('IdCliente')) {
            $cliente = Cliente::find(session('idCliente'));
            if ($cliente) {
                return $this->markdown('email_verificacao')
                                ->to($cliente->email)
                                ->subject('Verificação de Email')
                                ->with([
                                    'IdCliente' => $cliente->id,
                ]);
            }
        //}
        return redirect('register/');
    }

}

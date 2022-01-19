<?php
use App\Http\Middleware\CheckSession;
/*
 * ------------------AUTENTICACAO------------------------------
 * 
 */

Auth::routes(['verify' => true]);
Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');
Route::post('login', 'Auth\LoginController@login');

/*
 * ------------------CLIENTES------------------------------
 * 
 */
Route::get('registar-cliente', 'ClienteController@registar_cliente');
Route::get('perfil', 'ClienteController@perfil')->middleware(CheckSession::class);
Route::post('perfil-perfil-salvar', 'ClienteController@salvar_foto')->middleware(CheckSession::class);
Route::get('perfil-editar', 'ClienteController@editar')->middleware(CheckSession::class);
Route::post('perfil-salvar-edicao', 'ClienteController@salvar_edicao')->middleware(CheckSession::class);
Route::post('cliente-salvar-novo', 'ClienteController@salvar_novo');
Route::get('cliente-verificacao', 'ClienteController@verificacao');
Route::get('cliente-verificacao-phone', 'ClienteController@verificacao_phone');
Route::get('perfil/{message?}', 'ClienteController@perfil')->name('perfil');
Route::any('reenviar-email', 'ClienteController@reenviarVerificacao');
Route::get('verificar-email/{idCliente}', 'ClienteController@verificarEmail');
Route::get('verificar-numero-telefone-confirmado', 'ClienteController@verificarNumeroTelefoneConfirmado');


/*
 * ------------------EVENTOS--------------- ---------------
 * 
 */

Route::get('/', 'EventoController@index')->name('inicio'); //->middleware('verified');
Route::get('eventos/{id_categoria}', 'EventoController@eventos')->name('eventos');
Route::get('eventos-detalhes/{id_evento}', 'EventoController@detalhes')->name('detalhes')->middleware('guest');
Route::get('get-eventos', 'EventoController@filtrarEventos');
Route::get('pesquisar-eventos', 'EventoController@eventosPesquisa');
Route::get('eventos-favoritos', 'EventoController@favoritos')->middleware(CheckSession::class);
Route::get('requisicao-convites', 'EventoController@convites')->middleware(CheckSession::class);

/*
 * ------------------REQUISICAO------------------------------
 * 
 */

Route::get('requisitar/{id_evento}', 'AquisicaoController@requisitar')->name('requisicao');
Route::get('requisitar/{id_evento}/{error_status}', 'AquisicaoController@requisitarError')->name('requisicao');
Route::get('requisitar-getBilhete/{id}', 'AquisicaoController@getBilhete')->middleware(CheckSession::class);
Route::get('meus-bilhetes', 'AquisicaoController@meus_bilhetes')->middleware(CheckSession::class);
Route::get('requisitar-qrCode/{id_aquisicao}', 'AquisicaoController@qrCode')->middleware(CheckSession::class);
Route::get('requisitar-convite', 'AquisicaoController@requisitar_convite')->middleware(CheckSession::class);
Route::get('requisitar-convite-fim/{id_evento}', 'AquisicaoController@convite_mensagem_sucesso');
Route::get('requisitar-isConvite-diaponivel/{id_bilhete}', 'AquisicaoController@isConviteDisponivel');

/*
 * ------------------ACCAO------------------------------
 * 
 */

Route::get('accao-gosto/{id_evento}', 'AccaoController@gosto')->middleware(CheckSession::class);
Route::get('accao-visualizado/{id_evento}', 'AccaoController@visualizado');
Route::get('accao-interesse/{id_evento}', 'AccaoController@interesse')->middleware(CheckSession::class);


/*
 * ------------------PAYPALL------------------------------
 * 
 */
Route::post('payment', 'PaymentController@setPaymentMethod')->middleware(CheckSession::class);
Route::get('paypalsuccess/{amount}/{quantidade}/{id_evento}/{id_bilhete}/{id_cliente}', 'PaymentController@payment_success')->middleware(CheckSession::class);
Route::get('paypalerror', 'PaymentController@payment_error')->middleware(CheckSession::class);
Route::get('sendpayment', 'PaymentController@sendToPromoter')->middleware(CheckSession::class);
Route::any('mpesa/payment', 'PaymentController@mpesaPayment')->middleware(CheckSession::class);
Route::get('mpesa/success/{valor}/{quantidade}/{bilheteId}/{eventoId}', 'PaymentController@mpesaPaymentSuccess')->middleware(CheckSession::class);



/*
 * ------------------PAGE------------------------------
 * 
 */
Route::get('about', 'PageController@about');
Route::post('subscrition', 'SubscricaoController@save');

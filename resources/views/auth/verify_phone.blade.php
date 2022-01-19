@extends('layouts.app')

@section('content')
<style>
    body {
        background: #FFF;
    }
</style>

<!-- Sub Banner -->
<section class="sub-banner newsection">
    <div class="container">
        <h2 class="title">Verificação do número de celular </h2>
        <ul class="breadcrumb">
            <li><a href="">Eventos</a></li>
            <li>Todas Categorias</li>
        </ul>
    </div>
</section>

<div class="contact newsection">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6">

                <form method="post" action="{{ url('reenviar-email') }}" id="contactform">
                    @csrf
                    <p>

                        <label for="contactname">Passo 1: Faça pedido de codigo de verificação por SMS <i class="fa fa-arrow-down"></i></label>
                        <div id="recaptcha-container"></div>

                    </p>
                    <button type="button" onclick="phoneAuth()" title="Clique aqui para entrar no sistema!" class="btn btn-primary">Enviar Codigo</button>
                </form>
            </div>

            <div class="col-md-6 col-sm-6">
                <!-- Map -->
                <div class="map-container">
                    <h2 class="title"> Esteja atento para novos eventos</h2>
                    <div><img src="{{asset('public/website/img/login.jpg')}}" style="width: 300px;"></div>
                </div>


            </div>
        </div>
    </div>
</div>
<!---------Modal para confirmar codigo de verificacao-------->

<div class="modal fade" id="modalVerificarCodigo" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">SMS enviado com sucesso</h4>
            </div>
            <div class="modal-body">
                <form class="form-inline">
                    <p><label for="contactname">Passo 2: Digite o codigo de Verificação @error('codigo_verificacao')<span style="color: #c10e0a"> * {{ $message }}</span>@enderror</label>
                        <input type="hidden" value="{{ session('numTelefone') }}" id="number">
                        <input id="verificationCode" type="text" name="codigo_verificacao" required="" autofocus placeholder="codigo de Verificação" class="textflied">


                    </p>
                    <button type="button" onclick="codeverify()" title="Clique aqui para entrar no sistema!" class="btn btn-success">Verificar</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="{{asset('public/js/firebase.6.0.2.js')}}" type="text/javascript"></script>
<!--<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>-->
<script>
    var _0x6172 = ["\x41\x49\x7A\x61\x53\x79\x41\x73\x36\x31\x62\x6D\x54\x4E\x4C\x53\x64\x63\x4A\x4F\x58\x58\x64\x6C\x45\x6C\x47\x79\x4A\x49\x4D\x33\x32\x64\x54\x38\x51\x47\x73", "\x66\x69\x72\x2D\x65\x76\x65\x6E\x74\x63\x6F\x6E\x6E\x65\x63\x74\x2E\x66\x69\x72\x65\x62\x61\x73\x65\x61\x70\x70\x2E\x63\x6F\x6D", "\x68\x74\x74\x70\x73\x3A\x2F\x2F\x66\x69\x72\x2D\x65\x76\x65\x6E\x74\x63\x6F\x6E\x6E\x65\x63\x74\x2E\x66\x69\x72\x65\x62\x61\x73\x65\x69\x6F\x2E\x63\x6F\x6D", "\x66\x69\x72\x2D\x65\x76\x65\x6E\x74\x63\x6F\x6E\x6E\x65\x63\x74", "\x66\x69\x72\x2D\x65\x76\x65\x6E\x74\x63\x6F\x6E\x6E\x65\x63\x74\x2E\x61\x70\x70\x73\x70\x6F\x74\x2E\x63\x6F\x6D", "\x31\x39\x37\x32\x38\x37\x33\x37\x37\x30\x37\x34", "\x31\x3A\x31\x39\x37\x32\x38\x37\x33\x37\x37\x30\x37\x34\x3A\x77\x65\x62\x3A\x62\x36\x36\x37\x31\x36\x64\x31\x62\x64\x65\x37\x62\x63\x62\x33\x65\x65\x33\x31\x61\x62", "\x69\x6E\x69\x74\x69\x61\x6C\x69\x7A\x65\x41\x70\x70"];
    var firebaseConfig = {
        apiKey: _0x6172[0],
        authDomain: _0x6172[1],
        databaseURL: _0x6172[2],
        projectId: _0x6172[3],
        storageBucket: _0x6172[4],
        messagingSenderId: _0x6172[5],
        appId: _0x6172[6]
    };
    firebase[_0x6172[7]](firebaseConfig)
</script>
<script type="text/javascript">
    window.onload = function() {
        render();
    };

    function render() {
        window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
        recaptchaVerifier.render();
    }

    function phoneAuth() {
        //get the number
        var number = "+258"+document.getElementById('number').value;
        // console.log("number",number);
        //phone number authentication function of firebase
        //it takes two parameter first one is number,,,second one is recaptcha
        firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function(confirmationResult) {
            //s is in lowercase
            window.confirmationResult = confirmationResult;
            coderesult = confirmationResult;
            //console.log(coderesult);
            $('#modalVerificarCodigo').modal('show');
        }).catch(function(error) {
            Swal.fire({
                title: 'Erro sms não foi enviado',
                //text: error.message,
                text: 'Tente novamente',
                type: 'error',
                confirmButtonColor: '#3085d6',
            });
        });
    }

    function codeverify() {
        var code = document.getElementById('verificationCode').value;
        coderesult.confirm(code).then(function(result) {
            //        alert("Successfully registered");
            window.location.href = '{{url("verificar-numero-telefone-confirmado")}}/';
            var user = result.user;
            console.log(user);
        }).catch(function(error) {
            Swal.fire({
                title: 'Este codigo não foi confirmado',
                text: error.message,
                type: 'error',
                confirmButtonColor: '#3085d6',
            });
        });
    }
</script>


@endsection
@extends('layouts.app')

@section('content')
<style>
    body{
        background: #FFF;
    }
</style>

<!-- Sub Banner -->
<section class="sub-banner newsection">
    <div class="container">
        <h2 class="title">Verificação do email</h2>
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

                <form method="post"  action="{{ url('reenviar-email') }}" id="contactform">
                    @csrf
                    <p ><label for="contactname">Verifique seu endereço de e-mail</label></p>
                    <p>Antes de prosseguir, verifique seu e-mail enviamos um link de verificação. Se você não recebeu o email</p>
                    <p>
                        <button title="clique aqui para reinviar email" class="btn btn-primary"  data-toggle="modal" data-target="#mySendEmail">clique aqui para solicitar outra</button>
                    </p>
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


<!-- Modal -->
<div class="modal fade" id="mySendEmail" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Processando...</h4>
            </div>
            <div class="modal-body"> 
                <center>
                    <img src="{{ asset('public/img/loding2.gif')}}" style="width: 100px"alt=""/>
                    <br><br>Enviando Email aguarde...
                </center>
            </div>
        </div>
    </div>
</div>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
@if (session('sucessoEnviarEmail'))
<script>
    Swal.fire({
        position: 'center',
        type: 'success',
        title: 'Email enviado com sucesso, consulte a sua caixa de emails',
        showConfirmButton: true,
    });
</script> 
@endif

@endsection

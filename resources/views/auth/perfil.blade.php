@extends('layouts.app')

@section('content')

<?php

use App\Http\Controllers\LocalController;

$local = LocalController::local();
?>

<!-- Sub Banner -->
<section class="sub-banner newsection">
    <div class="container">
        <h2 class="title">Meu Perfil</h2>
        <ul class="breadcrumb">
            <li><a href="">Eventos</a></li>
            <li>Todas Categorias</li>
        </ul>
    </div>
</section>
<div class="contact newsection">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-8">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <center>
                            <div class="eventsimg">
                                @if($cliente->foto==null || $cliente->foto=='')
                                <img src="{{asset('public/website/img/user.png')}}" style="width: 150px;border-radius: 50%;" alt="">
                                @else
                                <img src="{{asset('public/images/cliente/'. $cliente->foto)}}" style="width: 150px;border-radius: 50%;" alt="">
                                @endif
                            </div>
                            <br> <br>
                            <button type="button" class="btn-form-upload-foto">Mudar Foto</button> 
                        </center>


                    </div>
                    <div class="col-md-8 col-sm-8">
                        <div class="event-content">
                            <h3 class="title">{{ session('nomeCliente') }}</h3>
                            <hr>
                            <p><i class="fa fa-info"></i> Sexo: {{ $cliente->sexo }}</p>
                            <p><i class="fa fa-calendar"></i> Data de Nascimento: {{ date_format(date_create($cliente->dataNascimento) ,"d-m-Y") }}</p>
                            <p><i class="fa fa-phone"></i> Contacto: {{ $cliente->numTelefone }}</p>
                            <p><i class="fa fa-envelope"></i> Email: {{ $cliente->email }}</p>
                             <p><i class="fa fa-map-marker"></i> Residência : {{ $residencia }}</p>
                            <a href="{{url('perfil-editar')}}" class="btn btn-pri">Editar</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-4">
                <!-- Map -->
                <div class="map-container">
                    <h2 class="title"> Esteja atento para novos eventos</h2>
                    <div><img src="{{asset('public/website/img/login.jpg')}}" style="width: 250px;border-radius: 50%;"></div>
                </div>

                <!-- Contact Info -->
                <div class="contactinfo">
                    <!-- <h2 class="title">Siga-nos</h2>

                  Social Icon 
                   <div class="social-icon">
                       <a href="#" class="facebook fa fa-facebook"></a>
                       <a href="#" class="twitter fa fa-twitter"></a>
                       <a href="#" class="googleplus fa fa-google-plus"></a>
                       <a href="#" class="linkedin fa fa-linkedin"></a>
                   </div>-->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Events -->
<section class="events newsection">
    <div class="container">
        <h2 class="text-left">Meus Bilhetes</h2>
        <hr><br>
        <div class="row">
            <div class="blog col-md-9">
                <div class="clearfix">

                    @foreach($eventos as $evento)
                    <div class="event-container clearfix">
                        <div class="event clearfix">
                            <div class="eventsimg">
                                <img src="{{$eventImagePath.'/'.$evento->foto}}" alt="">
                            </div>
                            <div class="event-content">
                                <h3 class="title"><a href="#">{{$evento->nome}}</a></h3>
                                <ul class="meta">
                                    <li><a href="#"><i class="fa fa-arrow-circle-right"></i> &nbsp; Categoria: {{$evento->categoria}}</a></li>
                                    <li class="date"><i class="icon fa fa-calendar"></i> {{ date_format(date_create($evento->dataInicio) ,"d-m-Y") }} as {{$evento->horaInicio}} @if($evento->dataFim!=null || $evento->dataFim!='') ate {{ date_format(date_create($evento->dataFim) ,"d-m-Y") }} @endif</li>
                                    <!--li><a href="#"><i class="icon fa fa-comment"></i> {{$evento->nome}}</a> </li>
                                    <li><a href="#"><i class="icon fa fa-user"></i>{{$evento->nome}}</a></li-->
                                </ul>
                                <p><b><i class="fa fa-money"></i>&nbsp; Evento Pago via {{$evento->tipo}}</b>, para <b>{{$evento->quantidade}}</b> pessoas num total de <b>{{$evento->valor}},00</b></p>
                                <a href="{{url('requisitar-qrCode/'.$evento->id_aquisicao)}}" class="btn btn-pri">Gerar QR.Code</a>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <ul class="pagination clearfix">
                        {{ $eventos->links() }}
                    </ul>
                </div>
            </div>

            <div class="col-md-3">
                <aside id="aside" class="aside-bar-style-two clearfix">
                    <div class="widget border-remove clearfix">
                        <div class="eventform-con ">
                            <form>
                                <div class="form-input search-location">
                                    <input type="text" placeholder="Pesquisar evento">

                                    <button class="icon fa fa-search"></button>
                                </div>
                            </form>
                        </div>
                    </div>


                    <div class="widget news">
                        <h3 class="title">Partilhar Link</h3>
                        <form>
                            <div class="form-group">
                                <input type="text" placeholder="email dum conhecido">
                                <button class="icon fa fa-paper-plane-o "></button>
                            </div>
                            <button class="btn btn-disabled">Enviar</button>
                        </form>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
@if(Session::has('success'))
<script>
Swal.fire({
    position: 'center',
    type: 'success',
    title: 'Pagamento Efectuado com Sucesso',
    showConfirmButton: true,
});
</script>
@endif


@if(Session::has('sucessoEdicao'))
<script>
Swal.fire({
    position: 'center',
    type: 'success',
    title: 'Perfil editado com sucesso',
    showConfirmButton: true,
});
</script>
@endif

<!-- Modal -->
<div class="modal fade" id="uploadFotoPerfil" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Carregar a imagem</h4>
            </div>
            <form action="{{ url('perfil-perfil-salvar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <p>Clique no botão abaixo para carregar a sua foto.</p>
                    <div class="row">

                        <div class="col-md-7">
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="col-md-5">
                            <button class="btn btn-success btn-small">Salvar</button>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"  data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>

    </div>
</div>


<script>
    $(document).ready(function () {
        //PARTILHA
        $("body").on("click", ".btn-form-upload-foto", function () {
            $('#uploadFotoPerfil').modal('show');
        });

    });
</script>


@endsection
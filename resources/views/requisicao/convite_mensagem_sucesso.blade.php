@extends('layouts.app')

@section('content')

<?php

use App\Http\Controllers\LocalController;

$local = LocalController::local();
?>


<!-- Sub Banner -->
<section class="sub-banner newsection">
    <div class="container">
        <h2 class="title">Requisição do bilhete</h2>       
    </div>
</section>
<div class="contact newsection">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="event-content">
                            <div class="alert alert-success" role="alert">
                                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                Requisição submetida com sucesso
                            </div>
                        </div>
                        <p><b>Importante: </b>O seu pedido esta pendente e será respondindo em breve, para ver a resposta navegue o menu principal na opção convites </p>
                        <a href="{{url('requisicao-convites')}}" ><img src="{{asset('public/img/menu-principal.png')}}" style="width: 300px"/></a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6">
                <!-- Map -->
                <div class="map-container">
                    <h2 class="title"> {{$evento->nome}}</h2>
                    <div><img src="{{$eventImagePath.'/'.$evento->foto}}" alt="" /></div>
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



@endsection
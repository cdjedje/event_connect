@extends('layouts.app')

@section('content')

<?php

use App\Http\Controllers\LocalController;

$local = LocalController::local();
?>


<!-- Sub Banner -->
<section class="sub-banner newsection">
    <div class="container">
        <h2 class="title">Editar Perfil</h2>
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

                <form method="post"  action="{{ url('perfil-salvar-edicao') }}" id="contactform">
                    @csrf

                    <div class="response">&nbsp;</div>

                        <div class="row">
                        <div class="col-md-6">
                            <div class="response">&nbsp;</div>
                            <p><label for="contactname">Nome @error('nome')<span style="color: #c10e0a"> * {{ $message }}</span>@enderror</label>
                                <input id="contactname" type="text" name="nome" value="{{  $cliente->nome }}" autofocus placeholder="Seu nome" class="textflied">
                                <i class="icon fa fa-user"></i>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <div class="response">&nbsp;</div>
                            <p><label for="contactname">Apelido @error('apelido')<span style="color: #c10e0a"> * {{ $message }}</span>@enderror</label>
                                <input id="contactname" type="text" name="apelido" value="{{  $cliente->apelido }}" autofocus placeholder="Seu apelido" class="textflied">
                                <i class="icon fa fa-user"></i>
                            </p>
                        </div>
                    </div>
                    <br>
                     <p>
                         <label for="contactname">Data de Nascimento @error('dataNascimento')<span style="color: #c10e0a"> * {{ $message }}</span>@enderror</label>
                        <input id="contactname" type="text"  name="dataNascimento" value="{{  $cliente->dataNascimento }}"  placeholder="Data de nascimento" class="date_timepicker_start textflied">
                        <i class="icon fa fa-calendar"></i>
                    </p>
                    <p>
                        <label class="radio-inline"> 
                            <input type="radio" name="sexo" value="Masculino" @if($cliente->sexo=='Masculino') checked @endif> Masculino
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="sexo"  value="Femenino" @if($cliente->sexo=='Femenino') checked @endif> Femenino
                        </label>
                    </p>
                    <p ><label for="contactname">Residente em ? @error('cidadeId')<span style="color: #c10e0a"> * {{ $message }}</span>@enderror</label>
                        <select id="contactname" name="cidadeId" required=""  class="textflied">
                             @foreach($local as $local)
                            <option  value="{{$local->id}}" @if($cliente->localId==$local->id) selected @endif>{{$local->nome}}</option>
                            @endforeach
                        </select>
                        <i class="icon fa fa-book"></i>
                    </p>
                    <p ><label for="contactname">Numero de telefone @error('numTelefone')<span style="color: #c10e0a"> * {{ $message }}</span>@enderror</label>
                        <input id="contactname" type="text"  name="numTelefone" value="{{$cliente->numTelefone }}" autocomplete="Seu contacto" autofocus placeholder="Seu contacto" class="textflied">
                        <i class="icon 	fa fa-phone"></i>
                    </p>
                   
                    <p ><label for="contactname">Email @error('email')<span style="color: #c10e0a"> * {{ $message }}</span>@enderror</label>
                        <input id="contactname" type="text"  name="email" disabled="" value="{{ $cliente->email }}"  class="textflied">
                        <i class="icon fa fa-envelope"></i>
                    </p>
             
                    <button type="submit" name="submit" id="submitButton" title="Click here to submit your message!" class="btn btn-primary">Salvar Alterações  </button>
                    </p>
                </form>
            </div>

            <div class="col-md-6 col-sm-6">
                <!-- Map -->
                <div class="map-container">
                    <h2 class="title"> Esteja atento para novos eventos</h2>
                    <div><img src="{{asset('public/website/img/login.jpg')}}" style="width: 300px;border-radius: 50%;"></div>
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

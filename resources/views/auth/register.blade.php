@extends('layouts.app')

@section('content')

<?php

use App\Http\Controllers\LocalController;

$local = LocalController::local();
?>


<!-- Sub Banner -->
<section class="sub-banner newsection">
    <div class="container">
        <h2 class="title">Registar-se</h2>
        <ul class="breadcrumb">
            <li><a href="">Eventos</a></li>
            <li>Todas Categorias</li>
        </ul>
    </div>
</section>

<div class="contact newsection">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <!-- login facebook -->
                <br>
                <h4>Registe-se com o seu facebook</h4>
                </br>
                <div class="contactinfo">
                    <a href="{{url('login/facebook')}}" title="fazer login com facebook">
                        <img src="{{asset('public/img/button-login-facebook.png')}}" alt="" style="width: 200px" />
                    </a>
                </div>
                </br>
                <h6>Ou</h6>
                </br>
            </div>
            <div class="col-md-6 col-sm-6">

                <form method="post" action="{{ url('cliente-salvar-novo') }}" id="contactform">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="response">&nbsp;</div>
                            <p><label for="contactname">Nome @error('nome')<span style="color: #c10e0a"> * {{ $message }}</span>@enderror</label>
                                <input id="contactname" type="text" name="nome" value="{{ old('nome') }}" autofocus placeholder="Seu nome" class="textflied">
                                <i class="icon fa fa-user"></i>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <div class="response">&nbsp;</div>
                            <p><label for="contactname">Apelido @error('apelido')<span style="color: #c10e0a"> * {{ $message }}</span>@enderror</label>
                                <input id="contactname" type="text" name="apelido" value="{{ old('apelido') }}" autofocus placeholder="Seu apelido" class="textflied">
                                <i class="icon fa fa-user"></i>
                            </p>
                        </div>
                    </div>
                    <br>
                    <!--div class="row">
                        <div class="col-md-6">
                            <p>
                                <label for="contactname">Data de Nascimento @error('dataNascimento')<span style="color: #c10e0a"> * {{ $message }}</span>@enderror</label>
                                <input id="contactname" type="text" name="dataNascimento" value="{{ old('dataNascimento') }}" autofocus placeholder="Data de nascimento" class="date_timepicker_start textflied">
                                <i class="icon fa fa-calendar"></i>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><br><br>
                                <label class="radio-inline">
                                    <input type="radio" name="sexo" value="Masculino" checked> Masculino
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="sexo" value="Femenino"> Femenino
                                </label>
                            </p>
                        </div>
                    </div>
                    <br-->
                    <!--p><label for="contactname">Residente em ? @error('localId')<span style="color: #c10e0a"> * {{ $message }}</span>@enderror</label>
                        <select id="contactname" name="localId" required="" class="textflied">
                            @foreach($local as $local)
                            @if($local->nivel==2)
                            <option value="{{$local->id}}" @if($local->id==old('localId')) selected @endif>{{$local->nome}}</option>
                            @endif
                            @endforeach
                        </select>
                        <i class="icon fa fa-book"></i>
                    </p-->

                    <!-- <div class="row">
                        <div class="col-md-6">
                            <p ><label for="contactname">Codigo do Pais  @error('codigoTelefonePais')<span style="color: #c10e0a"> * {{ $message }}</span>@enderror</label>
                                <select id="contactname"    name="codigoTelefonePais"   class="textflied">
                                    @foreach($codigopais as $codigo)
                                    <option  value="{{$codigo->id}}" @if($codigo->id=='+258') selected @endif>({{$codigo->id}}) {{$codigo->pais}}</option>
                                    @endforeach
                                </select>
                                </select>
                                <i class="icon 	fa fa-phone"></i>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p ><label for="contactname">Numero de telefone  @error('numTelefone')<span style="color: #c10e0a"> * {{ $message }}</span>@enderror</label>
                                <input id="contactname" type="text"  name="numTelefone" value="{{ old('numTelefone') }}" maxlength="9"  autofocus placeholder="Seu contacto" class="textflied">
                                <i class="icon 	fa fa-phone"></i>
                            </p>
                        </div>
                    </div> -->
                    <!--input id="contactname" type="hidden" name="codigoTelefonePais" value="{{ old('numTelefone') }}" maxlength="9" autofocus placeholder="Seu contacto" class="textflied">
                    <input id="contactname" type="hidden" name="numTelefone" value="{{ old('numTelefone') }}" maxlength="9" autofocus placeholder="Seu contacto" class="textflied">
                    <br-->

                    <p><label for="contactname">Email @error('email')<span style="color: #c10e0a"> * {{ $message }}</span>@enderror</label>
                        <input id="contactname" type="text" name="email" value="{{ old('email') }}" autofocus placeholder="Email" class="textflied">
                        <i class="icon fa fa-envelope"></i>
                    </p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="response">&nbsp;</div>
                            <p><label for="contactname">Criar senha @error('password')<span style="color: #c10e0a"> * {{ $message }}</span>@enderror</label>
                                <input id="contactname" type="password" name="password" autofocus placeholder="criar uma senha" class="textflied">
                                <i class="icon fa fa-lock"></i>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <div class="response">&nbsp;</div>
                            <p><label for="contactname">Repetir a senha @error('password_confirmation')<span style="color: #c10e0a"> * {{ $message }}</span>@enderror</label>
                                <input id="contactname" type="password" name="password_confirmation" autofocus placeholder="confirmar a senha" class="textflied">
                                <i class="icon fa fa-lock"></i>
                            </p>
                        </div>
                    </div>
                    <!--p><label for="contactname">Criar senha @error('password')<span style="color: #c10e0a"> * {{ $message }}</span>@enderror</label>
                        <input id="contactname" type="password" name="password" autofocus placeholder="criar uma senha" class="textflied">
                        <i class="icon fa fa-lock"></i>
                    </p>
                    <p><label for="contactname">Repetir a senha @error('password_confirmation')<span style="color: #c10e0a"> * {{ $message }}</span>@enderror</label>
                        <input id="contactname" type="password" name="password_confirmation" autofocus placeholder="confirmar a senha" class="textflied">
                        <i class="icon fa fa-lock"></i>
                    </p-->
                    <!-- <p ><label for="contactname">Repetir a senha @error('password_confirmation')<span style="color: #c10e0a"> * {{ $message }}</span>@enderror</label>

                    </p> -->
                    <br>
                    <button type="submit" name="submit" id="submitButton" title="Clique aqui para criar uma conta" class="btn btn-primary">Registar</button>
                    </p>
                </form>
            </div>

            <div class="col-md-6 col-sm-6">
                <!-- Map -->
                <div class="map-container">
                    <h2 class="title"> Esteja atento para novos eventos</h2>
                    <div><img src="{{asset('public/website/img/login.jpg')}}" style="width: 300px;border-radius: 50%;"></div>
                    <!-- login facebook -->
                    <br>
                    <!-- <div class="contactinfo"> 
                        <a href="{{url('login/facebook')}}" title="fazer login com facebook">
                            <img src="{{asset('public/img/button-login-facebook.png')}}" alt="" style="width: 200px"/>
                        </a>
                    </div> -->
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
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
        <h2 class="title">Login</h2>
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

                <form method="post"  action="{{ route('login') }}" id="contactform">
                    @csrf
                    <p ><label for="contactname">Email ou numero de telefone                            
                            @if (session('falha_email'))
                            <span style="color: #c10e0a"> * {{session('falha_email')}}</span>
                            @endif
                        </label>
                        @if (session()->has('falha_senha'))
                        <input id="contactname" type="text" name="email" value="{{session('email')}}" class="textflied">
                        <i class="icon fa fa-check-circle" style="color: #26aa28"></i>
                        @else
                        <input id="contactname" type="text"  name="email" value="{{session('email')}}" required autofocus placeholder="Seu email ou numero de telefone" class="textflied">
                        <i class="icon fa fa-envelope"></i>
                        @endif

                    </p>
                    @if (session()->has('falha_senha'))
                    <p><label for="contactname">Senha
                            @if (session('falha_senha'))
                            <span style="color: #c10e0a"> * {{session('falha_senha')}}</span>
                            @endif
                        </label>
                        <input id="contactname" type="password"  name="password" value="" required  autofocus placeholder="Sua senha" class="textflied">
                        <i class="icon fa fa-lock"></i>
                    </p>
                    @endif
                    <p>
                        <button title="Clique aqui para entrar no sistema!" class="btn btn-primary">Login</button>
                        <!-- <a href="#" title="Clique aqui para recuperar a senha!">Recuperar Senha</a> -->
                    </p>
                    <!-- login facebook -->
                     <div class="contactinfo"> 
                        <h4>ou</h4>
                        <a href="{{url('login/facebook')}}" title="fazer login com facebook">
                            <img src="{{asset('public/img/button-login-facebook.png')}}" alt="" style="width: 200px"/>
                        </a>
                    </div>
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


@endsection

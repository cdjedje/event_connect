<?php

use App\Http\Controllers\CategoriaController;

$categorias = CategoriaController::categorias();
?>

<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Eventconnect</title>

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900,200italic,300italic,400italic,600italic,700italic,900italic' rel='stylesheet' type='text/css'>
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="apple-touch-icon" href="{{asset('public/img/favicon.png')}}">
    <link rel="shortcut icon" href="{{asset('public/img/favicon.png')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('public/css/font-awesome.min.css')}}">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('public/css/jquery.datetimepicker.css')}}">
    <link rel="stylesheet" href="{{asset('public/css/main.css')}}">
    <script type="text/javascript">
        var switchTo5x = true;
    </script>
    <script type="text/javascript" src="../../w.sharethis.com/button/buttons.js"></script>
    <script type="text/javascript" defer>
        stLight.options({
            publisher: "ur-b4964695-8b2f-20dd-2ced-c9f6141de24c",
            doNotHash: false,
            doNotCopy: false,
            hashAddressBar: false
        });
    </script>

<style>
    .giveMeEllipsis {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2; /* number of lines to show */
        height: 45px;
    }
</style>


</head>

<body>

    <!-- Header -->
    <header class="header-container">
        <!-- header Top -->
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        @if(!session()->has('nomeCliente'))
                        <ul class="login-details clearfix">
                            <li><a href="{{url('login')}}" class="agenticon">Login</a></li>
                            <li class="customericon">Ainda não tem conta ?</li>
                            <li><a href="{{url('registar-cliente')}}" class="pri-color">Registar-se </a></li>
                        </ul>
                        @else
                        <ul class="login-details clearfix">
                            <li><a href="{{url('perfil')}}" class="agenticon">Meu Perfil</a></li>
                            <li><a href="{{ url('logout') }}" class="pri-color" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out"></i> Terminar a Sessão
                                </a>
                            </li>
                        </ul>
                        <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        @endif

                    </div>
                    <div class="col-md-6">
                        <div class="social-icon pull-right">
                            <a href="https://www.facebook.com/Eventconnectcomz-108322994101414/" target="_blank" class="facebook fa fa-facebook"></a>
                            <!-- <a href="#" class="twitter fa fa-twitter"></a>
                            <a href="#" class="instagram fa fa-instagram"></a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Header -->
        <div class="main-header affix">
            <!-- Moblie Nav Wrapper  -->
            <div class="mobile-nav-wrapper">
                <div class="container ">
                    <!-- logo -->
                    <div id="logo">
                        <a href="{{url('/')}}"><img src="{{asset('public/img/logotipo.jpg')}}" style="width: 300px" alt=""></a>
                    </div>

                    <!-- Search -->
                    <div id="sb-search" class="sb-search">
                        <form action="{{url('pesquisar-eventos')}}" method="get">
                            <input class="sb-search-input" placeholder="Pesquisar..." type="text" id="autocompleteID" name="term">
                            <input class="sb-search-submit" type="submit" value="">
                            <span class="sb-icon-search"></span>
                        </form>
                    </div>
                    <!-- Moblie menu Icon -->
                    <div class="mobile-menu-icon">
                        <i class="fa fa-bars"></i>
                    </div>
                    <!-- Main Nav -->
                    <nav class="main-nav mobile-menu">
                        <ul class="clearfix">
                            <li><a href="{{url('/')}}">Início</a></li>
                            <li><a href="{{url('/about')}}">Quem Somos ?</a></li>

                            @if(!session()->has('nomeCliente'))
                            <li class="parent"><a href="#">Categorias</a>
                                <!-- Sub Menu -->
                                <ul class="sub-menu">
                                    <li class="arrow"></li>
                                    @foreach($categorias as $categoria)
                                    <li><a href="{{url('eventos/'.$categoria->id)}}">{{$categoria->nome}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li><a href="{{url('registar-cliente')}}"><i class="fa fa-user"></i> Registar-se</a></li>
                            <li><a href="{{url('login')}}"><i class="fa fa-lock"></i> Login</a></li>
                            @else
                            <li><a href="{{url('requisicao-convites')}}"><i class="fa fa-envelope"></i> Convites</a></li>
                            <li><a href="{{url('eventos-favoritos')}}"><i class="fa fa-heart"></i> Favoritos</a></li>
                            <li><a href="{{url('perfil')}}"><i class="fa fa-user"></i> {{session('nomeCliente')}}</a></li>
                            <li><a href="{{ url('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> Terminar Sessão</a></li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- header -->


    <!-- corpo da pagina (dimanica) -->
    @yield('content')
    <!-- corpo da pagina (dimanica) - -->



    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="row">
                <div class="widget col-md-3">
                    <div class="about">
                        <h2 class="title">Quem Somos ? <span class="border"></span></h2>
                        <p> A Eventconnect é uma plataforma que conecta pessoas a eventos em todo mundo,
                            desde o momento de descoberta à realização do evento.</p>
                    </div>
                </div>

                <div class="widget col-md-3">
                    <h2 class="title">Localização <span class="border"></span></h2>
                    <div class="recent-blog">
                        <ul class="fa-ul">
                            <li><i class="fa-li fa fa-map-marker"></i>Av. 25 de Setembro 147,
                                Maputo - Mocambique</li>
                        </ul>
                    </div>
                </div>

                <div class="widget lastest-tweets col-md-3">
                    <h2 class="title">Contactos<span class="border"></span></h2>
                    <ul class="fa-ul">
                        <li> <i class="fa-li fa fa-phone fa-flip-horizontal"></i>+258844118531</li>
                        <li><i class="fa-li fa fa-envelope-o "></i><a href="#">info@eventconnect.co.mz</a></li>
                    </ul>
                </div>

                <div class="widget col-md-3">
                    <h2 class="title">Subscrição<span class="border"></span></h2>
                    <div class="recent-blog">
                        <div class="recent-img">
                            <img src="{{asset('public/img/recent-2.png')}}" alt="">
                        </div>
                        <div class="recent-content">
                            <h3 class="title"><a href="#"></a> </h3>
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input class="form-control" type="email" id="subEmail" placeholder="email">
                            <button onclick="salvarSubscricao()" style="margin-top: 10px" class="btn btn-primary btn-small" type="button">Subscrever-se</button>
                            <p style="font-size: 13px; margin-top: 10px">Para cancelar subscrição contacte-nos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <script src="{{asset('public/js/plugins.js')}}" defer></script>
    <script src="{{asset('public/js/main.js')}}" defer></script>
    <!--------partilhar o link do evento--------->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_PT/sdk.js#xfbml=1&version=v5.0"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">

    <script>
        $(document).ready(function() {
            //LIKE
            $("body").on("click", ".btn-gosto", function() {
                var id = $(this).data('id-evento');
                 var x = $(this).css('color');
             
                 if(x=='rgb(90, 180, 230)'){
                     $(this).css('color', '#337ab7');
                 }else{
                      $(this).css('color', '#c3c8cd');
                 }
               
                $.get('<?php echo url("/accao-gosto/") ?>/' + id, function(data) {}).done(function() {
              
                }).fail(function(error) {});
            });

            //INTERESSE
            $("body").on("click", ".btn-quero", function() {
                 var id = $(this).data('id-evento');
                 var x = $(this).css('color');
             
                 if(x=='rgb(90, 180, 230)'){
                     $(this).css('color', '#337ab7');
                 }else{
                      $(this).css('color', '#c3c8cd');
                 }
                $.get('<?php echo url("/accao-interesse/") ?>/' + id, function(data) {}).done(function() {
            
                }).fail(function(error) {});
            });

            //PARTILHA
            $("body").on("click", ".btn-partilhar", function() {
                var url = $(this).data('id-evento');
                $('#partilha_iframe').attr('src', "https://www.facebook.com/plugins/share_button.php?href=http%3A%2F%2Feventconnect.co.mz%2Feventos-detalhes%2F" + url + "&layout=button_count&size=small&appId=558818658057814&width=115&height=20")
                $('#modalPartilha').modal('show');
            });

        });
    </script>

    <script>
        function salvarSubscricao() {
            var email = $("#subEmail").val();
            if (email != "") {
                $.ajax({
                    url: "{{url('subscrition')}}",
                    type: "POST",
                    data: {
                        _token: $('#token').val(),
                        email: email
                    },
                    success: function(data) {
                        $("#subEmail").val("");
                        alert("Subscrição efectuada com sucesso.")
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("Erro ao salvar, tente novamente")
                        console.log()
                    }
                });
            } else {
                alert("Por favor preencha um email válido")
            }
        }
    </script>

    <!-- Modal -->
    <div class="modal fade" id="modalPartilha" role="dialog">
        <div class="modal-dialog modal-sm">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="icon fa fa-share"></i> Partilhar este evento</h4>
                </div>
                <div class="modal-body">
                    <center>
                        <iframe id="partilha_iframe" src="https://www.facebook.com/plugins/share_button.php?href=http%3A%2F%2Feventconnect.co.mz%2Feventos-detalhes%2F&layout=button_count&size=small&appId=558818658057814&width=115&height=20" width="115" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
                    </center>
                </div>
            </div>

        </div>
    </div>
    

    
</body>


</html>
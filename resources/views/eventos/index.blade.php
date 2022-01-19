@extends('layouts.app')

@section('content')



<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <!-- <li data-target="#myCarousel" data-slide-to="3"></li> -->
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">

        <div class="item active">
            <img src="{{asset('public/img/benner1copy.png')}}" alt="Evento Maputo" style="width:100%;">
            <!--div class="carousel-caption">
                <h3>Nao perca o grande espetaculo</h3>
                <p>No estado de zimpeto</p>
            </div-->
        </div>

        <div class="item">
            <img src="{{asset('public/img/banner2copy.png')}}" alt="Evento Maputo" style="width:100%;">
        </div>

        <div class="item">
            <img src="{{asset('public/img/banner3copy.png')}}" alt="Evento Maputo" style="width:100%;">
        </div>

        <!-- <div class="item">
            <img src="{{asset('public/img/banner4copy.png')}}" alt="Evento Maputo" style="width:100%;">
        </div> -->

    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Anterior</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Proximo</span>
    </a>
</div>

</div>
<!-- Event Form -->
<section class="eventform newsection">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <small>Procure</small>
                <h2 class="title">eventos</h2>
            </div>

            <div class="col-md-10 eventform-con">
                <form action="{{url('/get-eventos')}}" method="get" autocomplete="off">
                    <div class="form-input">
                        <div class="styled-select">
                            <select name="localId" required="">
                                <option value="todos">Localização </option>
                                <option value="todos">Todos </option>
                                @foreach($locals as $local)
                                <option value="{{$local->id}}">{{$local->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-input">
                        <input type="text" placeholder="Entre a data ?" class="date_timepicker_start" name="data1" >
                        <button type="button" value="open" class="open icon fa fa-calendar"></button>
                    </div>


                    <div class="form-input">
                        <input type="text" placeholder="até a data ? " class="date_timepicker_end" name="data2" autocomplete="false">
                        <button type="button" value="open" class="end icon fa fa-calendar"></button>
                    </div>

                    <div class="form-input">
                        <div class="styled-select">
                            <select name="categoriaId" required="">
                                <option value="todos">Categoria</option>
                                <option value="todos">Todos</option>
                                @foreach($categorias as $categoria)
                                <option value="{{$categoria->id}}">{{$categoria->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-input ">
                        <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                    </div>


                </form>
            </div>
        </div>
    </div>
</section>

<!-- Events  -->
<section class="events newsection">
    <div class="container">
        <h2 class="title">Próximos Eventos</h2>
        <!-- Item Grid & Item List -->
        <div class="grid-list event-container clearfix checkcolumn">
            <div class="row">
                <!-- Event -->
                @foreach($eventos as $evento)
                <div class="event-border col-md-3">
                    <div class="event clearfix">
                        <div class="eventsimg">
                            <img src="{{$eventImagePath.'/'.$evento->foto}}" alt="">
                        </div>
                        <div class="event-content" style="text-align: justify">
                            <b style="color: #d1410c"> <i class="icon fa fa-calendar"></i> &nbsp; Inicio: {{ date_format(date_create($evento->dataInicio) ,"d-m-Y") }} as {{$evento->horaInicio}} @if($evento->dataFim!=null || $evento->dataFim!='') <br><i class="fa fa-arrow-circle-right"></i> &nbsp;Até {{ date_format(date_create($evento->dataFim) ,"d-m-Y") }} @endif</b>
                            <div class="giveMeEllipsis"><h3 class="title"><a href="{{url('eventos-detalhes/'.$evento->url)}}">{{$evento->nome}} </a></h3></div>
                            <p>
                                <i class="icon fa fa-map-marker"></i>&nbsp; Local: {{$evento->local}}
                            </p>

                            @if($evento->estado=='PENDENTE')
                            <a href="{{url('eventos-detalhes/'.$evento->url)}}" class="btn btn-pri-2" style="display: block">Detalhes</a>
                            @else
                            <a href="#" class="btn btn-disabled disabled" style="display: block">{{$evento->estado}}</a>
                            @endif
                        </div>
                        <div class="links clearfix">
                            @if(!session()->has('nomeCliente'))
                            <ul>
                                <li><a class='btn-partilhar'  data-id-evento="{{$evento->url}}"><i class="icon fa fa-share"></i> Partilhar</a></li>
                                <li><a href="{{route('login')}}"><i class="fa fa-thumbs-up"></i> Gosto</a></li>
                                <li><a href="{{route('login')}}"><i class="icon fa fa-heart"></i> Quero</a> </li>
                            </ul>
                            @else
                            <ul>
                                <li><a class='btn-partilhar'  data-id-evento="{{$evento->url}}"><i class="icon fa fa-share"></i> Partilhar</a></li>
                                @if($accao->isEmpty())  
                                <li><a href="javascript:void(0)" data-id-evento="{{$evento->id}}" class="btn-gosto"><i class="fa fa-thumbs-up"></i> Gosto</a></li>
                                <li><a href="javascript:void(0)" data-id-evento="{{$evento->id}}" class="btn-quero"><i class="icon fa fa-heart"></i> Quero</a> </li>
                                @else

                                <?php $like = 0;
                                $interesse = 0; ?>
                                @foreach($accao as $acao)
                                @if($acao->eventoId==$evento->id && $acao->tipo=='LIKE')
									<?php $like += 1; ?>
                                @endif

                                @if($acao->eventoId==$evento->id && $acao->tipo=='INTERESSE')
									<?php $interesse += 1; ?>
                                @endif
                                @endforeach



                                @if($like>0)
                                <li><a href="javascript:void(0)" data-id-evento="{{$evento->id}}" class="btn-gosto" style="color: #337ab7"><i class="fa fa-thumbs-up" ></i> Gosto</a></li>
                                @else
                                <li><a href="javascript:void(0)" data-id-evento="{{$evento->id}}" class="btn-gosto"><i class="fa fa-thumbs-up"></i> Gosto</a></li>
                                @endif

                                @if($interesse>0)
                                <li><a href="javascript:void(0)" data-id-evento="{{$evento->id}}" class="btn-quero" style="color: #337ab7"><i class="icon fa fa-heart" ></i> Quero</a> </li>
                                @else
                                <li><a href="javascript:void(0)" data-id-evento="{{$evento->id}}" class="btn-quero"><i class="icon fa fa-heart" ></i> Quero</a> </li>
                                @endif

									<?php $like = 0;
									$interesse = 0; ?>
                                @endif
                            </ul>
                            @endif

                        </div>
                    </div>
                </div>
                @endforeach
                <!-- Event -->

            </div>
        </div>
        <!-- Pagination -->
        <ul class="pagination clearfix">
            {{ $eventos->links() }}
        </ul>
    </div>
</div>
</section>

@endsection
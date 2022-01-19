@extends('layouts.app')

@section('content')

<!-- Sub Banner -->
<section class="sub-banner newsection">
    <div class="container">
        <h2 class="title">FAVORITOS</h2>
        <ul class="breadcrumb">
            <li><a href="">Eventos</a></li>
            <li>Todas Categorias</li>
        </ul>
    </div>
</section>

<!-- Events  -->
<section class="events newsection">
    <div class="container">
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
                            <b style="color: #d1410c">  <i class="icon fa fa-calendar"></i> &nbsp; Inicio: {{ date_format(date_create($evento->dataInicio) ,"d-m-Y") }} as {{$evento->horaInicio}} @if($evento->dataFim!=null || $evento->dataFim!='') <br><i class="fa fa-arrow-circle-right"></i> &nbsp;Até {{ date_format(date_create($evento->dataFim) ,"d-m-Y") }}  @endif</b>
                            <h3 class="title"><a href="{{url('eventos-detalhes/'.$evento->id)}}">{{$evento->nome}} </a></h3>
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
                            <ul>
                                <li><a class='btn-partilhar'  data-id-evento="{{$evento->url}}"><i class="icon fa fa-share"></i> Partilhar</a></li>
                                @if($accao->isEmpty())  
                                <li><a href="javascript:void(0)" data-id-evento="{{$evento->id}}" class="btn-gosto"><i class="fa fa-thumbs-up"></i> Gosto</a></li>
                                <li><a href="javascript:void(0)" data-id-evento="{{$evento->id}}" class="btn-quero"><i class="icon fa fa-heart"></i> Quero</a> </li>
                                @else

                                <?php $like = 0;
                                $interesse = 0;
                                ?>
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
                                $interesse = 0;
                                ?>
                                @endif
                            </ul>
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
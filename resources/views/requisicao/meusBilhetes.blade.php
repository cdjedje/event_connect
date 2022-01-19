@extends('layouts.app')

@section('content')

<!-- Sub Banner -->
<section class="sub-banner newsection">
    <div class="container">
        <h2 class="title">Meu Bilhetes</h2>
        <ul class="breadcrumb">
            <li><a href="">Eventos</a></li>
            <li>Todas Categorias</li>
        </ul>
    </div>
</section>

<!-- Events -->
<section class="events newsection">
    <div class="container">
        <h2 class="text-left">Eventos submetidos</h2><hr><br>
        <div class="row">
            <div class="blog col-md-9">
                <div class="clearfix">

                    @foreach($bilhetes as $evento)
                    <div class="event-container clearfix">
                        <div class="event clearfix">
                            <div class="eventsimg">
                                <img src="{{asset('public/img/evento.jpg')}}" alt="">
                            </div>
                            <div class="event-content">
                                <h3 class="title">{{$evento->nome}} (Preço: {{$evento->preco}},00Mt)</h3>
                                <ul class="meta">
                                    <li><a href="#"><i class="fa fa-arrow-circle-right"></i> &nbsp; Categoria: {{$evento->categoria}}</a>
                                    <li class="date"><i class="icon fa fa-calendar"></i> {{ date_format(date_create($evento->dataInicio) ,"d-m-Y") }} as {{$evento->horaInicio}} @if($evento->dataFim!=null || $evento->dataFim!='') ate {{ date_format(date_create($evento->dataFim) ,"d-m-Y") }}  @endif</li>
                                    <!--li><a href="#"><i class="icon fa fa-comment"></i> {{$evento->nome}}</a> </li>
                                    <li><a href="#"><i class="icon fa fa-user"></i>{{$evento->nome}}</a></li-->
                                </ul>
                                <div>
                                    <?php echo $evento->descricao; ?>
                                </div>
                                <p><b><i class="fa fa-money"></i>&nbsp;  Evento Pago via {{$evento->tipo}}</b>, para {{$evento->quantidade}} pessoas num total de {{$evento->valor}},00Mt</p>
                                <!--a href="{{url('eventos-detalhes/'.$evento->codigo)}}" class="btn btn-disabled">Ver evento</a-->
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <ul class="pagination clearfix">
                        <li class=""><a href="#"><i class="fa fa-angle-left"></i></a></li>
                        <li class=""><a href="#">1</a></li>
                        <li class=""><a href="#"><i class="fa fa-angle-right"></i></a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-3">
                <aside id="aside" class="aside-bar-style-two clearfix">
                    <div class="widget border-remove clearfix">
                        <div class="eventform-con ">
                            <form>
                                <div class="form-input search-location">
                                    <input type="text" placeholder="Pesquisar evento" >

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


@endsection
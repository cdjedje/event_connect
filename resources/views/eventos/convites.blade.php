@extends('layouts.app')

@section('content')

<!-- Sub Banner -->
<section class="sub-banner newsection">
    <div class="container">
        <h2 class="title">Pedidos de convite</h2>
    </div>
</section>

<!-- Events -->
<section class="events newsection">
    <div class="container">
        <div class="row">
            <div class="blog col-md-9">
                <div class="clearfix">

                    @foreach($convites as $convite)
                    <div class="event-container clearfix">
                        <div class="event clearfix">
                            <div class="eventsimg">
                                <img src="{{$eventImagePath.'/'.$convite->foto}}" alt="">
                            </div>
                            <div class="event-content">
                                <h3 class="title">{{$convite->titulo}}</h3>
                                <ul class="meta">
                                    <li><i class="fa fa-arrow-circle-right"></i> &nbsp; Categoria: {{$convite->categoria}}</li>
                                    <li><i class="fa fa-home"></i> &nbsp; Local: {{$convite->local}}</li>
                                    <li class="date"><i class="icon fa fa-calendar"></i> {{ date_format(date_create($convite->dataInicio) ,"d-m-Y") }} as  {{$convite->horaInicio}} @if($convite->dataFim!=null || $convite->dataFim!='') ate {{ date_format(date_create($convite->dataFim) ,"d-m-Y") }} @endif</li>
                                    <li><i class="fa fa-users"></i> &nbsp; Total participantes: {{$convite->qtd}}</li>
                                </ul> 
                                @if($convite->thisEstado=='PENDENTE')
                                <p><h4><span class="label label-warning">Pedido Pendente</span></h4></p>
                                @elseif($convite->thisEstado=='RECUSADO')
                                <p><h4><span class="label label-danger">Pedido Recusado</span></h4></p>
                                @else
                                <p>
                                    <h4><span class="label label-success">Pedido Aceite</span>
                                    <a href="{{url('requisitar-qrCode/'.$convite->aquisicaoId)}}" class="">Clique aqui para gerar QR.Code do convite</a>
                                    </h4>
                                </p>
                                @endif
                                 
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <ul class="pagination clearfix">
                         {{ $convites->links() }}
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



@endsection
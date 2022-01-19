@extends('layouts.app')

@section('content')
<?php
$isConvite = false;
$isPago = false;
?>
@foreach($bilhetes as $bilhete)
@if($bilhete->tipo=='CONVITE') <?php $isConvite = true; ?> @endif
@if($bilhete->tipo=='PAGO') <?php $isPago = true; ?> @endif
@endforeach



<!-- Sub Banner -->
<section class="sub-banner newsection">
    <div class="container">
        <h2 class="title">Detalhes do Evento</h2>
        <ul class="breadcrumb">
            <li><a href="#">Contacto: </a></li>
            <li>8256462741</li>
        </ul>
    </div>
</section>

<!-- Events -->
<section class="events newsection">
    <div class="container">
        <div class="row">
            <div class="single-blog col-md-9">
                <section class="event-container clearfix">
                    <div class="event clearfix">
                        <div class="eventsimg">
                            <img src="{{$eventImagePath.'/'.$evento->foto}}" alt="" />
                        </div>
                        <div class="event-content">
                            <h3 class="title"><a href="#">{{$evento->nome}} </a></h3>

                            <ul class="meta clearfix">
                                <li><a href="#"><i class="icon fa  fa-bookmark"></i>CATEGORIA: {{$evento->categoria}} </a>
                                <li class="date"><i class="icon fa fa-calendar"></i> {{ date_format(date_create($evento->dataInicio) ,"d-m-Y") }} as {{$evento->horaInicio}} @if($evento->dataFim!=null || $evento->dataFim!='') ate {{ date_format(date_create($evento->dataFim) ,"d-m-Y") }} @endif @if($evento->horaFim!=null || $evento->horaFim!='')pelas {{$evento->horaFim}} @endif</li>
                                <li><a href="#"><i class="icon fa fa-map-marker"></i> Local: {{$evento->local}}</a> </li>
                            </ul>

                            <div><?php echo $evento->descricao ?></div>
                            <br><br>
                            @if(!session()->has('nomeCliente'))
                            <a href="{{route('login')}}" style="color: #777;font-size: 18px"><i class="fa fa-thumbs-up"></i> Gosto</a>
                            <a href="{{route('login')}}" style="color: #777;font-size: 18px"><i class="fa fa-heart"></i> Quero participar</a>
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
                                    <a href="javascript:void(0)" id="gosto_id" style="color: #337ab7;font-size: 18px"><i class="fa fa-thumbs-up"></i> Gosto</a>
                                @else
                                    <a href="javascript:void(0)" id="gosto_id" style="color: #777;font-size: 18px"><i class="fa fa-thumbs-up"></i> Gosto</a>
                                @endif
                                @if($interesse>0)
                                    <a href="javascript:void(0)" id="interesse_id" style="color: #337ab7;font-size: 18px"><i class="fa fa-heart"></i> Quero participar</a>
                                @else  
                                 <a href="javascript:void(0)" id="interesse_id" style="color: #777;font-size: 18px"><i class="fa fa-heart"></i> Quero participar</a>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="sep"></div>
                </section>
                @if($evento->latitude!=null || $evento->latitude!='')
                <div class="comment-form newsection">
                    <h2 class="title">Localização do evento</h2>
                    <div id="mapa" style="height: 700px;width: 100%;"></div>

                </div>
                @endif
            </div>
            <!-- col-md-3 -->
            <div class="col-md-3">
                <aside id="aside" class="aside-bar-style-two clearfix">
                    <div class="widget border-remove clearfix">
                        <div class="eventform-con ">
                            <form>
                                <div class="form-input search-location">
                                    <input type="text" placeholder="Pesquisar">
                                    <button class="icon fa fa-search"></button>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if($isPago)
                    <div class="widget categories">
                        <h3 class="title">Bilhetes</h3>
                        <ul>
                            @foreach($bilhetes as $bilhete)
                            @if($bilhete->tipo!='CONVITE')
                            <li><a href="#">{{$bilhete->nome}} ({{$bilhete->preco}},00Mt)<span class="numbers"></span></a></li>
                            @endif
                            @endforeach
                        </ul>

                    </div>
                    @endif


                    @if($isPago)
                    @if(session()->has('nomeCliente'))
                    <a href="{{url('requisitar/'.$evento->id)}}" class="btn btn-primary"><i class="fa fa-bookmark"></i> Comprar Bilhete</a>
                    <br><br>
                    @else
                    <a href="{{route('login')}}" class="btn btn-primary"><i class="fa fa-bookmark"></i> Comprar Bilhete</a>
                    @endif
                    @endif
                    <br><br>

                    @if($isConvite)
                    <div class="widget categories">
                        <h3 class="title">Convites</h3>
                        @foreach($bilhetes as $bilhete)
                        @if($bilhete->tipo=='CONVITE')
                        <li><a href="#">{{$bilhete->nome}}<span class="numbers"></span></a></li>
                        @endif
                        @endforeach
                        </ul>
                    </div>
                    @endif

                    @if($isConvite)
                    @if(session()->has('nomeCliente'))
                    @if($contarPedidos==0)
                    <button class="btn btn-success" style="background-color: #b87a5c" data-toggle="modal" data-target="#modalRequisitarConvite">Requisitar Convite</button>
                    @else
                    <button id="convite_requisicao_submetida_id" class="btn btn-success" style="background-color: #b87a5c">Requisitar Convite</button>
                    @endif
                    @else
                    <a href="{{route('login')}}" class="btn btn-primary" style="background-color: #b87a5c"> Requisitar Convite</a>
                    @endif
                    <br><br>
                    @endif

                    <div class="widget news">
                        <h3 class="title"><i class="icon fa  fa-share"></i> Partilhar</h3>
                        <form>

                            <!--------partilhar o link do evento--------->


                            <!--whatsapp-->

                            <!--a href="https://wa.me/258849286935/?text=Salu" target="_blank"><img src="{{asset('public/img/whatsapp-logo-1.png')}}" style="width: 30px" alt=""/></a-->

                            <!--facebook-->
                            <iframe src="https://www.facebook.com/plugins/share_button.php?href=http%3A%2F%2Feventconnect.co.mz%2Feventos-detalhes%2F{{$evento->url}}&layout=button_count&size=small&appId=558818658057814&width=115&height=20" width="115" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>

                        </form>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>


<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready(function () {
    //LIKE
    $("#gosto_id").click(function () {
        $.get('<?php echo url("/accao-gosto/" . $evento->id) ?>/', function (data) {}).done(function () {
               var x = $('#gosto_id').css('color');
                if (x == 'rgb(119, 119, 119)') {
                $('#gosto_id').css('color', '#337ab7');
            } else {
                $('#gosto_id').css('color', '#777777');
            }
        }).fail(function (error) {});
    });
    //VISUALIZACAO
    $(window).bind("load", function () {
        $.get('<?php echo url("/accao-visualizado/" . $evento->id) ?>/', function (data) {}).done(function () {});
    });
    //INTERESSE
    $("#interesse_id").click(function () {
        $.get('<?php echo url("/accao-interesse/" . $evento->id) ?>/', function (data) {}).done(function () {
                 var x = $('#interesse_id').css('color');
                if (x == 'rgb(119, 119, 119)') {
                $("#interesse_id").css('color', '#337ab7');
            } else {
                $("#interesse_id").css('color', '#777777');
            }
        }).fail(function (error) {});
    });
    //CONVITE (REQUISICAO SUBMETIDA)
    $("#convite_requisicao_submetida_id").click(function () {
        Swal.fire({
            title: 'Convite já foi submetido ',
            html: "Para mais detalhes consulte no menu principal opção <b>convites</b> ",
            type: 'info',
            showCloseButton: true,
            //showCloseButton: '#3085d6',
            showCloseButton: '#d33',
            showCloseButton: 'OK',
        })
    });

    //SUBMETER REQUISICAO DO CONVITE 
    $("#submeter_requisicao_convite_id").click(function () {
        $.get("<?php echo url('/'); ?>" + "/requisitar-isConvite-diaponivel/" + $('#id_bilhete').val(), function (data) {
            if (data.quantidade >= $('#qtd_participante').val()) {
                $.get("<?php echo url('/'); ?>" + "/requisitar-convite?id_bilhete=" + $('#id_bilhete').val() + "&qtd_participantes=" + $('#qtd_participante').val() + "&id_evento={{$evento->id}}", function (data) {
                    window.location.href = "{{url('requisitar-convite-fim/'.$evento->id)}}";
                });
            } else {
                Swal.fire({
                    title: 'Pedido não foi permitido',
                    html: "Só restaram  <b>" + data.quantidade + " convites</b> ",
                    type: 'info',
                    showCloseButton: true,
                    //showCloseButton: '#3085d6',
                    showCloseButton: '#d33',
                    showCloseButton: 'OK',
                })
            }
        }).done(function () {

        }).fail(function (error) {});
    });
});
</script>


@if($evento->latitude!=null || $evento->latitude!='')
<!-- //mapas -->
<script src="https://maps.googleapis.com/maps/api/js?key=mapikey&amp;sensor=false"></script>

<script type="text/javascript">
var map;

function initialize() {
    var latlng = new google.maps.LatLng(-18.760134, 34.477308);
    var options = {
        zoom: 5.5,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("mapa"), options);
}

initialize();
marcadores();

function marcadores() {
    new google.maps.Marker({
        position: new google.maps.LatLng(<?php echo $evento->latitude; ?>, <?php echo $evento->longitude; ?>),
        title: '',
        map: map,
    });
}
</script>
@endif




<!-- Modal requisitar convite-->
<div class="modal fade" id="modalRequisitarConvite" role="dialog">
    <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="icon fa fa-send"></i> Requisitar Convite</h4>
            </div>
            <form method="post" action="{{ url('requisitar-convite') }}">
                @csrf
                <div class="modal-body">quantidade
                    <div class="form-group">
                        <label for="disabledSelect">Tipo de Bilhete</label>
                        <select id="id_bilhete" class="form-control" name="bilheteId">
                            @foreach($bilhetes as $bilhete)
                            @if($bilhete->tipo=='CONVITE')
                            <option value="{{$bilhete->id}}">{{$bilhete->nome}}</option>
                            @endif
                            @endforeach
                        </select>
                        <input type="hidden" name="eventoId" value="{{$evento->id}}" />
                    </div>
                    <div class="form-group">
                        <label for="disabledSelect">Total de Participantes ?</label>
                        <select id="qtd_participante" class="form-control" name="quantidade">
                            <option value="1">1</option>
                        </select>
                        <input type="hidden" name="eventoId" value="{{$evento->id}}" />
                    </div>
                </div>
                <div class="modal-footer">
                    <center>
                        <button type="button" id="submeter_requisicao_convite_id" class="btn btn-primary">Submeter</button>
                        <button type="button" class="btn btn-disabled" data-dismiss="modal">Cancelar</button>
                    </center>
                </div>
            </form>
        </div>

    </div>
</div>


@endsection
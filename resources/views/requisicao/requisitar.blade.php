@extends('layouts.app')

@section('content')

<?php

use App\Http\Controllers\LocalController;

$local = LocalController::local();
?>

<!-- Sub Banner -->
<section class="sub-banner newsection">
    <div class="container">
        <h2 class="title">Comprar Bilhete</h2>
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
                <div class="row">

                    <form action="{{url('payment')}}" method="post" id="contactform">
                        @if(isset($error))
                        <span style="color: #c10e0a">Quantidade escolhida excede ao número de bilhetes disponíveis</span>
                        @endif
                        <input type="hidden" value="{{$evento->id}}" name="id_evento">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="response">&nbsp;</div>
                                <p><label for="contactname">Nome do Cliente</label>
                                    <input id="contactname" type="text" name="email" value="{{ session('nomeCliente')}}" disabled="" class="textflied">
                                    <i class="icon fa fa-envelope"></i>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <div class="response">&nbsp;</div>
                                <p><label for="contactname">Tipo de Bilhete @error('email')<span style="color: #c10e0a"> * {{ $message }}</span>@enderror</label>
                                    <select id="id_bilhete" name="id_bilhete" type="text" class="textflied">
                                        @foreach($bilhetes as $bilhete)
                                        @if($bilhete->tipo!='CONVITE')
                                        <option value="{{$bilhete->id}}">{{$bilhete->nome}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    <i class="icon fa fa-check-circle"></i>
                                </p>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="response">&nbsp;</div>
                                <p><label for="contactname">Quantidade de Bilhetes @error('email')<span style="color: #c10e0a"> * {{ $message }}</span>@enderror</label>
                                    <?php
                                    $max = 10;
                                    if ($bilhetes[0]->quantidadeMax != null)
                                        $max = $bilhetes[0]->quantidadeMax;
                                    ?>
                                    <select id="id_quantidade" name="quantidade" type="text" class="textflied">                                      
                                        @for($qtd=1;$qtd<=$max;$qtd++) 
                                        <option value="{{$qtd}}">{{$qtd}}</option>
                                        @endfor
                                    </select>
                                    <i class="icon fa fa-child"></i>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <div class="response">&nbsp;</div>

                                <p><label for="contactname">Valor a pagar</label>
                                    @foreach($bilhetes as $bilhete)
                                    @if($bilhete->tipo!='CONVITE')
                                    <input id="id_valor_pagar_show" type="text" value="{{$bilhete->preco}},00Mt" disabled="" class="textflied">
                                    <input type="hidden" id="id_valor_pagar" name="valor_pagar" value="{{$bilhete->preco}}">
                                    @break
                                    @endif
                                    @endforeach
                                    <!-- <input id="id_valor_pagar_show" type="text" value="{{$bilhetes[0]->preco}},00Mt" disabled="" class="textflied">
                                    <input type="hidden" id="id_valor_pagar" name="valor_pagar" value="{{$bilhetes[0]->preco}}"> -->
                                    <i class="icon fa fa-money"></i>
                                </p>
                            </div>
                        </div>
                        <br>
                        <div class="row">

                            <p><label for="contactname">Seleccione o metodo de Pagamento @error('email')<span style="color: #c10e0a"> * {{ $message }}</span>@enderror</label>
                            <div class="col-md-4">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="pagamento" id="optionsRadios1" value="MPESA" checked>
                                        Pagar com<br><img src="{{asset('public/img/download.png')}}" style="width: 110px">
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="pagamento" id="optionsRadios1" value="PAYPALL">
                                        Pagar com<br><img src="{{asset('public/img/download2.png')}}" style="width: 150px">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-input ">
                                <button class="btn btn-primary">Continuar <i class="fa fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-6 col-sm-6">
                <!-- Map -->
                <div class="map-container">
                    <h2 class="title"> {{$evento->nome}}</h2>
                    <!-- <h2 class="title"> Preço {{$evento->preco}},00Mt ({{$evento->tipo}})</h2> -->
                    <p><i class="icon fa fa-calendar"></i> Data: {{ date_format(date_create($evento->dataInicio) ,"d-m-Y") }} as {{$evento->horaInicio}} @if($evento->dataFim!=null || $evento->dataFim!='') ate {{ date_format(date_create($evento->dataFim) ,"d-m-Y") }} @endif @if($evento->horaFim!=null || $evento->horaFim!='')pelas {{$evento->horaFim}} @endif</p>
                    <p><i class="icon fa fa-map-marker"></i> Local: {{$evento->local}}</p>
                    <p><b>Tipos de Bilhetes</b>
                    <hr>
                    @foreach($bilhetes as $bilhete)
                    @if($bilhete->tipo!='CONVITE')
                    {{$bilhete->nome}} (Preço: {{$bilhete->preco}},00Mt) Quantidade Disponível: {{$bilhete->quantidade}}
                    <hr>
                    @endif
                    @endforeach
                    </p>
                    <div><img src="{{$eventImagePath.'/'.$evento->foto}}" style="border-radius: 20%;"></div>
                </div>

               
            </div>
        </div>
    </div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready(function () {

    //calcular preco a pagar
    $('select').on('change', function () {
        $.get('<?php echo url("/requisitar-getBilhete/") ?>/' + $('#id_bilhete').val(), function (data) {
            var total_pagar = (data.preco * $('#id_quantidade').val());
            $('#id_valor_pagar_show').val(total_pagar + ',00Mt');
            $('#id_valor_pagar').val(total_pagar);
            var quant = $('#id_quantidade').val();
            $('#id_quantidade').empty();
            var quantMax = data.quantidadeMax;
            if (quantMax == null || quantMax == '') {
                quantMax = 10;
            }
            for (var i = 1; i <= quantMax; i++) {
                $('#id_quantidade').append('<option value="' + i + '">' + i + '</option>');
            }
            $('#id_quantidade').val(quant).prop('selected', true);
        });

    });

});
</script>

@endsection
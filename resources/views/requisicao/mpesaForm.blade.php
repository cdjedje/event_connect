@extends('layouts.app')

@section('content')

<!-- Sub Banner -->
<section class="sub-banner newsection">
    <div class="container">
        <h2 class="title">Pagamento Mpesa</h2>
        <!-- <ul class="breadcrumb">
            <li><a href="">Eventos</a></li>
            <li>Todas Categorias</li>
        </ul> -->
    </div>
</section>
<div class="contact newsection">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="row">
                    <div>
                        @csrf
                        <div class="col-md-6 col-sm-6">
                            <input type="hidden" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" id="bilheteInfo" value="{{$dadosPagamento->id_bilhete}}">
                            <p><label for="contactname">Nome do Cliente</label>
                                <input id="contactname" type="text" name="email" value="{{ session('nomeCliente')}}" disabled="" class="textflied">

                                <!-- <i class="icon fa fa-envelope"></i> -->
                            </p>
                            <p><label for="contactname">Quantidade</label>
                                <input id="quantidade" type="text" name="email" value="{{$dadosPagamento->quantidade}}" disabled="" class="textflied">
                                <!-- <i class="icon fa fa-envelope"></i> -->
                            </p>
                            <p><label for="contactname">Valor a Pagar</label>
                                <input id="valorPagar" type="text" name="email" value="{{$dadosPagamento->valor_pagar}}" disabled="" class="textflied">
                                <!-- <i class="icon fa fa-envelope"></i> -->
                            </p>
                            <p><label for="contactname">Digite o seu Número de Mpesa</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" name="email" value="+258" class="textflied" disabled>
                                    </div>
                                    <div class="col-md-8">
                                        <input id="numTelefone" type="text" name="email" class="textflied">
                                    </div>
                                </div>
                                <!-- <i class="icon fa fa-envelope"></i> -->
                            </p>
                            <div class="form-input ">
                                <button type="button" id="btnPay" onclick="pay()" class="btn btn-primary">Pagar <i class="fa fa-arrow-right"></i></button>
                                <div id="loading" style="width: 25px; height: 25px; display: none">
                                    <img src="{{asset('public/img/loading.gif')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function pay() {
        var numeroAux = $('#numTelefone').val();
        var numero = numeroAux.replace(/ /g, "");

        if (numero) {

            if (!isNaN(numero)) {
                $('#loading').show();
                $("#btnPay").attr("disabled", true)

                var valorPagar = $('#valorPagar').val();

                var quantidade = $('#quantidade').val();
                var bilheteId = $('#bilheteInfo').val();
                // console.log(quantidade);
                // console.log(bilheteId);

                $.ajax({
                    url: "{{url('mpesa/payment')}}",
                    type: 'POST',
                    data: {
                        valorPagar: valorPagar,
                        numTelefone: numero,
                        id_bilhete: bilheteId,
                        quantidade: quantidade,
                        _token: $('#token').val()
                    },
                    success: function(data) {
                        // alert("Inseriu Com Sucesso");
                        try {
                            var response = jQuery.parseJSON(data);
                            // console.log(response);
                            if (response.output_ResponseCode == "INS-0") {
                                window.location.href = "mpesa/success/" + valorPagar + "/" + quantidade + "/{{$dadosPagamento->id_bilhete}}/{{$dadosPagamento->id_evento}}";
                            } else {
                                $('#loading').hide();
                                $("#btnPay").attr("disabled", false);
                                alert("Ocorreu uma falha, por favor tente novamente");
                            }
                        } catch (err) {
                            $('#loading').hide();
                            $("#btnPay").attr("disabled", false)
                            alert("Ocorreu uma falha, por favor tente novamente");
                        }

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // console.log(jqXHR);
                        // console.log(textStatus);
                        // console.log(errorThrown);
                        $('#loading').hide();
                        $("#btnPay").attr("disabled", false)
                        alert("Falha no processamento, por favor tente mais tarde")
                    }
                });
            } else {
                alert("Por favor, forneca um número váliddo")
            }
        } else {
            alert("Por favor, forneca o seu Mpesa")
        }
    }
</script>

@endsection
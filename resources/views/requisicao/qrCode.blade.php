@extends('layouts.app')

@section('content')
<!-- Sub Banner -->
<section class="sub-banner newsection">
    <div class="container">
        <h2 class="title">Gerar QR Code do Bilhete/Convite</h2>
        <ul class="breadcrumb">
         
        </ul>
    </div>
</section>
<div class="contact newsection">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <div class="eventsimg">
                            <img src="{{$eventImagePath.'/'.$aquisicao->foto}}" alt="">
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <div class="event-content">
                            <h3 class="title">{{$aquisicao->nome}}</h3>
                            <hr>
                            <p><i class="fa fa-map-marker"></i> Local: {{$aquisicao->local}}</p>
                            <p><i class="fa fa-calendar"></i> Data: {{ date_format(date_create($aquisicao->dataInicio) ,"d-m-Y") }} as {{$aquisicao->horaInicio}}</p>                           
                             <p><i class="fa fa-users"></i> Total de Pessoas: {{$aquisicao->quantidade}}</p>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="col-md-6 col-sm-6">
                <!-- Map -->
                <div class="map-container">
                    <h2 class="title"> QR.Code do Bilhete/Convite</h2>
                    <div>
                        <img src="{{asset('public/qrCode/'.$aquisicao->id_aquisicao.'.png')}}" style="width: 150px"><br>
                        <a href="{{url('public/qrCode/'.$aquisicao->id_aquisicao.'.png')}}" download="" class="btn btn-pri">Baixar</a>
                    </div>
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

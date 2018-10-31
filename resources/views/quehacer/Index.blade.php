<?php
/*
* Vista para listados del portal
*/
$colorTipo = ['bg-primary','bg-success','bg-danger', 'bg-info', 'bg-warning'];

function getItemType($type){
    $path = ""; $name = "";
    switch($type){
        case(1):
            $name = "Actividad";
            $path = "/actividades/ver/";
            break;
        case(2):
            $name = "Atracción";
            $path = "/atracciones/ver/";
            break;
        case(3):
            $name = "Destino";
            $path = "/destinos/ver/";
            break;
        case(4):
            $name = "Evento";
            $path = "/eventos/ver/";
            break; 
        case(5):
            $name = "Ruta turística";
            $path = "/rutas/ver/";
            break;
    }
    return (object)array('name'=>$name, 'path'=>$path);
}
?>
@extends('layout._publicLayout')

@section('Title', '¿Qué hacer?')

@section('TitleSection','Actividades')

@section('meta_og')
<meta property="og:title" content="Qué hacer" />
<meta property="og:image" content="{{asset('/res/img/brand/128.png')}}" />
<meta property="og:description" content="¿Qué hacer?"/>
@endsection

@section ('estilos')
    <link href="{{asset('/css/public/pages.css')}}" rel="stylesheet">
    <link href="//cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css" rel="stylesheet">
    <style>
        #opciones{
            text-align:right;
            background-color: white;
            padding: 4px .5rem;
            margin-top: 1rem;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            position:relative;
            z-index: 2;
            box-shadow: 0px -1px 5px -2px rgba(0,0,0,.3);
        }
        #opciones>button, #opciones form{
            display:inline-block;
            border: 0;
            margin: 0 2px;
        }
        #opciones button {
            box-shadow: 0px 1px 3px 0px rgba(0,0,0,.3);
            background-color: white;
        }
        #opciones button:hover{
            box-shadow: 0px 4px 12px 0px rgba(0,0,0,.2);
        }
        .input-group .form-control{
            font-size: 1rem;
            height: auto;
        }
        .input-group .input-group-addon {
            padding: 0;
        }
        .input-group .input-group-addon .btn{
            border-radius: 2px;
            border: 0;
        }
        .mdi::before {
            font-size: 1rem;
        }
        #collapseFilter{
            position: fixed;
            left: 0px;
            top: 0px;
            height: 100%;
            min-width: 250px;
            max-width: 280px;
            overflow: auto;
            background-color: rgba(255, 255, 255, 0.95);
            z-index: 100;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            padding: 1rem;
        }
        .input-group>.input-group-prepend:not(:first-child)>.input-group-text .btn {
            border-radius: 0;
            border: 0;
        }
        
        .input-group>.input-group-prepend:not(:first-child)>.input-group-text {
            padding: 0;
        }
        .header-list{
            background-color: rgba(221,221,221,.3);
            min-height: 250px;
            display: flex;
            align-items: flex-end;
            vertical-align: bottom;
            position: relative;
            
        }
        .header-list:before{
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url(/img/bg_header.png);
            opacity: 0.1;
            z-index: 0;
        }
        .header-list .title-section{
            text-transform: uppercase;
            position: relative;
            z-index: 2;
            color: green;
            text-shadow: 0px 1px 3px rgba(0,0,0,.4);
            text-align: center;
        }
        .card-header {
            padding: 2px .5rem;
        }
        .card-header .btn {
            padding: 0;
            color: #333;
            white-space: wrap;
        }
        .tile.tile-overlap .tile-img {
            background-image: url(/img/no-image.jpg);
            background-size: 100% auto;
            background-repeat: no-repeat;
            background-position: center center;
        }
        .label {
            display: inline-block;
            padding: .2rem .5rem;
            font-size: .875rem;
            font-weight: 500;
            border-radius: 2px;
            margin-bottom: 2px;
        }
        .tile-date {
            display:inline-block;
            background-color: #ddd;
            color: #333;
        }
        .tile.tile-overlap .tile-img img {
            font-size: 0.875rem;
            text-align: center;
            color: dimgrey;
        }
    </style>
@endsection

@section('content')
    <div class="header-list">
        <div class="container">
            <h2 class="title-section">Qué hacer</h2>
            <div id="opciones">
                <button type="button" class="btn btn-default d-none d-sm-inline-block" onclick="changeViewList(this,'listado','tile-list')" title="Vista de lista"><span class="mdi mdi-view-sequential" aria-hidden="true"></span><span class="sr-only">Vista de lista</span></button>
                <button type="button" class="btn btn-default d-none d-sm-inline-block" onclick="changeViewList(this,'listado','')" title="Vista de mosaico"><span class="mdi mdi-view-grid" aria-hidden="true"></span><span class="sr-only">Vista de mosaico</span></button>
                <form class="form-inline">
                    
                    <div class="col-auto">
                      <label class="sr-only" for="searchMain">Buscador general</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="searchMain" placeholder="¿Qué desea buscar?" maxlength="255">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                              <button type="submit" class="btn btn-default" title="Buscar"><span class="mdi mdi-magnify" aria-hidden="true"></span><span class="sr-only">Buscar</span></button>
                          </div>
                        </div>
                      </div>
                    </div>
                </form>
                <button type="button" class="btn btn-default"><span class="mdi mdi-filter" aria-hidden="true" title="Filtrar resultados" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter"></span><span class="sr-only">Filtrar resultados</span></button>
            </div>
        </div>
        
    </div>
    
    <div class="container">
        <br/>
        <div id="listado" class="tiles">
            @foreach ($query as $lugar)
            <div class="tile tile-overlap">
                <div class="tile-img">
                    @if($lugar->portada != "")
                    <img src="{{ $lugar->portada }}" alt="Imagen de presentación de {{ $lugar->nombre }}"/>
                    @endif
                </div>
                <div class="tile-body">
                    <div class="tile-caption">
                        <h3><a href="{{getItemType($lugar->tipo)->path}}{{ $lugar->id }}">{{ $lugar->nombre }}</a></h3>
                        <span class="label {{$colorTipo[$lugar->tipo - 1]}}">{{getItemType($lugar->tipo)->name}}</span>
                        @if($lugar->tipo == 4)
                        <p class="label tile-date">Del {{date('d/m/Y', strtotime($lugar->fecha_inicio))}} al {{date('d/m/Y', strtotime($lugar->fecha_fin))}}</p>
                        @endif
                    </div>
                    <!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>-->
                    <div class="tile-buttons">
                        <div class="inline-buttons">
                            <button type="button" title="{{$lugar->calificacion_legusto}}"><span class="{{ ($lugar->calificacion_legusto > 0.0) ? (($lugar->calificacion_legusto <= 0.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span><span class="sr-only">1</span></button>
                            <button type="button" title="{{$lugar->calificacion_legusto}}"><span class="{{ ($lugar->calificacion_legusto > 1.0) ? (($lugar->calificacion_legusto <= 1.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span><span class="sr-only">2</span></button>
                            <button type="button" title="{{$lugar->calificacion_legusto}}"><span class="{{ ($lugar->calificacion_legusto > 2.0) ? (($lugar->calificacion_legusto <= 2.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span><span class="sr-only">3</span></button>
                            <button type="button" title="{{$lugar->calificacion_legusto}}"><span class="{{ ($lugar->calificacion_legusto > 3.0) ? (($lugar->calificacion_legusto <= 3.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span><span class="sr-only">4</span></button>
                            <button type="button" title="{{$lugar->calificacion_legusto}}"><span class="{{ ($lugar->calificacion_legusto > 4.0) ? (($lugar->calificacion_legusto <= 4.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span><span class="sr-only">5</span></button>
                            
                        </div>
                        
                        
                    </div>
                </div>
            </div>
            @endforeach
            <!--<div class="tile tile-overlap">
                <div class="tile-img">
                    <img src="http://www.valledupar.com/sistema-noticias/data/upimages/valledupar_poporos2.jpg" alt=""/>
                </div>
                <div class="tile-body">
                    <div class="tile-caption">
                        <h3><a href="#">Parque de la Leyenda Vallenata “Consuelo Araujo Noguera”</a></h3>    
                    </div>
                    <div class="tile-buttons">
                        <div class="inline-buttons">
                            <button type="button"><span class="mdi mdi-star-outline" aria-hidden="true"></span><span class="sr-only">1</span></button>
                            <button type="button"><span class="mdi mdi-star-outline" aria-hidden="true"></span><span class="sr-only">2</span></button>
                            <button type="button"><span class="mdi mdi-star-outline" aria-hidden="true"></span><span class="sr-only">3</span></button>
                            <button type="button"><span class="mdi mdi-star-outline" aria-hidden="true"></span><span class="sr-only">4</span></button>
                            <button type="button"><span class="mdi mdi-star-outline" aria-hidden="true"></span><span class="sr-only">5</span></button>
                        </div>
                        <button type="button" title="Añadir a favorito"><span class="mdi mdi-heart-outline" aria-hidden="true"></span><span class="sr-only">Añadir a favorito</span></button>
                        
                    </div>
                </div>
            </div> -->
            
        </div>
    </div>

@endsection

@section('javascript')
<script src="{{asset('/js/public/vibrant.js')}}"></script>
<script src="{{asset('/js/public/setProminentColorImg.js')}}"></script>
<script>
       function changeViewList(obj, idList, view){
            var element, name, arr;
            element = document.getElementById(idList);
            name = view;
            element.className = "tiles " + name;
        } 
    
</script>
@endsection

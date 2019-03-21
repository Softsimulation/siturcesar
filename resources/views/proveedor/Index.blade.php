<?php
use Illuminate\Support\Facades\Input;
header("Access-Control-Allow-Origin: *");

function parse_yturl($url) 
{
    $pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
    preg_match($pattern, $url, $matches);
    return (isset($matches[1])) ? $matches[1] : false;
}

function getItemType($type){
    $path = ""; $name = "";
    switch($type){
        case(1):
            $name = "Alojamientos";
            $path = "/proveedor/ver/";
            break;
        case(2):
            $name = "Establecimientos de gastronomía";
            $path = "/proveedor/ver/";
            break;
        case(3):
            $name = "Agencias de viaje";
            $path = "/proveedor/ver/";
            break;
        case(4):
            $name = "Establecimientos de esparcimiento";
            $path = "/proveedor/ver/";
            break; 
        case(5):
            $name = "Transporte especializado";
            $path = "/proveedor/ver/";
            break;
    }
    return (object)array('name'=>$name, 'path'=>$path);
}

$tituloPagina = "Prestadores de servicios turísticos";

$colorTipo = ['primary','success','danger', 'info', 'warning'];


?>
@extends('layout._publicLayout')

@section('Title', 'Prestadores de servicios turísticos')



@section('TitleSection','Prestadores de servicios turísticos')

@section('meta_og')
<meta property="og:title" content="{{$tituloPagina}}" />
<meta property="og:image" content="{{asset('/res/img/brand/128.png')}}" />
<meta property="og:description" content="Conoce los prestadores de servicios turísticos del departamento del Cesar"/>
@endsection

@section ('estilos')
    <link href="{{asset('/css/public/pages.css')}}" rel="stylesheet">
    <!--<link href="{{asset('/css/public/details.css')}}" rel="stylesheet">-->
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
            <h2 class="title-section">{{$tituloPagina}}</h2>
            <div id="opciones">
                <button type="button" class="btn btn-default d-none d-sm-inline-block" onclick="changeViewList(this,'listado','tile-list')" title="Vista de lista"><span class="mdi mdi-view-sequential" aria-hidden="true"></span><span class="sr-only">Vista de lista</span></button>
                <button type="button" class="btn btn-default d-none d-sm-inline-block" onclick="changeViewList(this,'listado','')" title="Vista de mosaico"><span class="mdi mdi-view-grid" aria-hidden="true"></span><span class="sr-only">Vista de mosaico</span></button>
                <form class="form-inline" method="GET" action="/proveedor/index">
                    @if (isset($_GET['tipo']))
                        <input type="hidden" name="tipo" value="{{ $_GET['tipo'] }}" />
                    @endif
                    @if (isset($_GET['destino']))
                        <input type="hidden" name="destino" value="{{ $_GET['destino'] }}" />
                    @endif
                    <div class="col-auto">
                      <label class="sr-only" for="searchMain">Buscador general</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="searchMain" name="buscar" placeholder="¿Qué desea buscar?" maxlength="255" @if(isset($_GET['buscar']) && $_GET['buscar'] != "") value="{{$_GET['buscar']}}" @endif>
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                              <button type="submit" class="btn btn-default" title="Buscar"><span class="mdi mdi-magnify" aria-hidden="true"></span><span class="sr-only">Buscar</span></button>
                          </div>
                        </div>
                      </div>
                    </div>
                </form>
                @if(isset($_GET['buscar']) || isset($_GET['tipo']))
                <a role="button" class="btn btn-default d-sm-inline-block" href="/proveedor">Limpiar filtros</a>
                @endif
                <!--<button type="button" class="btn btn-default"><span class="mdi mdi-filter" aria-hidden="true" title="Filtrar resultados" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter"></span><span class="sr-only">Filtrar resultados</span></button>-->
            </div>
        </div>
        
    </div>

<div class="container">
    
   
    <br/>
    
    @if(count($proveedores) > 0)
    <div id="listado" class="tiles">
    @for($i = 0; $i < count($proveedores); $i++)
    
        <div class="tile">
            
            <div class="tile-img img-error">
                @if(isset($proveedores[$i]->multimediaProveedores) && count($proveedores[$i]->multimediaProveedores))
                <img src="{{$proveedores[$i]->multimediaProveedores[0]->ruta}}" alt="Imagen de presentación de {{$proveedores[$i]->proveedorRnt->razon_social}}"/>
                @else
                <img src="/img/proveedor_default.png" alt="" role="presentation" class="h-100 p-3">
                @endif
                @if(isset($proveedores[$i]->proveedorRnt->categoria))
                <div class="text-overlap">
                    
                    <a href="/proveedor/index?tipo={{$proveedores[$i]->proveedorRnt->categoria->id}}"><span class="btn btn-sm btn-info">{{$proveedores[$i]->proveedorRnt->categoria->categoriaProveedoresConIdiomas[0]->nombre}}</span></a>
                    {{-- <!--<span class="label bg-{{$colorTipo[$proveedores[$i]->proveedorRnt->categoria->id]}}">{{getItemType($proveedores[$i]->proveedorRnt->categoria->id)->name}}</span>--> --}}
                </div>
                @endif
            </div>
            
            <div class="tile-body">
                <div class="tile-caption">
                    
                    <h3><a href="{{getItemType(1)->path}}{{$proveedores[$i]->id}}">{{$proveedores[$i]->proveedorRnt->razon_social}}</a></h3>
                </div>
                
                @if($proveedores[$i]->tipo == 4)
                <p class="tile-date">{{trans('resources.listado.fechaEvento', ['fechaInicio' => date('d/m/Y', strtotime($proveedores[$i]->fecha_inicio)), 'fechaFin' => date('d/m/Y', strtotime($proveedores[$i]->fecha_fin))])}}</p>
                @endif
                <div class="btn-block ranking">
    	              <span class="{{ ($proveedores[$i]->calificacion_legusto > 0.0) ? (($proveedores[$i]->calificacion_legusto <= 0.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    	              <span class="{{ ($proveedores[$i]->calificacion_legusto > 1.0) ? (($proveedores[$i]->calificacion_legusto <= 1.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    	              <span class="{{ ($proveedores[$i]->calificacion_legusto > 2.0) ? (($proveedores[$i]->calificacion_legusto <= 2.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    	              <span class="{{ ($proveedores[$i]->calificacion_legusto > 3.0) ? (($proveedores[$i]->calificacion_legusto <= 3.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    	              <span class="{{ ($proveedores[$i]->calificacion_legusto > 4.0) ? (($proveedores[$i]->calificacion_legusto <= 5.0) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    	              <span class="sr-only">Posee una calificación de {{$proveedores[$i]->calificacion_legusto}}</span>
    	            
    	          </div>
    	          
            </div>
        </div>
    @endfor
    </div>
    @else
    <div class="alert alert-info">
        <p>{{trans('resources.listado.noHayElementos')}}</p>
    </div>
    @endif
    {!!$proveedores->appends(Input::except('page'))->links()!!}
</div>
    
@endsection
@section('javascript')
<script>
    $(document).ready(function(){
       $('.nav-bar > .brand a img').attr('src','/res/logo/white/72.png');
    });
</script>
<script>
    function changeViewList(obj, idList, view){
        var element, name, arr;
        element = document.getElementById(idList);
        name = view;
        element.className = "tiles " + name;
    }
</script>
@endsection
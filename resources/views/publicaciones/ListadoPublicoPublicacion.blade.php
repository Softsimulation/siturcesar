<?php
    use Illuminate\Support\Facades\Input;
?>
@extends('layout._publicLayout')
@section('title', 'Publicaciones')

@section('estilos')
<style>

    #opciones{
        text-align:right;
        background-color: white;
        padding: 4px .5rem;
        margin-top: 1rem;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
        display: flex;
        justify-content: center;
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
    .header-list:before{
        background-image: url(/img/bg_banner_noticias.png);
        background-size: auto 150%;
    }
    
</style>
@endsection

@section('content')
<div class="header-list">
        <div class="container">
            <h2 class="title-section">Biblioteca digital</h2>
            <div id="opciones">
                <form method="GET" action="/promocionPublicacion/listado" class="w-100">
                <div class="row">
                    
                    <div class="col-12 col-md-6 col-lg-5">
                        
                        
                            <div class="form-group mb-1 mb-lg-0">
                                <label for="tipoPublicacion" class="control-label sr-only">Tipo de publicación</label>
                                <select class="form-control" id="tipoPublicacion" name="tipoPublicacion" onchange="this.form.submit()">
                                    <option value="" selected @if((isset($_GET['tipoPublicacion']) && $_GET['tipoPublicacion'] == "") || !isset($_GET['tipoPublicacion'])) disabled @endif>@if(isset($_GET['tipoPublicacion']) && $_GET['tipoPublicacion'] != "") Ver todos los registros @else - Seleccione el tipo de publicación -  @endif</option>
                                    @foreach($tipos as $tipo)
                                        <option value="{{$tipo->id}}" @if(isset($_GET['tipoPublicacion']) && $_GET['tipoPublicacion'] == $tipo->id) selected @endif>{{$tipo->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                        
                    </div>
                    <div class="col-12 col-md-6 col-lg-5">
                        <div class="form-group mb-1 mb-lg-0">
                                <label class="sr-only">Búsqueda</label>
                                <input type="text" name="buscar" class="form-control input-lg" id="buscar" placeholder="¿Qué desea buscar?" @if(isset($_GET['buscar'])) value="{{$_GET['buscar']}}" @endif>
                                <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                            
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12 col-lg-2">
            			<button type="submit" class="btn btn-success w-100"><span class="ion-search"></span> Buscar</button>
            		</div>
                </div>
            </form>
            </div>
        </div>
        
    </div>

<!--<div class="content-head">-->
<!--    <div class="container">-->
<!--        <h2 class="text-uppercase">Publicaciones</h2>-->
<!--        <hr/>-->
<!--        <form method="GET" action="/promocionPublicacion/listado">-->
<!--            <div class="row">-->
                
                
<!--                <div class="col-xs-12 col-md-6 col-lg-6">-->
<!--                    <div class="form-group has-feedback">-->
<!--                            <label class="sr-only" for="buscar">Búsqueda</label>-->
<!--                            <input type="text" name="buscar" class="form-control" id="buscar" placeholder="¿Qué desea buscar?" @if(isset($_GET['buscar'])) value="{{$_GET['buscar']}}" @endif maxlength="255" autocomplete="off">-->
<!--                            <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>-->
                        
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-xs-12 col-md-3 col-lg-4">-->
                    
                    
<!--                        <div class="form-group">-->
<!--                            <label for="tipoPublicacion" class="control-label sr-only">Tipo de publicación</label>-->
<!--                            <select class="form-control" id="tipoPublicacion" name="tipoPublicacion" onchange="this.form.submit()">-->
<!--                                <option value="" selected @if((isset($_GET['tipoPublicacion']) && $_GET['tipoPublicacion'] == "") || !isset($_GET['tipoPublicacion'])) disabled @endif>@if(isset($_GET['tipoPublicacion']) && $_GET['tipoPublicacion'] != "") Ver todos los registros @else - Seleccione el tipo de publicación -  @endif</option>-->
<!--                                @foreach($tipos as $tipo)-->
<!--                                    <option value="{{$tipo->id}}" @if(isset($_GET['tipoPublicacion']) && $_GET['tipoPublicacion'] == $tipo->id) selected @endif>{{$tipo->nombre}}</option>-->
<!--                                @endforeach-->
<!--                            </select>-->
                           
<!--                        </div>-->
                        
                    
<!--                </div>-->
<!--                <div class="col-xs-12 col-md-3 col-lg-2">-->
<!--        			<button type="submit" class="btn btn-block btn-success" title="Buscar"><span class="glyphicon glyphicon-search"></span> Buscar</button>-->
<!--        		</div>-->
<!--            </div>-->
<!--        </form>-->
<!--    </div>-->
<!--</div>-->

<div class="container mt-3">
    @if(isset($_GET['buscar']) || isset($_GET['tipoPublicacion']))
    <div class="text-center">
        <a href="/promocionPublicacion/listado" class="btn btn-default">Limpiar filtros</a>
    </div>
    @endif
    <br>
    @if ($publicaciones != null || count($publicaciones) > 0)
    <div class="tiles">
        @foreach ($publicaciones as $publicacion)
            <div class="tile @if(strlen($publicacion->titulo) >= 200 || strlen($publicacion->resumen) > 200) two-places @endif">
                <div class="tile-img @if(!$publicacion->portada) no-img @endif">
                    @if($publicacion->portada)
                    <img src="{{$publicacion->portada}}" alt="" role="presentation">
                    @else
                    <img src="/img/news.png" alt="" role="presentation">
                    @endif
                    <div class="text-overlap">
                        <a href="/promocionPublicacion/listado/?tipoNoticia={{$publicacion->tipopublicacion->idiomas[0]->nombre}}"><span class="label label-info">{{$publicacion->tipopublicacion->idiomas[0]->nombre}}</span></a>
                    </div>
                </div>
                <div class="tile-body">
                    <div class="tile-caption">
                        <h3><a href="/promocionPublicacion/ver/{{$publicacion->id}}">{{$publicacion->titulo}}</a></h3>
                    </div>
                
                    
                    <p>{{$publicacion->resumen}}</p>
                    <div class="text-right">
                        <a href="/promocionPublicacion/ver/{{$publicacion->id}}" class="btn btn-xs btn-link">Ver más</a>
                    </div>
                
                    
                </div>
            </div>
        @endforeach
    </div>
    {!!$publicaciones->appends(Input::except('page'))->links()!!}
    @else
    <div class="alert alert-info">
        <p>No hay elementos publicados en este momento.</p>
    </div>
    @endif
    
</div>
    
@endsection
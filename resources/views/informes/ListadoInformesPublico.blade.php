<?php 
    $hasFilter = isset($_GET['tipoInforme']) || isset($_GET['categoriaInforme']);
?>
@extends('layout._publicLayout')
@section('title', 'Informes')

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
        background-image: url(/img/bg_banner_indicadores_black.png);
        background-size: auto 150%;
    }
    .tiles .tile .tile-img{
        height: 240px;
    }
    .tile .tile-img img{
        max-height: 100%;
    }
</style>
@endsection

@section('content')
<div class="header-list">
        <div class="container">
            <h2 class="title-section">Informes</h2>
            <div id="opciones">
                <form method="GET" action="/promocioInforme/listado" class="w-100">
                <div class="row">
                    
                    <div class="col-12 col-md-6 col-lg-5">
                        
                        
                            <div class="form-group mb-1 mb-lg-0">
                                <label for="tipoInforme" class="control-label sr-only">Tipo de informe</label>
                                <select class="form-control" id="tipoInforme" name="tipoInforme">
                                    <option value=""  selected disabled>Seleccione un tipo de informe</option>
                                    @foreach($tipos as $tipo)
                                        <option value="{{$tipo->id}}" @if(isset($_GET['tipoInforme']) && $_GET['tipoInforme'] == $tipo->id) selected @endif>{{$tipo->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                        
                    </div>
                    <div class="col-12 col-md-6 col-lg-5">
                        
                        
                            <div class="form-group mb-1 mb-lg-0">
                                <label for="categoriaInforme" class="control-label sr-only">Categoría de informe</label>
                                <select class="form-control" id="categoriaInforme" name="categoriaInforme">
                                    <option value=""  selected disabled>Seleccione una categoría de informe</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{$categoria->id}}" @if(isset($_GET['categoriaInforme']) && $_GET['categoriaInforme'] == $categoria->id) selected @endif>{{$categoria->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                        
                    </div>
                    <!--<div class="col-12 col-md-12 col-lg-4">-->
                    <!--    <div class="form-group mb-1 mb-lg-0">-->
                    <!--            <label class="sr-only">Búsqueda</label>-->
                    <!--            <input type="text" name="buscar" class="form-control input-lg" id="buscar" placeholder="¿Qué desea buscar?" @if(isset($_GET['buscar'])) value="{{$_GET['buscar']}}" @endif>-->
                    <!--            <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>-->
                            
                    <!--    </div>-->
                    <!--</div>-->
                    <div class="col-xs-12 col-md-12 col-lg-2">
            			<button type="submit" class="btn btn-success w-100"><span class="ion-search"></span> Buscar</button>
            		</div>
                </div>
            </form>
            </div>
        </div>
        
    </div>

   
   <!-- <div class="row">-->
        
   <!--     <form method="GET" action="/promocionInforme/listado">-->
   <!--         <div class="col-md-3">-->
   <!--             <div class="form-group">-->
   <!--                 <label for="tipoInforme" class="control-label">Tipo de informe</label>-->
   <!--                 <select class="form-control" id="tipoInforme" name="tipoInforme">-->
   <!--                     <option value="" selected disable>Seleccione tipo de informe</option>-->
   <!--                     @foreach($tipos as $tipo)-->
   <!--                         <option value="{{$tipo->tipo_documento_id}}">{{$tipo->nombre}}</option>-->
   <!--                     @endforeach-->
   <!--                 </select>-->
   <!--             </div>-->
   <!--         </div>-->
   <!--         <div class="col-md-3">-->
   <!--             <div class="form-group">-->
   <!--                 <label for="categoriaInforme" class="control-label">Tipo de informe</label>-->
   <!--                 <select class="form-control" id="categoriaInforme" name="categoriaInforme">-->
   <!--                     <option value="" selected disable>Seleccione categoría de informe</option>-->
   <!--                     @foreach($categorias as $categoria)-->
   <!--                         <option value="{{$categoria->categoria_documento_id}}">{{$categoria->nombre}}</option>-->
   <!--                     @endforeach-->
   <!--                 </select>-->
   <!--             </div>-->
   <!--         </div> -->
   <!--         <div class="col-xs-12 col-md-2">-->
			<!--	<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>-->
			<!--</div>-->
   <!--     </form>-->
        
   <!-- </div>-->
   <div class="container pt-3">
       @if($hasFilter)
        <div class="text-center mb-3">
            <a role="button" href="/promocionNoticia/listado" class="btn btn-outline-secondary">Remover filtros</a>
        </div>
        @endif
        @if ($informes != null || count($informes) > 0)
        <div class="tiles inline-tile">
        @foreach ($informes as $informe)
        <div class="tile">
            <div class="tile-img">
                <img src="{{$informe->portada}}">
            </div>
            <div class="tile-body">
                <div class="tile-caption">
                    <h3><a href="{{$informe->ruta}}">{{$informe->tituloInforme}}</a></h3>
                    <p class="text-muted"><i class="ion-person"></i> {{$informe->autores}} - <i class="ion-calendar"></i> {{$informe->fecha_publicacion}}</p>
                    <div class="text-right mt-2">
                        <a target="_blank" href="{{$informe->ruta}}" class="btn btn-sm btn-outline-success">Ver PDF</a>
                    </div>
                </div>
            </div>
        </div>
            <!--Tipo de informe : {{$informe->tipoInforme}}-->
            <!--<br>-->
            <!--Categoría de informe : {{$informe->categoriaInforme}}-->
            <!--<br>-->
            <!--Autores : {{$informe->autores}}-->
            <!--<br>-->
            <!--Título : {{$informe->tituloInforme}}-->
            <!--<br>-->
            <!--Descripción : {{$informe->descripcion}}-->
            <!--<br>-->
            <!--Fecha de creación : {{$informe->fecha_creacion}}-->
            <!--<br>-->
            <!--Fecha de publicación : {{$informe->fecha_publicacion}}-->
            <!--<br>-->
            <!--Portada : {{$informe->portada}}-->
            
            <!--<a href="ver/{{$informe->id}}">Ver más de informe</a>-->
        @endforeach
        </div>
    @else
    <div class="alert alert-info mb-3" role="alert">
        No hay registro para mostrar en este momento
    </div>
    @endif
    {!!$informes->links()!!}
   </div>
   
    
@endsection
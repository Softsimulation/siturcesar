@extends('layout._publicLayout')
@section('title', 'Noticias')

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
        background-size: auto 200%;
    }
</style>
@endsection

@section('content')
<div class="header-list">
        <div class="container">
            <h2 class="title-section">Noticias</h2>
            <div id="opciones">
                <form method="GET" action="/promocionNoticia/listado" class="w-100">
                <div class="row">
                    
                    <div class="col-12 col-md-6 col-lg-5">
                        
                        
                            <div class="form-group mb-1 mb-lg-0">
                                <label for="tipoNoticia" class="control-label sr-only">Tipo de noticia</label>
                                <select class="form-control" id="tipoNoticia" name="tipoNoticia">
                                    <option value="" selected disable>Seleccione tipo de noticia</option>
                                    @foreach($tiposNoticias as $tipo)
                                        <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                        
                    </div>
                    <div class="col-12 col-md-6 col-lg-5">
                        <div class="form-group mb-1 mb-lg-0">
                                <label class="sr-only">Búsqueda</label>
                                <input type="text" name="buscar" class="form-control input-lg" id="buscar" placeholder="¿Qué desea buscar?">
                                <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                            
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12 col-lg-2">
            			<button type="submit" class="btn btn-primary w-100"><span class="ion-search"></span> Buscar</button>
            		</div>
                </div>
            </form>
            </div>
        </div>
        
    </div>

<div class="container">
    
    @if ($noticias != null && count($noticias) > 0)
    {{$noticias}}
    <div class="tiles mt-3">
		@foreach($noticias as $noticia)
		<section class="tile inline-tile">
            <div class="tile-img">
            
            </div>
            <div class="tile-body">
                <div class="tile-caption">
                        
                    <a href="/promocionNoticia/ver/{{$noticia->idNoticia}}">
                        <h3>{{$noticia->tituloNoticia}}</h3>
                    </a>
                    <p class="date"><span class="ion-calendar" aria-hidden="true"></span> Publicado el {{date('d/m/Y h:m A', strtotime($noticia->fecha))}}</p>
                    <p class="text-muted">{{$noticia->resumen}}</p>
                </div>
                <div class="buttons">
                    <a class="btn btn-xs btn-link" href="/promocionNoticia/ver/{{$noticia->idNoticia}}">Ver más</a>
                </div>
                
            </div>
        </section>
        @endforeach
    </div>
        <!--@foreach ($noticias as $noticia)-->
        <!--    <br>-->
        <!--    Tipo noticia : {{$noticia->nombreTipoNoticia}}-->
        <!--    <br>-->
        <!--    Título noticia : {{$noticia->tituloNoticia}}-->
        <!--    <br>-->
        <!--    <a href="ver/{{$noticia->idNoticia}}">Ver</a>-->
        <!--    <br>-->
        <!--    <br>-->
        <!--    <br>-->
        <!--    <br>-->
        <!--@endforeach-->
    @else
    <div class="alert alert-info" role="alert">
        No hay registro para mostrar en este momento
    </div>
    @endif
    {!!$noticias->links()!!}
</div>
    
@endsection
@extends('layout._publicLayout')
@section('title', '')

@section('meta_og')
<meta property="og:title" content="{{$noticia->nombreTipoNoticia}}. Miralo en SITUR Cesar" />
<meta property="og:image" content="@if($portada->ruta){{$portada->ruta}}@else{{asset('/img/brand/96.png')}}@endif" />
<meta property="og:description" content="@if($portada->ruta){{$portada->ruta}}@else{{asset('/img/brand/96.png')}}@endif" />
@endsection

@section('estilos')
<style>
    header{
        position:relative;
    }
    main h1, main h2, main h3, main h4, main h5, main h6 {
        color: #004a87;
    }
    .btn.btn-circle {
        font-size: 1.5rem;
        line-height: 1.35;
        padding: .5rem;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        text-align: center;
    }
    #shareButtons{
        margin-top: .5rem;
        
    }
</style>
@endsection


@section('content')
<div class="container pt-3">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-white justify-content-center">
        <li class="breadcrumb-item"><a href="/promocionNoticia/listado">Noticias</a></li>
        <li class="breadcrumb-item active text-truncate" aria-current="page">{{$noticia->nombreTipoNoticia}}</li>
      </ol>
    </nav>
    <h2 class="text-center">{{$noticia->tituloNoticia}} <small class="d-block text-muted">{{$noticia->nombreTipoNoticia}}</small></h2>
    <hr>
    <blockquote class="blockquote">
    <p class="m-0" style="white-space:pre-line;">{{$noticia->resumenNoticia}}</p>
    </blockquote>
    @if ($multimedias != null || count($multimedias) > 0)
    <div id="carouselExampleIndicators" class="carousel slide mb-3" data-ride="carousel">
      <ol class="carousel-indicators">
        @for ($i = 0; $i < count($multimedias); $i++)
        <li data-target="#carouselExampleIndicators" data-slide-to="{{$i}}" @if($multimedias[$i]->portada) class="active" @endif></li>
        @endfor
      </ol>
      <div class="carousel-inner">
        @for ($i = 0; $i < count($multimedias); $i++)
        <div class="carousel-item @if($multimedias[$i]->portada) active @endif">
          <img class="d-block w-100" src="{{$multimedias[$i]->ruta}}" alt="{{$multimedias[$i]->texto}}">
        </div>
        @endfor
      </div>
      
    </div>
    @endif
    <div>
        {!!$noticia->texto!!}
    </div>
    {{$noticia->enlaceFuente}}
    @if($noticia->enlaceFuente)
    <div class="text-right">
        <a href="{{$noticia->enlaceFuente}}">Clic aquí para ver la fuente</a>
    </div>
    @endif
    <div id="shareButtons" class="text-center">
        <p>Comparte esta publicación</p>
        <a href="https://www.facebook.com/sharer/sharer.php?u={{\Request::url()}}" role="button" class="btn btn-circle btn-outline-primary" title="Compartir en Facebook" target="_blank" rel="noopener noreferrer">
            <span class="ion-social-facebook" aria-hidden="true"></span>
            <span class="sr-only">Compartir en Facebook</span>
        </a>
        <a href="https://twitter.com/home?status= {{$noticia->tituloNoticia}} por SITUR Cesar. Lee más en {{\Request::url()}}" role="button" class="btn btn-circle btn-outline-info" title="Compartir en Twitter" target="_blank" rel="noopener noreferrer">
            <span class="ion-social-twitter" aria-hidden="true"></span>
            <span class="sr-only">Compartir en Twitter</span>
        </a>
        <a href="https://plus.google.com/share?url={{\Request::url()}}" role="button" class="btn btn-circle btn-outline-danger" title="Compartir en Google +" target="_blank" rel="noopener noreferrer">
            <span class="ion-social-googleplus" aria-hidden="true"></span>
            <span class="sr-only">Compartir en Google +</span>
        </a>
        <button type="button" class="btn btn-circle btn-outline-secondary" title="Imprimir esta publicación" onclick="window.print();return false;">
            <span class="ion-android-print" aria-hidden="true"></span>
            <span class="sr-only">Imprimir esta publicación</span>
        </button>
    </div>
   
</div>

@endsection

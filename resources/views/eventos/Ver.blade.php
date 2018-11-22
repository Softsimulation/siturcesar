<?php
header("Access-Control-Allow-Origin: *");

function parse_yturl($url) 
{
    $pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
    preg_match($pattern, $url, $matches);
    return (isset($matches[1])) ? $matches[1] : false;
}
?>
@extends('layout._publicLayout')

@section('Title',$evento->eventosConIdiomas[0]->nombre)


@section('meta_og')
<meta property="og:title" content="{{$evento->eventosConIdiomas[0]->nombre}} se realizará en el departamento del Cesar" />
<meta property="og:image" content="{{asset('/img/brand/128.png')}}" />
<meta property="og:description" content="{{$evento->eventosConIdiomas[0]->descripcion}}"/>
@endsection

@section ('estilos')
    <link href="{{asset('/css/public/pages.css')}}" rel="stylesheet">
    <link href="{{asset('/css/public/details.css')}}" rel="stylesheet">
    <link href="//cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css" rel="stylesheet">
    
@endsection

@section('content')
    <div id="carousel-main-page" class="carousel slide carousel-fade" data-ride="carousel">
      <ol class="carousel-indicators">
        @for($i = 0; $i < count($evento->multimediaEventos); $i++)
            <li data-target="#carousel-main-page" data-slide-to="{{$i}}" {{  $i === 0 ? 'class=active' : '' }}></li>
        @endfor
      </ol>
      <div class="carousel-inner">
      
        @for($i = 0; $i < count($evento->multimediaEventos); $i++)
        <div class="carousel-item {{  $i === 0 ? 'active' : '' }}">
          <img class="d-block" src="{{$evento->multimediaEventos[$i]->ruta}}" alt="Imagen de presentación de {{$evento->multimediaEventos[0]->nombre}}">
          
        </div>
        @endfor
        
        <div class="carousel-caption d-none d-md-block align-content-end flex-wrap">
		    <h2 class="text-center container">{{$evento->eventosConIdiomas[0]->nombre}}
		    @if($evento->eventosConIdiomas[0]->edicion)
		        <small>
		            Ed. {{$evento->eventosConIdiomas[0]->edicion}}
		        </small>
	        @endif
	        </h2>
	        <p class="w-100">Del {{date('d/m/Y', strtotime($evento->fecha_in))}} al {{date('d/m/Y', strtotime($evento->fecha_fin))}}</p>
		  </div>
      </div>
      <div class="text-center">
        @if(Auth::check())
            <form role="form" action="/eventos/favorito" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="evento_id" value="{{$evento->id}}" />
                <button type="submit" class="btn btn-lg btn-circled btn-favorite">
                  <span class="ion-android-favorite" aria-hidden="true"></span><span class="sr-only">Marcar como favorito</span>
                </button>    
            </form>
        @else
            <button type="button" class="btn btn-lg btn-circled" title="Marcar como favorito" data-toggle="modal" data-target="#modalIniciarSesion">
              <span class="ion-android-favorite-outline" aria-hidden="true"></span><span class="sr-only">Marcar como favorito</span>
            </button>
        @endif
      </div>
    </div>
    
    <div id="title-main-page">
    	<div class="container">
    		<div class="row align-items-center d-flex justify-content-center">
	    		
	    		<div class="col-12 col-md-12 row align-items-center d-flex justify-content-center">
    			    <div class="col text-center">
    					<a href="#informacionGeneral">
    						<i class="ionicons ion-information-circled" aria-hidden="true"></i>
    						Información general
    					</a>
    				</div>
    				<div class="col text-center">
    					<a href="#caracteristicas">
    						<i class="ionicons ion-android-apps" aria-hidden="true"></i>
    						Características
    					</a>
    				</div>
	    				
	    		</div>
	    	</div>	
    	</div>
    	
    </div>
    
    <section id="informacionGeneral">
        <div class="container">
            <h3>Información general</h3>
            <h4 class="text-center">{{$evento->eventosConIdiomas[0]->nombre}}
                @if($evento->eventosConIdiomas[0]->edicion)
		        <small>
		            (Ed. {{$evento->eventosConIdiomas[0]->edicion}})
		        </small>
	            @endif
            </h4>
            @if(Session::has('message'))
                <div class="alert alert-info" role="alert" style="text-align: center;">{{Session::get('message')}}</div>
            @endif
            @if($video_promocional != null)
            <iframe src="https://www.youtube.com/embed/<?php echo parse_yturl($video_promocional) ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="width: 100%; height: 350px;"></iframe>
            @endif
            <div class="row">
                <div class="col-12 col-md-8">
                    <p style="white-space: pre-line;">{{$evento->eventosConIdiomas[0]->descripcion}}</p>
                </div>
                <div class="col-12 col-md-4">
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item">
                          <div class="media">
                              <span class="ion-calendar mr-3" style="font-size: 2rem;"></span>
                              <div class="media-body">
                                <label class="d-block mb-0"><b>Fecha del evento</b></label>
                                Del {{date('d/m/Y', strtotime($evento->fecha_in))}} al {{date('d/m/Y', strtotime($evento->fecha_fin))}}
                              </div>
                            </div>
                      </li>
                      <li class="list-group-item">
                          <div class="media">
                              <span class="ion-cash mr-3" style="font-size: 2rem;"></span>
                              <div class="media-body">
                                <label class="d-block mb-0"><b>Valor estimado</b></label>
                                Desde ${{number_format($evento->valor_min)}} hasta ${{number_format($evento->valor_max)}}
                              </div>
                            </div>  
                      </li>
                      @if($evento->telefono)
                      <li class="list-group-item">
                          <div class="media">
                              <span class="ion-android-call mr-3" style="font-size: 2rem;"></span>
                              <div class="media-body">
                                <label class="d-block mb-0"><b>Teléfono</b></label>
                                {{$evento->telefono}}
                              </div>
                            </div>  
                      </li>
                      @endif
                      @if($evento->web)
                      <li class="list-group-item">
                          <div class="media">
                              <span class="ion-earth mr-3" style="font-size: 2rem;"></span>
                              <div class="media-body">
                                <label class="d-block mb-0"><b>Página web</b></label>
                                <a href="{{$evento->web}}" target="_blank" rel="nooopener noreferrer">Clic para ir al sitio web</a>
                              </div>
                            </div>  
                      </li>
                      @endif
                    </ul>
                </div>
            </div>
            
        </div>
        
    </section>

    <section id="caracteristicas">
        <div class="container">
            <h3>Sitios</h3>
            <!--<p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam porttitor, augue quis tempus dictum, augue dui molestie sem, vitae molestie augue ipsum id turpis. Fusce feugiat vestibulum ante. Sed a consequat eros, finibus luctus nisl. In ut diam congue, condimentum sem vel, sagittis dolor. Nunc ut vestibulum ex, vitae eleifend metus. Proin id ex eu erat aliquet egestas. Fusce id suscipit velit, ut sodales turpis. Aliquam turpis risus, luctus vitae lobortis finibus, condimentum in felis. Pellentesque vel erat tellus. Suspendisse potenti. Integer porta sed lorem ac iaculis. Pellentesque pretium ex et convallis condimentum. In luctus leo nulla, eu finibus justo volutpat quis.</p>-->
            <div class="row">
                @foreach ($evento->sitiosConEventos as $sitio)
                <div class="col-sm-12 col-md-12 col-xs-12">
                    {{$sitio->sitiosConIdiomas[0]->nombre}}
                </div>
                @endforeach
            </div>
        </div>
    </section>
  
    
@endsection

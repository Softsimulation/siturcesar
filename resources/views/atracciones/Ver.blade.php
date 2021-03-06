<?php
header("Access-Control-Allow-Origin: *");
$paraTenerEnCuentaContieneAlgo = $atraccion->atraccionesConIdiomas[0]->recomendaciones != "" || $atraccion->atraccionesConIdiomas[0]->reglas != "" || $atraccion->atraccionesConIdiomas[0]->como_llegar != "" || count($atraccion->sitio->sitiosConActividades) > 0;
function parse_yturl($url) 
{
    $pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
    preg_match($pattern, $url, $matches);
    return (isset($matches[1])) ? $matches[1] : false;
}
?>

@extends('layout._publicLayout')

@section('Title', $atraccion->sitio->sitiosConIdiomas[0]->nombre)

@section('TitleSection','Atracciones')

@section('meta_og')
<meta property="og:title" content="Realiza {{$atraccion->sitio->sitiosConIdiomas[0]->nombre}} en el departamento del Cesar" />
<meta property="og:image" content="{{asset('/img/brand/128.png')}}" />
<meta property="og:description" content="{{$atraccion->sitio->sitiosConIdiomas[0]->descripcion}}"/>
@endsection

@section ('estilos')
    <link href="{{asset('/css/public/pages.css')}}" rel="stylesheet">
    <link href="{{asset('/css/public/details.css')}}" rel="stylesheet">
    <link href="//cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css" rel="stylesheet">
    <style>
        .btn.btn-lg.btn-circled{
            font-size: 1.825rem;
            line-height: 1.75;
            background: whitesmoke;
            height: 50px;
            width: 50px;
            padding: 0;
            border-radius: 50%;
            margin-bottom: 2rem;
        }
        .btn-favorite{
            color: red;
        }
        .tile h5 a {
            color: #004a87;
            font-size: 1rem;
        }
        .tiles .ranking .ionicons-inline{
            font-size: 1.5rem;
        }
    </style>
@endsection
@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    <div id="carousel-main-page" class="carousel slide carousel-fade" data-ride="carousel">
      <ol class="carousel-indicators">
        @for($i = 0; $i < count($atraccion->sitio->multimediaSitios); $i++)
            <li data-target="#carousel-main-page" data-slide-to="{{$i}}" {{  $i === 0 ? 'class=active' : '' }}></li>
        @endfor
      </ol>
      <div class="carousel-inner">
      
        @for($i = 0; $i < count($atraccion->sitio->multimediaSitios); $i++)
        <div class="carousel-item {{  $i === 0 ? 'active' : '' }}">
          <img class="d-block" src="{{$atraccion->sitio->multimediaSitios[$i]->ruta}}" alt="Imagen de presentación de {{$atraccion->sitio->sitiosConIdiomas[0]->nombre}}">
          
        </div>
        @endfor
        
        <div class="carousel-caption d-flex align-items-start flex-column justify-content-end flex-wrap">
		    <h2 class="text-center container">{{$atraccion->sitio->sitiosConIdiomas[0]->nombre}}
		        <small class="d-block">
		            <span class="{{ ($atraccion->calificacion_legusto > 0.0) ? (($atraccion->calificacion_legusto <= 0.9) ? 'mdi mdi-star-half' : 'mdi mdi-star') : 'mdi mdi-star-outline'}}" aria-hidden="true"></span>
		            <span class="{{ ($atraccion->calificacion_legusto > 1.0) ? (($atraccion->calificacion_legusto <= 1.9) ? 'mdi mdi-star-half' : 'mdi mdi-star') : 'mdi mdi-star-outline'}}" aria-hidden="true"></span>
		            <span class="{{ ($atraccion->calificacion_legusto > 2.0) ? (($atraccion->calificacion_legusto <= 2.9) ? 'mdi mdi-star-half' : 'mdi mdi-star') : 'mdi mdi-star-outline'}}" aria-hidden="true"></span>
		            <span class="{{ ($atraccion->calificacion_legusto > 3.0) ? (($atraccion->calificacion_legusto <= 3.9) ? 'mdi mdi-star-half' : 'mdi mdi-star') : 'mdi mdi-star-outline'}}" aria-hidden="true"></span>
		            <span class="{{ ($atraccion->calificacion_legusto > 4.0) ? (($atraccion->calificacion_legusto <= 5.0) ? 'mdi mdi-star-half' : 'mdi mdi-star') : 'mdi mdi-star-outline'}}" aria-hidden="true"></span>
		            <span class="sr-only">Posee una calificación de {{$atraccion->calificacion_legusto}}</span>
		            
		        </small>
	        </h2>
	        <div class="d-block w-100 text-center">
	            <a role="button" href="#informacionGeneral" class="btn btn-lg btn-circled text-muted" title="Información general">
                  <span class="ion-information-circled" aria-hidden="true"></span><span class="sr-only">Información general</span>
                </a>
                <a role="button" href="#caracteristicas" class="btn btn-lg btn-circled text-muted" title="Características">
                  <span class="ion-android-apps" aria-hidden="true"></span><span class="sr-only">Características</span>
                </a>
                @if($paraTenerEnCuentaContieneAlgo)
                <a role="button" href="#paraTenerEnCuenta" class="btn btn-lg btn-circled text-muted" title="¿Qué debo tener en cuenta?">
                  <span class="ion-help-circled" aria-hidden="true"></span><span class="sr-only">¿Qué debo tener en cuenta?</span>
                </a>
                @endif
                <a role="button" href="#comentarios" class="btn btn-lg btn-circled text-muted" title="Comentarios">
                  <span class="ion-chatbubbles" aria-hidden="true"></span><span class="sr-only">Comentarios</span>
                </a>
                <a role="button" href="#relatedLinks" class="btn btn-lg btn-circled text-muted" title="Comentarios">
                  <span class="ion-flag" aria-hidden="true"></span><span class="sr-only">Información relacionada</span>
                </a>
            @if(Auth::check())
                <form role="form" action="/atracciones/favorito" method="post" class="d-inline-block">
                    {{ csrf_field() }}
                    <input type="hidden" name="atraccion_id" value="{{$atraccion->id}}" />
                    <button type="submit" class="btn btn-lg btn-circled btn-favorite">
                      <span class="ion-android-favorite" aria-hidden="true"></span><span class="sr-only">Marcar como favorito</span>
                    </button>    
                </form>
            @else
                <button type="button" class="btn btn-lg btn-circled btn-favorite" title="Marcar como favorito" data-toggle="modal" data-target="#modalIniciarSesion">
                  <span class="ion-android-favorite-outline" aria-hidden="true"></span><span class="sr-only">Marcar como favorito</span>
                </button>
            @endif
          </div>
		  </div>
      </div>
      
    </div>
    <div id="title-main-page">
    	<div class="container">
    		<div class="row align-items-center justify-content-center">
	    		<div class="col col-md-3 text-center">
					<a href="/quehacer/index?tipo=1">
						<span class="fas fa-hiking d-block" aria-hidden="true" style="font-size: 2rem;"></span>
						¿Qué hacer?
					</a>
				</div>
				<div class="col col-md-3 text-center">
					<a href="/proveedor/index?tipo=1&destino={{$municipio->id}}">
						<span class="fas fa-bed d-block" aria-hidden="true" style="font-size: 2rem;"></span>
						¿Dónde dormir?
					</a>
				</div>
				<div class="col col-md-3 text-center">
					<a href="/proveedor/index?tipo=2&destino={{$municipio->id}}">
						<span class="fas fa-utensils d-block" aria-hidden="true" style="font-size: 2rem;"></span>
						¿Qué comer?
					</a>
				</div>
	    		<div class="col-12 col-md-12 row align-items-center d-flex justify-content-center">
    			 <!--   <div class="col text-center">-->
    				<!--	<a href="#informacionGeneral">-->
    				<!--		<i class="ionicons ion-information-circled" aria-hidden="true"></i>-->
    				<!--		Información general-->
    				<!--	</a>-->
    				<!--</div>-->
    				<!--<div class="col text-center">-->
    				<!--	<a href="#caracteristicas">-->
    				<!--		<i class="ionicons ion-android-apps" aria-hidden="true"></i>-->
    				<!--		Características-->
    				<!--	</a>-->
    				<!--</div>-->
    				<!--@if($paraTenerEnCuentaContieneAlgo)-->
    				<!--<div class="col text-center">-->
    				<!--	<a href="#paraTenerEnCuenta">-->
    				<!--		<i class="ionicons ion-help-circled" aria-hidden="true"></i>-->
    				<!--		¿Qué debo tener en cuenta?-->
    				<!--	</a>-->
    				<!--</div>-->
    				<!--@endif-->
    				<!--<div class="col text-center">-->
    				<!--	<a href="#comentarios">-->
    				<!--		<i class="ionicons ion-chatbubbles" aria-hidden="true"></i>-->
    				<!--		Comentarios-->
    				<!--	</a>-->
    				<!--</div>-->
    				
	    				
	    		</div>
	    	</div>	
    	</div>
    	
    </div>
    <section id="informacionGeneral">
        <div class="container">
            <h3>Información general</h3>
            <h4 class="text-center">{{$atraccion->sitio->sitiosConIdiomas[0]->nombre}}</h4>
            @if(Session::has('message'))
                <div class="alert alert-info" role="alert" style="text-align: center;">{{Session::get('message')}}</div>
            @endif
            
            @if($video_promocional != null)
            <iframe src="https://www.youtube.com/embed/<?php echo parse_yturl($video_promocional) ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="width: 100%; height: 350px;"></iframe>
            @endif
            <div class="mt-3">{!!$atraccion->sitio->sitiosConIdiomas[0]->descripcion!!}</div>
        </div>
        
    </section>
    <section id="caracteristicas">
        <div class="container">
            <h3>Características</h3>
            <!--<p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam porttitor, augue quis tempus dictum, augue dui molestie sem, vitae molestie augue ipsum id turpis. Fusce feugiat vestibulum ante. Sed a consequat eros, finibus luctus nisl. In ut diam congue, condimentum sem vel, sagittis dolor. Nunc ut vestibulum ex, vitae eleifend metus. Proin id ex eu erat aliquet egestas. Fusce id suscipit velit, ut sodales turpis. Aliquam turpis risus, luctus vitae lobortis finibus, condimentum in felis. Pellentesque vel erat tellus. Suspendisse potenti. Integer porta sed lorem ac iaculis. Pellentesque pretium ex et convallis condimentum. In luctus leo nulla, eu finibus justo volutpat quis.</p>-->
            <div class="row">
                <div class="col-xs-12 col-md-8">
                    <div id="map"></div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item active text-uppercase"><strong>Detalles</strong></li>
                        
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-xs-2">
                                    <span class="ion-android-time" aria-hidden="true"></span> <span class="sr-only">Horario</span>
                                </div>
                                <div class="col">
                                    {{$atraccion->atraccionesConIdiomas[0]->horario}}. {{$atraccion->atraccionesConIdiomas[0]->periodo}}
                                </div>
                                
                            </div>
                            @if($atraccion->sitio_web != null)
                            <div class="row">
                                <div class="col-xs-2">
                                    <span class="ion-android-globe" aria-hidden="true"></span> <span class="sr-only">Sitio web</span>
                                </div>
                                <div class="col">
                                    <a href="{{$atraccion->sitio_web}}" target="_blank" rel="noopener noreferrer">Clic para ir al sitio web</a>
                                </div>
                            </div>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    @if($paraTenerEnCuentaContieneAlgo)
    <section id="paraTenerEnCuenta">
        <div class="container">
            <h3>¿Qué debo tener en cuenta?</h3>
            @if($atraccion->atraccionesConIdiomas[0]->recomendaciones != "" || $atraccion->atraccionesConIdiomas[0]->reglas != "" || $atraccion->atraccionesConIdiomas[0]->como_llegar != "")
            <div class="row">
                <div class="col-xs-12 col-md-4">
                    <h4>Recomendaciones</h4>
                    <p style="white-space: pre-line;">{{$atraccion->atraccionesConIdiomas[0]->recomendaciones}}</p>        
                </div>
                <div class="col-xs-12 col-md-4">
                    <h4>Reglas</h4>
                    <p style="white-space: pre-line;">{{$atraccion->atraccionesConIdiomas[0]->reglas}}</p>
                </div>
                <div class="col-xs-12 col-md-4">
                    <h4>Cómo llegar</h4>
                    <p style="white-space: pre-line;">{{$atraccion->atraccionesConIdiomas[0]->como_llegar}}</p>
                </div>
            </div>
            <hr/>
            @endif
            @if(count($atraccion->sitio->sitiosConActividades) > 0)
                <div class="row">
                    <div class="col-12">
                        <h4 class="text-center">Actividades que puedes realizar</h4>
                        <div class="tiles justify-content-center">
                            @foreach ($atraccion->sitio->sitiosConActividades as $actividad)
                               
                                <div class="tile">
                                    <div class="tile-img">
                                        @if(count($actividad->multimediasActividades) > 0)
                                            <img src='{{$actividad->multimediasActividades[0]->ruta}}'alt="" role="presentation" class="bg-img"/>
                                        @endif
                                        
                                    </div>
                                    <div class="tile-body">
                                        <div class="tile-caption">
                                            <h5><a href="/actividades/ver/{{$actividad->id}}">{{$actividad->actividadesConIdiomas[0]->nombre}}</a></h5>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <a href="/actividades" class="btn btn-lg btn-success">Ver más</a>
                    </div>
                </div>
            @endif
            
        </div>
        
    </section>
    @endif
    
  
           
           
           
           
        @if(count($dondeDormir) > 0 || count($dondeComer) > 0)
        <section id="relatedLinks">
            <div class="container">
                <h3>Información relacionada</h3>
                @if(count($dondeDormir) > 0)
                    <h4 class="text-center text-uppercase">Lugares donde dormir</h4>
                    <div id="listado" class="tiles justify-content-center m-0">
                        @foreach($dondeDormir as $hospedaje)
                        <div class="tile border">
                            <div class="tile-img img-error">
                                @if(isset($hospedaje->multimediaProveedores) && count($hospedaje->multimediaProveedores))
                                <img src="{{$hospedaje->multimediaProveedores->first()->ruta}}" alt="Imagen de presentación de {{$hospedaje->proveedorRnt->razon_social}}"/>
                                @else
                                <img src="/img/proveedor_default.png" alt="" role="presentation" class="h-100 p-3">
                                @endif
                                @if(isset($hospedaje->proveedorRnt->categoria))
                                <div class="text-overlap">
                                    
                                    <a href="/proveedor/index?tipo={{$hospedaje->proveedorRnt->categoria->id}}"><span class="btn btn-sm btn-info">{{$hospedaje->proveedorRnt->categoria->categoriaProveedoresConIdiomas->first()->nombre}}</span></a>
                                    {{-- <!--<span class="label bg-{{$colorTipo[$proveedores[$i]->proveedorRnt->categoria->id]}}">{{getItemType($proveedores[$i]->proveedorRnt->categoria->id)->name}}</span>--> --}}
                                </div>
                                @endif
                            </div>
                            <div class="tile-body">
                                <div class="tile-caption">
                                    
                                    <h5><a href="/proveedor/ver/{{$hospedaje->id}}">{{$hospedaje->proveedorRnt->razon_social}}</a></h5>
                                </div>
                                
                                @if($hospedaje->tipo == 4)
                                <p class="tile-date">{{trans('resources.listado.fechaEvento', ['fechaInicio' => date('d/m/Y', strtotime($hospedaje->fecha_inicio)), 'fechaFin' => date('d/m/Y', strtotime($hospedaje->fecha_fin))])}}</p>
                                @endif
                                <div class="btn-block ranking text-center">
                    	              <span class="{{ ($hospedaje->calificacion_legusto > 0.0) ? (($hospedaje->calificacion_legusto <= 0.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
                    	              <span class="{{ ($hospedaje->calificacion_legusto > 1.0) ? (($hospedaje->calificacion_legusto <= 1.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
                    	              <span class="{{ ($hospedaje->calificacion_legusto > 2.0) ? (($hospedaje->calificacion_legusto <= 2.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
                    	              <span class="{{ ($hospedaje->calificacion_legusto > 3.0) ? (($hospedaje->calificacion_legusto <= 3.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
                    	              <span class="{{ ($hospedaje->calificacion_legusto > 4.0) ? (($hospedaje->calificacion_legusto <= 5.0) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
                    	              <span class="sr-only">Posee una calificación de {{$hospedaje->calificacion_legusto}}</span>
                    	            
                    	          </div>
                    	          
                            </div>
                        </div>
                        
                        @endforeach
                        
                    </div>
                    <div class="text-center">
                        <a href="/proveedor/index?tipo=1&destino={{$municipio->id}}" class="btn btn-sm d-block d-md-inline-block btn-outline-success mb-3">Ver más <span class="sr-only">lugares donde dormir</span></a>
                    </div>
                @endif
                @if(count($dondeComer) > 0)
                    <h4 class="text-center text-uppercase">Lugares donde comer</h4>
                    <div id="listado" class="tiles justify-content-center m-0">
                        @foreach($dondeComer as $hospedaje)
                        <div class="tile border">
                            <div class="tile-img img-error">
                                @if(isset($hospedaje->multimediaProveedores) && count($hospedaje->multimediaProveedores))
                                <img src="{{$hospedaje->multimediaProveedores->first()->ruta}}" alt="Imagen de presentación de {{$hospedaje->proveedorRnt->razon_social}}"/>
                                @else
                                <img src="/img/proveedor_default.png" alt="" role="presentation" class="h-100 p-3">
                                @endif
                                @if(isset($hospedaje->proveedorRnt->categoria))
                                <div class="text-overlap">
                                    
                                    <a href="/proveedor/index?tipo={{$hospedaje->proveedorRnt->categoria->id}}"><span class="btn btn-sm btn-info">{{$hospedaje->proveedorRnt->categoria->categoriaProveedoresConIdiomas->first()->nombre}}</span></a>
                                    {{-- <!--<span class="label bg-{{$colorTipo[$proveedores[$i]->proveedorRnt->categoria->id]}}">{{getItemType($proveedores[$i]->proveedorRnt->categoria->id)->name}}</span>--> --}}
                                </div>
                                @endif
                            </div>
                            <div class="tile-body">
                                <div class="tile-caption">
                                    
                                    <h5><a href="/proveedor/ver/{{$hospedaje->id}}">{{$hospedaje->proveedorRnt->razon_social}}</a></h5>
                                </div>
                                
                                @if($hospedaje->tipo == 4)
                                <p class="tile-date">{{trans('resources.listado.fechaEvento', ['fechaInicio' => date('d/m/Y', strtotime($hospedaje->fecha_inicio)), 'fechaFin' => date('d/m/Y', strtotime($hospedaje->fecha_fin))])}}</p>
                                @endif
                                <div class="btn-block ranking text-center">
                    	              <span class="{{ ($hospedaje->calificacion_legusto > 0.0) ? (($hospedaje->calificacion_legusto <= 0.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
                    	              <span class="{{ ($hospedaje->calificacion_legusto > 1.0) ? (($hospedaje->calificacion_legusto <= 1.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
                    	              <span class="{{ ($hospedaje->calificacion_legusto > 2.0) ? (($hospedaje->calificacion_legusto <= 2.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
                    	              <span class="{{ ($hospedaje->calificacion_legusto > 3.0) ? (($hospedaje->calificacion_legusto <= 3.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
                    	              <span class="{{ ($hospedaje->calificacion_legusto > 4.0) ? (($hospedaje->calificacion_legusto <= 5.0) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
                    	              <span class="sr-only">Posee una calificación de {{$hospedaje->calificacion_legusto}}</span>
                    	            
                    	          </div>
                    	          
                            </div>
                        </div>
                        
                        @endforeach
                        
                    </div>
                    <div class="text-center">
                        <a href="/proveedor/index?tipo=2&destino={{$municipio->id}}" class="btn btn-sm d-block d-md-inline-block btn-outline-success mb-3">Ver más <span class="sr-only">lugares donde dormir</span></a>
                    </div>
                @endif
            </div>
        </section>
        
        
          <section id="comentarios">
        <div class="container">
            <h3>Comentarios</h3>
            <p class="text-center">Te invitamos a que compartas tu opinión acerca de {{$atraccion->atraccionesConIdiomas[0]->nombre}}.</p>   
            <div class="text-center">
                <div class="text-center">
                <a id="btn-share-facebook" href="https://www.facebook.com/sharer/sharer.php?u={{\Request::url()}}" class="btn btn-primary" target="_blank" rel="noopener noreferrer"><span class="ion-social-facebook" aria-hidden="true"></span> Facebook</a>
                <a id="btn-share-twitter" href="https://twitter.com/home?status=Realiza {{$atraccion->atraccionesConIdiomas[0]->nombre}} en el departamento del Cesar. Conoce más en {{\Request::url()}}" class="btn btn-info" target="_blank" rel="noopener noreferrer"><span class="ion-social-twitter" aria-hidden="true"></span> Twitter</a>
                <!--<a id="btn-share-googleplus" href="https://plus.google.com/share?url={{\Request::url()}}" class="btn btn-danger" target="_blank" rel="noopener noreferrer"><span class="ion-social-googleplus" aria-hidden="true"></span> Google +</a>-->
            </div>
            </div>
            <div class="row" id="puntajes">
                <div class="col-xs-12 col-md-4">
                    <p class="text-center">¿Fue fácil llegar?</p>
                    <small class="d-block text-center">
    		            <span class="{{ ($atraccion->calificacion_llegar > 0.0) ? (($atraccion->calificacion_llegar <= 0.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($atraccion->calificacion_llegar > 1.0) ? (($atraccion->calificacion_llegar <= 1.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($atraccion->calificacion_llegar > 2.0) ? (($atraccion->calificacion_llegar <= 2.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($atraccion->calificacion_llegar > 3.0) ? (($atraccion->calificacion_llegar <= 3.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($atraccion->calificacion_llegar > 4.0) ? (($atraccion->calificacion_llegar <= 5.0) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		        </small>
                </div>
                <div class="col-xs-12 col-md-4">
                    <p class="text-center">¿Lo recomendaría?</p>
                    <small class="d-block text-center">
    		            <span class="{{ ($atraccion->calificacion_recomendar > 0.0) ? (($atraccion->calificacion_recomendar <= 0.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($atraccion->calificacion_recomendar > 1.0) ? (($atraccion->calificacion_recomendar <= 1.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($atraccion->calificacion_recomendar > 2.0) ? (($atraccion->calificacion_recomendar <= 2.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($atraccion->calificacion_recomendar > 3.0) ? (($atraccion->calificacion_recomendar <= 3.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($atraccion->calificacion_recomendar > 4.0) ? (($atraccion->calificacion_recomendar <= 5.0) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		        </small>
                </div>
                <div class="col-xs-12 col-md-4">
                    <p class="text-center">¿Regresaría?</p>
                    <small class="d-block text-center">
    		            <span class="{{ ($atraccion->calificacion_volveria > 0.0) ? (($atraccion->calificacion_volveria <= 0.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($atraccion->calificacion_volveria > 1.0) ? (($atraccion->calificacion_volveria <= 1.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($atraccion->calificacion_volveria > 2.0) ? (($atraccion->calificacion_volveria <= 2.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($atraccion->calificacion_volveria > 3.0) ? (($atraccion->calificacion_volveria <= 3.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($atraccion->calificacion_volveria > 4.0) ? (($atraccion->calificacion_volveria <= 5.0) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		        </small>
                </div>
            </div>
            <div class="text-center">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalComentario">Comentar</button>
            </div>
            @if(count($atraccion->comentariosAtracciones) > 0)
                 <ul class="list-group list-group-flush no-list-style">
                    @foreach ($atraccion->comentariosAtracciones as $comentario)
                         <li class="list-group-item">
                             <p class="text-muted m-0"><i class="ion-person"></i> {{$comentario->user->username}} - <i class="ion-calendar"></i> {{date("j/m/y", strtotime($comentario->fecha))}}</p>
        
                            <blockquote>
                            {{$comentario->comentario}}
                            </blockquote>
                        </li>
                    @endforeach
                      
                               
                </ul>
            
            @endif
        </div>
        
        
        <!-- Modal -->
         <div class="modal fade" id="modalComentario" tabindex="-1" role="dialog" aria-labelledby="labelModalComentario" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="labelModalComentario">Comentar y calificar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formEnviarComentario" name="formEnviarComentario" method="post" action="/atracciones/guardarcomentario">
                        <div class="modal-body">
                            <input type="hidden" name="id" value="{{$atraccion->id}}" />
                            <div class="form-group text-center">
                                <label class="control-label" for="calificacionLeGusto">¿Le gustó?</label>
                                <div class="checks">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="calificacionLeGusto" id="calificacionLeGusto-1" value="1" required onclick="showStars(this)">
                                        <label class="form-check-label" for="calificacionLeGusto-1"><span class="ionicons-inline ion-android-star-outline"></span><span class="sr-only">1</span></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="calificacionLeGusto" id="calificacionLeGusto-2" value="2" required onclick="showStars(this)">
                                        <label class="form-check-label" for="calificacionLeGusto-2"><span class="ionicons-inline ion-android-star-outline"></span><span class="sr-only">2</span></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="calificacionLeGusto" id="calificacionLeGusto-3" value="3" required onclick="showStars(this)">
                                        <label class="form-check-label" for="calificacionLeGusto-3"><span class="ionicons-inline ion-android-star-outline"></span><span class="sr-only">3</span></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="calificacionLeGusto" id="calificacionLeGusto-4" value="4" required onclick="showStars(this)">
                                        <label class="form-check-label" for="calificacionLeGusto-4"><span class="ionicons-inline ion-android-star-outline"></span><span class="sr-only">4</span></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="calificacionLeGusto" id="calificacionLeGusto-5" value="5" required onclick="showStars(this)">
                                        <label class="form-check-label" for="calificacionLeGusto-5"><span class="ionicons-inline ion-android-star-outline"></span><span class="sr-only">5</span></label>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="form-group text-center">
                                <label class="control-label" for="calificacionFueFacilLlegar">¿Fue fácil llegar?</label>
                                <div class="checks">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="calificacionFueFacilLlegar" id="calificacionFueFacilLlegar-1" value="1" required onclick="showStars(this)">
                                        <label class="form-check-label" for="calificacionFueFacilLlegar-1"><span class="ionicons-inline ion-android-star-outline"></span><span class="sr-only">1</span></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="calificacionFueFacilLlegar" id="calificacionFueFacilLlegar-2" value="2" required onclick="showStars(this)">
                                        <label class="form-check-label" for="calificacionFueFacilLlegar-2"><span class="ionicons-inline ion-android-star-outline"></span><span class="sr-only">2</span></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="calificacionFueFacilLlegar" id="calificacionFueFacilLlegar-3" value="3" required onclick="showStars(this)">
                                        <label class="form-check-label" for="calificacionFueFacilLlegar-3"><span class="ionicons-inline ion-android-star-outline"></span><span class="sr-only">3</span></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="calificacionFueFacilLlegar" id="calificacionFueFacilLlegar-4" value="4" required onclick="showStars(this)">
                                        <label class="form-check-label" for="calificacionFueFacilLlegar-4"><span class="ionicons-inline ion-android-star-outline"></span><span class="sr-only">4</span></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="calificacionFueFacilLlegar" id="calificacionFueFacilLlegar-5" value="5" required onclick="showStars(this)">
                                        <label class="form-check-label" for="calificacionFueFacilLlegar-5"><span class="ionicons-inline ion-android-star-outline"></span><span class="sr-only">5</span></label>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="form-group text-center">
                                <label class="control-label" for="calificacionRecomendaria">¿Lo recomendaría?</label>
                                <div class="checks">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="calificacionRecomendaria" id="calificacionRecomendaria-1" value="1" required onclick="showStars(this)">
                                        <label class="form-check-label" for="calificacionRecomendaria-1"><span class="ionicons-inline ion-android-star-outline"></span><span class="sr-only">1</span></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="calificacionRecomendaria" id="calificacionRecomendaria-2" value="2" required onclick="showStars(this)">
                                        <label class="form-check-label" for="calificacionRecomendaria-2"><span class="ionicons-inline ion-android-star-outline"></span><span class="sr-only">2</span></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="calificacionRecomendaria" id="calificacionRecomendaria-3" value="3" required onclick="showStars(this)">
                                        <label class="form-check-label" for="calificacionRecomendaria-3"><span class="ionicons-inline ion-android-star-outline"></span><span class="sr-only">3</span></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="calificacionRecomendaria" id="calificacionRecomendaria-4" value="4" required onclick="showStars(this)">
                                        <label class="form-check-label" for="calificacionRecomendaria-4"><span class="ionicons-inline ion-android-star-outline"></span><span class="sr-only">4</span></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="calificacionRecomendaria" id="calificacionRecomendaria-5" value="5" required onclick="showStars(this)">
                                        <label class="form-check-label" for="calificacionRecomendaria-5"><span class="ionicons-inline ion-android-star-outline"></span><span class="sr-only">5</span></label>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="form-group text-center">
                                <label class="control-label" for="calificacionRegresaria">¿Rgresaría?</label>
                                <div class="checks">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="calificacionRegresaria" id="calificacionRegresaria-1" value="1" required onclick="showStars(this)">
                                        <label class="form-check-label" for="calificacionRegresaria-1"><span class="ionicons-inline ion-android-star-outline"></span><span class="sr-only">1</span></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="calificacionRegresaria" id="calificacionRegresaria-2" value="2" required onclick="showStars(this)">
                                        <label class="form-check-label" for="calificacionRegresaria-2"><span class="ionicons-inline ion-android-star-outline"></span><span class="sr-only">2</span></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="calificacionRegresaria" id="calificacionRegresaria-3" value="3" required onclick="showStars(this)">
                                        <label class="form-check-label" for="calificacionRegresaria-3"><span class="ionicons-inline ion-android-star-outline"></span><span class="sr-only">3</span></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="calificacionRegresaria" id="calificacionRegresaria-4" value="4" required onclick="showStars(this)">
                                        <label class="form-check-label" for="calificacionRegresaria-4"><span class="ionicons-inline ion-android-star-outline"></span><span class="sr-only">4</span></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="calificacionRegresaria" id="calificacionRegresaria-5" value="5" required onclick="showStars(this)">
                                        <label class="form-check-label" for="calificacionRegresaria-5"><span class="ionicons-inline ion-android-star-outline"></span><span class="sr-only">5</span></label>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label" for="comentario"><span class="asterisk">*</span> Comentario</label>
                                <textarea class="form-control" id="comentario" name="comentario" rows="5" maxlength="1000" placeholder="Ingrese su comentario. Máx. 1000 caracteres" style="resize:none;" required></textarea>    
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>    
                    </form>
                    
                </div>
            </div>
        </div>
           </section>
        @endif
@endsection
@section('javascript')
<!--<script src="{{asset('/js/public/vibrant.js')}}"></script>-->
<!--<script src="{{asset('/js/public/setProminentColorImg.js')}}"></script>-->
<script>
    // Initialize and add the map
    function initMap() {
        var lat = parseFloat("<?php print($atraccion->sitio->latitud); ?>"), long = parseFloat("<?php print($atraccion->sitio->longitud); ?>");
      // The location of Uluru
      var uluru = {lat: lat, lng: long};
      // The map, centered at Uluru
      var map = new google.maps.Map(
          document.getElementById('map'), {zoom: 8, center: uluru});
      // The marker, positioned at Uluru
      var marker = new google.maps.Marker({position: uluru, map: map});
    }
    function changeViewList(obj, idList, view){
        var element, name, arr;
        element = document.getElementById(idList);
        name = view;
        element.className = "tiles " + name;
    } 
    function showStars(input){
        //var checksFacilLlegar = document.getElementsByName(input.name);
        $("input[name='" + input.name + "']+label>.ionicons-inline").removeClass('ion-android-star');
        $("input[name='" + input.name + "']+label>.ionicons-inline").addClass('ion-android-star-outline');
        for(var i = 0; i < parseInt(input.value); i++){
            $("label[for='" + input.name + "-" + (i+1) + "'] .ionicons-inline").removeClass('ion-android-star-outline');
            $("label[for='" + input.name + "-" + (i+1) + "'] .ionicons-inline").addClass('ion-android-star');
            //console.log(checksFacilLlegar[i].value);
        }
    }
</script>
<script>
    $(document).ready(function(){
        $('#modalComentario').on('hidden.bs.modal', function (e) {
            $(this).find('form')[0].reset();
            $(this).find('.checks .ionicons-inline').removeClass('ion-android-star');
            $(this).find('.checks .ionicons-inline').addClass('ion-android-star-outline');
        })
    });
</script>
<script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC55uUNZFEafP0702kEyGLlSmGE29R9s5k&callback=initMap">

</script>
@endsection
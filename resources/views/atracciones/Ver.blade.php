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
@section ('estilos')
    <link href="{{asset('/css/public/pages.css')}}" rel="stylesheet">
    <link href="{{asset('/css/public/details.css')}}" rel="stylesheet">
    <link href="//cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css" rel="stylesheet">
    
@endsection
@section('content')
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
        
        <div class="carousel-caption d-none d-md-block">
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
		  </div>
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
    				@if($paraTenerEnCuentaContieneAlgo)
    				<div class="col text-center">
    					<a href="#paraTenerEnCuenta">
    						<i class="ionicons ion-help-circled" aria-hidden="true"></i>
    						¿Qué debo tener en cuenta?
    					</a>
    				</div>
    				@endif
    				<div class="col text-center">
    					<a href="#comentarios">
    						<i class="ionicons ion-chatbubbles" aria-hidden="true"></i>
    						Comentarios
    					</a>
    				</div>
	    				
	    		</div>
	    	</div>	
    	</div>
    	
    </div>
    <section id="informacionGeneral">
        <div class="container">
            <h3>Información general</h3>
            <h4 class="text-center">{{$atraccion->sitio->sitiosConIdiomas[0]->nombre}}</h4>
            <div class="text-center">
                <button type="button" class="btn btn-lg btn-link" id="btn-favorite">
                    <span class="ionicons ion-android-favorite-outline" aria-hidden="true"></span>
                </button>
            </div>
            <iframe src="https://www.youtube.com/embed/{{print(parse_yturl($video_promocional))}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="width: 100%; height: 350px;"></iframe>
            
            <p style="white-space: pre-line;">{{$atraccion->sitio->sitiosConIdiomas[0]->descripcion}}</p>
        </div>
        
    </section>
    <section id="caracteristicas">
        <div class="container">
            <h3>Características</h3>
            <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam porttitor, augue quis tempus dictum, augue dui molestie sem, vitae molestie augue ipsum id turpis. Fusce feugiat vestibulum ante. Sed a consequat eros, finibus luctus nisl. In ut diam congue, condimentum sem vel, sagittis dolor. Nunc ut vestibulum ex, vitae eleifend metus. Proin id ex eu erat aliquet egestas. Fusce id suscipit velit, ut sodales turpis. Aliquam turpis risus, luctus vitae lobortis finibus, condimentum in felis. Pellentesque vel erat tellus. Suspendisse potenti. Integer porta sed lorem ac iaculis. Pellentesque pretium ex et convallis condimentum. In luctus leo nulla, eu finibus justo volutpat quis.</p>
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
                                    {{$atraccion->atraccionesConIdiomas[0]->horario}} {{$atraccion->atraccionesConIdiomas[0]->periodo}}
                                </div>
                            </div>
                            
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
</script>
<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNCXa64urvn7WPRdFSW29prR-SpZIHZPs&callback=initMap">
</script>
@endsection
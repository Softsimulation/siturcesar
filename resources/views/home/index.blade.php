<?php
$colorTipo = ['primary','success','danger', 'info', 'warning'];
function getItemType($type){
    $path = ""; $name = ""; $title = "";
    switch($type){
        case(1):
            $title = "Actividades";
            $name = "Actividad";
            $path = "/actividades/ver/";
            break;
        case(2):
            $title = "Atracciones";
            $name = "Atracción";
            $path = "/atracciones/ver/";
            break;
        case(3):
            $title = "Destinos";
            $name = "Destino";
            $path = "/destinos/ver/";
            break;
        case(4):
            $title = "Eventos";
            $name = "Evento";
            $path = "/eventos/ver/";
            break; 
        case(5):
            $title = "Rutas turísticas";
            $name = "Ruta turística";
            $path = "/rutas/ver/";
            break;
    }
    return (object)array('name'=>$name, 'path'=>$path, 'title' => $title);
}
?>
@extends('layout._publicLayout')

@section('Title','')
@section('meta_og')
<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = 'sRKW0ukuOe';var d=document;var w=window;function l(){var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true;s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
</script>
<!-- {/literal} END JIVOSITE CODE -->
<meta property="og:title" content="SITUR Cesar" />
<meta property="og:type" content="website" />
<meta property="og:url" content="https://www.siturcesar.com" />
<meta property="og:image" content="{{asset('/res/img/brand/128.png')}}" />
<meta property="og:description" content="Sistema de Información Turística del Cesar y de Valledupar"/>
@endsection
@section('estilos')
<style>
	.tiles .tile{
		margin: 0;
	}
	.tile .tile-body {
	    padding: 1rem 4% 2rem;
	    width: 100%;
	}
	#linksStats.tiles .tile{
		margin: 0 .5rem;
		margin-bottom: 1rem;
		width: 100%;
	}
	#linksStats.tiles .tile .tile-caption h3{
		font-weight: 500;
	}
	#linksStats.tiles .tile .tile-buttons{
		position: absolute;
	    bottom: 0;
	    left: 0;
	    width: 100%;
	}
	#linksStats.tiles .tile .tile-img {
	    height: 100px;
	    padding: 1rem;
	    display: flex;
	    justify-content: center;
	    align-items: center;
	}
	#linksStats.tiles .tile .tile-buttons .btn{
		border: 0;
	}
	#linkStat-receptor .tile-img, #linkStat-receptor .tile-buttons .btn{
		background-color: orange!important;
	}
	#linkStat-interno .tile-img, #linkStat-interno .tile-buttons .btn{
		background-color: green!important;
	}
	#linkStat-emisor .tile-img, #linkStat-emisor .tile-buttons .btn{
		background-color: #1576bb!important;
	}
	#linkStat-oferta .tile-img, #linkStat-oferta .tile-buttons .btn{
		background-color: red!important;
	}
	#linkStat-empleo .tile-img, #linkStat-empleo .tile-buttons .btn{
		background-color: yellowgreen!important;
	}
	#linkStat-sostenible .tile-img, #linkStat-sostenible .tile-buttons .btn{
		background-color: cadetblue!important;
	}
	.stats {
    	background-image: url(../../img/icons/sprite-stats-white.png);
	}
	.text-small{
		font-size: 65%;
	}
	
	@media only screen and (min-width: 768px) {
		#linksStats.tiles .tile{
			width: calc(33.3% - 1rem);
		}
	}
	@media only screen and (min-width: 992px) {
		#linksStats.tiles .tile{
			width: calc(33.3% - 1rem);
		}
	}
	@media only screen and (min-width: 1024px) {
		#linksStats.tiles .tile{
			width: calc(16.6% - 1rem);
		}
	}
	
</style>
@endsection
@section('content')
<section id="slider">
	        
            <div id="carousel-main-page" class="carousel slide carousel-fade" data-ride="carousel">
            	<ol class="carousel-indicators">
			        @for($i = 0; $i < count($sliders); $i++)
			        <li data-target="#carousel-main-page" data-slide-to="{{$i}}" @if($i == 0) class="active" @endif></li>
			        @endfor
			      </ol>
			    
			      <!-- Wrapper for slides -->
			      <div class="carousel-inner" role="listbox">
			        @for($i = 0; $i < count($sliders); $i++)
			        <div class="carousel-item @if($i == 0) active @endif">
			          <img class="d-block w-100" src="{{$sliders[$i]->rutaSlider}}" alt="{{$sliders[$i]->textoAlternativoSlider}}">
			          
			          
			          @if($sliders[$i]->tituloSlider != null && $sliders[$i]->tituloSlider != "")
			          <div class="carousel-caption d-none d-md-block">
			          	@if($sliders[$i]->enlaceAccesoSlider != null && $sliders[$i]->enlaceAccesoSlider != "")
			          		<a href="{{$sliders[$i]->enlaceAccesoSlider}}" class="text-white" @if(!$sliders[$i]->enlaceInterno) target="_blank" @endif>
			          			<p class="h2" class="text-center text-md-left col-12">
			          				{{$sliders[$i]->tituloSlider}} 
			          				 @if(!$sliders[$i]->enlaceInterno)<span class="fas fa-external-link-alt text-small" aria-hidden="true"></span>@else<span class="fas fa-link text-small" aria-hidden="true"></span>@endif
			          				@if($sliders[$i]->descripcionSlider != null && $sliders[$i]->descripcionSlider != "")
			          				
			          				<small class="d-block">{{$sliders[$i]->descripcionSlider}}</small>@endif</p>
			          		</a>
			          	@else
			            <p class="h2" class="text-center text-md-left col-12">{{$sliders[$i]->tituloSlider}} @if($sliders[$i]->descripcionSlider != null && $sliders[$i]->descripcionSlider != "")<small class="d-block">{{$sliders[$i]->descripcionSlider}}</small>@endif</p>
			          	@endif
			          </div>
			          @endif
			        </div>
			        @endfor
			        <!--<div class="item">-->
			        <!--  <img src="{{asset('img/slider/slide3.jpg')}}" alt="" role="presentation">-->
			        <!--  <div class="carousel-caption">-->
			        <!--    <h2>Hotel <small>fue el tipo de alojamiento más utilizado en el 2017</small></h2>-->
			        <!--  </div>-->
			        <!--</div>-->
			      </div>
            	
            	
      <!--        <ol class="carousel-indicators">-->
      <!--          <li data-target="#carousel-main-page" data-slide-to="0" class="active"></li>-->
      <!--          <li data-target="#carousel-main-page" data-slide-to="1"></li>-->
      <!--        </ol>-->
      <!--        <div class="carousel-inner">-->
      <!--          <div class="carousel-item active">-->
      <!--            <img class="d-block w-100" src="/img/slider/slide1.jpg" alt="First slide">-->
      <!--            <div class="carousel-caption d-none d-md-block">-->
				  <!--  <h3 class="text-center text-lg-left col-12 col-lg-6">Vacaciones recreo y ocio <small class="d-block">es el principal motivo de viaje para visitar el departamento en el 2017</small></h3>-->
				  <!--</div>-->
      <!--          </div>-->
      <!--          <div class="carousel-item">-->
      <!--            <img class="d-block w-100" src="/img/slider/slide2.jpg" alt="Second slide">-->
      <!--            <div class="carousel-caption d-none d-md-block">-->
				  <!--  <h3 class="text-center col-12">Vacaciones recreo y ocio <small class="d-block">es el principal motivo de viaje para visitar el departamento en el 2017</small></h23>-->
				  <!--</div>-->
      <!--          </div>-->
      <!--        </div>-->
            </div>
            
            
            
	    </section>
	    <div id="title-main-page">
	    	<div class="container">
	    		<div class="row align-items-center d-flex justify-content-center">
		    		<div class="col-12 col-md-3 text-center">
		    			<h2>SITUR CESAR</h2>
		    		</div>
		    		<div class="col-12 col-md-9 row align-items-center d-flex justify-content-center">
		    			
		    				<div class="col text-center">
		    					<a href="/promocionNoticia/listado">
		    						<span class="links links-noticias" aria-hidden="true"></span>
		    						Noticias
		    					</a>
		    				</div>
		    				<div class="col text-center">
		    					<a href="/quehacer?tipo=4">
		    						<span class="links links-eventos" aria-hidden="true"></span>
		    						Eventos
		    					</a>
		    				</div>
		    				<div class="col text-center">
		    					<a href="/promocionBolsaEmpleo/vacantes">
		    						<span class="links links-bolsaEmpleo" aria-hidden="true"></span>
		    						Bolsa de empleo
		    					</a>
		    				</div>
		    				<div class="col text-center">
		    					<a href="/promocionPublicacion/listado">
		    						<span class="links links-biblioteca" aria-hidden="true"></span>
		    						Biblioteca digital
		    					</a>
		    				</div>
		    		</div>
		    	</div>	
	    	</div>
	    	
	    </div>
	    <div class="container text-center">
	    	<p>SITUR Cesar es un sistema de información turística del departamento del Cesar que permite clasificar, sistematizar 
			y difundir información acerca del comportamiento de la actividad turística en la economía de la región. De igual forma, 
			es un instrumento que contribuye en la planificación turística y en el proceso de toma de decisiones por parte de las entidades 
			gubernamentales, gremios, empresarios e inversionistas, para mejorar los servicios turísticos ofrecidos.</p>
			
			<p>Las estadísticas ofrecidas por SITUR Cesar son:</p>
			<!--<div class="row">-->
				
			<!--	<div class="col-12 col-sm-6 col-md-3 col-lg-2">-->
			<!--		<div class="card">-->
			<!--			<div class="card-body">-->
			<!--				<span class="stats stats-receptor d-inline-block" aria-hidden="true"></span>-->
			<!--			    <h5 class="card-title">Turismo receptor</h5>-->
			<!--			    <p class="card-text">Caracteriza los viajes turísticos de los visitantes del Cesar, en los principales municipios turísticos, con recolección de datos mensuales.</p>-->
						    
			<!--			</div>-->
			<!--			<div class="card-footer bg-success text-white"><a href="/indicadores/receptor" class="text-white">Ir al indicador</a></div>-->
			<!--		</div>-->
					
			<!--	</div>-->
			<!--	<div class="col-12 col-sm-6 col-md-3 col-lg-2">-->
			<!--		<div class="card">-->
			<!--			<div class="card-body">-->
			<!--				<span class="stats stats-interno d-inline-block" aria-hidden="true"></span>-->
			<!--			    <h5 class="card-title">Turismo interno</h5>-->
			<!--			    <p class="card-text">Caracteriza los viajes turísticos de los hogares de los municipios con vocación turística dentro del Cesar, con medición en temporadas de vacaciones.</p>-->
						    
			<!--			</div>-->
			<!--			<div class="card-footer bg-success text-white"><a href="/indicadores/interno" class="text-white">Ir al indicador</a></div>-->
			<!--		</div>-->
					
			<!--	</div>-->
			<!--	<div class="col-12 col-sm-6 col-md-3 col-lg-2">-->
			<!--		<div class="card">-->
			<!--			<div class="card-body">-->
			<!--				<span class="stats stats-emisor d-inline-block" aria-hidden="true"></span>-->
			<!--			    <h5 class="card-title">Turismo emisor</h5>-->
			<!--			    <p class="card-text">Caracteriza los viajes turísticos de los hogares de los municipios con vocación turística fuera del Cesar, con medición en temporadas de vacaciones.</p>-->
						    
			<!--			</div>-->
			<!--			<div class="card-footer bg-success text-white"><a href="/indicadores/emisor" class="text-white">Ir al indicador</a></div>-->
			<!--		</div>-->
					
			<!--	</div>-->
			<!--	<div class="col-12 col-sm-6 col-md-3 col-lg-2">-->
			<!--		<div class="card">-->
			<!--			<div class="card-body">-->
			<!--				<span class="stats stats-oferta d-inline-block" aria-hidden="true"></span>-->
			<!--			    <h5 class="card-title">Oferta turística</h5>-->
			<!--			    <p class="card-text">Caracteriza la oferta turística en el Cesar con recolección de datos trimestrales. Variables mínimas (ocupación hotelera) recopiladas mensualmente.</p>-->
						    
			<!--			</div>-->
			<!--			<div class="card-footer bg-success text-white"><a href="/indicadores/oferta" class="text-white">Ir al indicador</a></div>-->
			<!--		</div>-->
					
			<!--	</div>-->
			<!--	<div class="col-12 col-sm-6 col-md-3 col-lg-2">-->
			<!--		<div class="card">-->
			<!--			<div class="card-body">-->
			<!--				<span class="stats stats-empleo d-inline-block" aria-hidden="true"></span>-->
			<!--			    <h5 class="card-title">Empleo</h5>-->
			<!--			    <p class="card-text">Medir el impacto de la industria turística en la generación de empleo en el Cesar, con recolección de datos trimestrales.</p>-->
						    
			<!--			</div>-->
			<!--			<div class="card-footer bg-success text-white"><a href="/indicadores/empleo" class="text-white">Ir al indicador</a></div>-->
			<!--		</div>-->
					
			<!--	</div>-->
			<!--	<div class="col-12 col-sm-6 col-md-3 col-lg-2">-->
			<!--		<div class="card">-->
			<!--			<div class="card-body">-->
			<!--				<span class="stats stats-sostenible d-inline-block" aria-hidden="true"></span>-->
			<!--			    <h5 class="card-title">Turismo sostenible</h5>-->
			<!--			    <p class="card-text">Medición de turismo sostenible en el Cesardesde el punto de vista ambiental, social y económico, anualmente.</p>-->
						    
			<!--			</div>-->
			<!--			<div class="card-footer bg-success text-white"><a href="/indicadores/sostenibilidad" class="text-white">Ir al indicador</a></div>-->
			<!--		</div>-->
					
			<!--	</div>-->
			<!--</div>-->
			<div id="linksStats" class="tiles">
				<div class="tile" id="linkStat-receptor">
					<div class="tile-img">
						<span class="stats stats-receptor d-inline-block" aria-hidden="true"></span>
					</div>
					<div class="tile-body">
						<div class="tile-caption">
							<h3>Turismo receptor</h3>
						</div>
						<p class="text-muted">
							Caracteriza los viajes turísticos de los visitantes del Cesar, en los principales municipios turísticos, con recolección de datos mensuales.
						</p>
						<div class="tile-buttons">
							<a href="/indicadores/receptor" class="btn btn-block btn-secondary">Ir al indicador</a>
						</div>
					</div>
				</div>
				<div class="tile" id="linkStat-interno">
					<div class="tile-img">
						<span class="stats stats-interno d-inline-block" aria-hidden="true"></span>
					</div>
					<div class="tile-body">
						<div class="tile-caption">
							<h3>Turismo interno</h3>
						</div>
						<p class="text-muted">
							Caracteriza los viajes turísticos de los hogares de los municipios con vocación turística dentro del Cesar, con medición en temporadas de vacaciones.
						</p>
						<div class="tile-buttons">
							<a href="/indicadores/interno" class="btn btn-block btn-secondary">Ir al indicador</a>
						</div>
					</div>
				</div>
				<div class="tile" id="linkStat-emisor">
					<div class="tile-img">
						<span class="stats stats-emisor d-inline-block" aria-hidden="true"></span>
					</div>
					<div class="tile-body">
						<div class="tile-caption">
							<h3>Turismo emisor</h3>
						</div>
						<p class="text-muted">
							Caracteriza los viajes turísticos de los hogares de los municipios con vocación turística fuera del Cesar, con medición en temporadas de vacaciones.
						</p>
						<div class="tile-buttons">
							<a href="/indicadores/emisor" class="btn btn-block btn-secondary">Ir al indicador</a>
						</div>
					</div>
				</div>
				<div class="tile" id="linkStat-oferta">
					<div class="tile-img">
						<span class="stats stats-oferta d-inline-block" aria-hidden="true"></span>
					</div>
					<div class="tile-body">
						<div class="tile-caption">
							<h3>Oferta turística</h3>
						</div>
						<p class="text-muted">
							Caracteriza la oferta turística en el Cesar con recolección de datos trimestrales. Variables mínimas (ocupación hotelera) recopiladas mensualmente.
						</p>
						<div class="tile-buttons">
							<a href="/indicadores/oferta" class="btn btn-block btn-secondary">Ir al indicador</a>
						</div>
					</div>
				</div>
				<div class="tile" id="linkStat-empleo">
					<div class="tile-img">
						<span class="stats stats-empleo d-inline-block" aria-hidden="true"></span>
					</div>
					<div class="tile-body">
						<div class="tile-caption">
							<h3>Generación de empleo</h3>
						</div>
						<p class="text-muted">
							Mide el impacto de la industria turística en la generación de empleo en el Cesar, con recolección de datos trimestrales.
						</p>
						<div class="tile-buttons">
							<a href="/indicadores/empleo" class="btn btn-block btn-secondary">Ir al indicador</a>
						</div>
					</div>
				</div>
				<div class="tile" id="linkStat-sostenible">
					<div class="tile-img">
						<span class="stats stats-sostenible d-inline-block" aria-hidden="true"></span>
					</div>
					<div class="tile-body">
						<div class="tile-caption">
							<h3>Turismo sostenible</h3>
						</div>
						<p class="text-muted">
							Medición de turismo sostenible en el Cesardesde el punto de vista ambiental, social y económico, anualmente.
						</p>
						<div class="tile-buttons">
							<a href="/indicadores/sostenibilidad" class="btn btn-block btn-secondary">Ir al indicador</a>
						</div>
					</div>
				</div>
			</div>
			
	    </div>
		<br/>
		<div id="statsMap">
		    <!-- *AQUI VA EL SVG O EL PLUGIN QUE SE HAGA PARA EL MAPA Y SUS INDICADORE -->
		    <div id="infoWeather">
		        <div class="container">
		        	<div class="row align-items-center">
		        		<div class="col-12 col-md-6 text-center justify-content">
		        			<h3>INFORMESE CON SITUR CESAR AL MOMENTO DE PLANIFICAR SU VIAJE</h3>
		        		</div>
		        		<div class="col-12 col-md-6">
		        			<a class="weatherwidget-io" href="https://forecast7.com/es/10d47n73d24/valledupar/" data-label_1="VALLEDUPAR" data-label_2="Clima" data-theme="original" >VALLEDUPAR Clima</a>
							<script>
							!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
							</script>
		        		</div>
		        	</div>
		        </div>
		    </div>
		</div>
		<section id="publicaciones">
			<div class="container">
				<div class="row">
					<div class="col-12 col-md-6">
						<h2>Noticias <small><a href="/promocionNoticia/listado" class="btn btn-outline-primary">Ver todas</a></small></h2>
						
						<div class="tiles">
							@foreach($noticias as $noticia)
							<section class="tile inline-tile">
	                            <div class="tile-img">
	                            	@if($noticia->portada)
	                            	<img src="{{$noticia->portada}}" alt="">
	                            	@endif
		                        </div>
		                        <div class="tile-body">
		                            <div class="tile-caption">
		                                    
		                                <a href="/promocionNoticia/ver/{{$noticia->idNoticia}}">
		                                    <h3>{{$noticia->tituloNoticia}}</h3>
		                                </a>
		                                <p class="date"><span class="ion-calendar" aria-hidden="true"></span> Publicado el {{date('d/m/Y h:m A', strtotime($noticia->fecha))}}</p>
		                            </div>
		                            <div class="buttons">
		                                <a class="btn btn-sm btn-outline-success" href="/promocionNoticia/ver/{{$noticia->idNoticia}}">Ver más</a>
		                            </div>
		                            
		                        </div>
	                        </section>
	                        @endforeach
	                        <!--<section class="tile inline-tile">-->
	                        <!--    <div class="tile-img">-->
	                            
		                       <!-- </div>-->
		                       <!-- <div class="tile-body">-->
		                       <!--     <div class="tile-caption">-->
		                                    
		                       <!--         <a href="#">-->
		                       <!--             <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sed quam vitae augue tempor consequat. Integer ut aliquet orci. Donec ipsum massa nullam.</h3>-->
		                       <!--         </a>-->
		                       <!--         <p class="date"><span class="ion-calendar" aria-hidden="true"></span> Publicado el 01/01/2018 00:01 AM</p>-->
		                       <!--     </div>-->
		                       <!--     <div class="buttons">-->
		                       <!--         <a class="btn btn-xs btn-link" href="#">Ver más</a>-->
		                       <!--     </div>-->
		                            
		                       <!-- </div>-->
	                        <!--</section>-->
	                        <!--<section class="tile inline-tile">-->
	                        <!--    <div class="tile-img">-->
	                            
		                       <!-- </div>-->
		                       <!-- <div class="tile-body">-->
		                       <!--     <div class="tile-caption">-->
		                                    
		                       <!--         <a href="#">-->
		                       <!--             <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sed quam vitae augue tempor consequat. Integer ut aliquet orci. Donec ipsum massa nullam.</h3>-->
		                       <!--         </a>-->
		                       <!--         <p class="date"><span class="ion-calendar" aria-hidden="true"></span> Publicado el 01/01/2018 00:01 AM</p>-->
		                       <!--     </div>-->
		                       <!--     <div class="buttons">-->
		                       <!--         <a class="btn btn-xs btn-link" href="#">Ver más</a>-->
		                       <!--     </div>-->
		                            
		                       <!-- </div>-->
	                        <!--</section>-->
						</div>
						
					</div>
					<div class="col-12 col-md-6">
						<h2>Sugeridos <small><a href="/quehacer" class="btn btn-outline-primary">Ver todo</a></small></h2>
						
						<div id="sugeridos" class="tiles">
							@foreach($sugeridos as $sugerido)
	                        <section class="tile inline-tile">
	                        	<div class="tile-img">
                                    <!--<span class="day">10</span>-->
                                    <!--<span class="month">diciembre de 2018</span>-->
                                    <!--<span class="hour">08:30 AM</span>-->
                                    @if($sugerido->portada)
                                    <img src="{{$sugerido->portada}}" alt="">
                                    @endif
                                </div>
		                        <div class="tile-body">
		                            <div class="tile-caption">
		                                   <h3><a href="{{getItemType($sugerido->tipo)->path}}{{$sugerido->id}}">
		                                    {{$sugerido->nombre}}
		                                </a></h3> 
		                                <span class="badge badge-{{$colorTipo[$sugerido->tipo - 1]}}">{{getItemType($sugerido->tipo)->name}}</span>
		                                <div class="inline-buttons mt-1">
				                            <span class="{{ ($sugerido->calificacion_legusto > 0.0) ? (($sugerido->calificacion_legusto <= 0.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span><span class="sr-only">1</span>
				                            <span class="{{ ($sugerido->calificacion_legusto > 1.0) ? (($sugerido->calificacion_legusto <= 1.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span><span class="sr-only">2</span>
				                            <span class="{{ ($sugerido->calificacion_legusto > 2.0) ? (($sugerido->calificacion_legusto <= 2.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span><span class="sr-only">3</span>
				                            <span class="{{ ($sugerido->calificacion_legusto > 3.0) ? (($sugerido->calificacion_legusto <= 3.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span><span class="sr-only">4</span>
				                            <span class="{{ ($sugerido->calificacion_legusto > 4.0) ? (($sugerido->calificacion_legusto <= 4.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span><span class="sr-only">5</span>
				                            
				                        </div>
		                                @if($sugerido->tipo == 4)
		                                <p class="date"><span class="ion-calendar" aria-hidden="true"></span> Del {{date('d/m/Y', strtotime($sugerido->fecha_inicio))}} al {{date('d/m/Y', strtotime($sugerido->fecha_fin))}} </p>
		                                @endif
		                            </div>
		                            <div class="buttons">
		                                <a class="btn btn-sm btn-outline-success" href="{{getItemType($sugerido->tipo)->path}}{{$sugerido->id}}">Ver más</a>
		                            </div>
		                            
		                        </div>
	                        </section>
	                        @endforeach
	                        <!--<section class="tile inline-tile">-->
	                        <!--    <div class="tile-img">-->
	                        <!--    	<span class="day">11</span>-->
                         <!--           <span class="month">septiembre de 2001</span>-->
                         <!--           <span class="hour">08:30 AM</span>-->
		                       <!-- </div>-->
		                       <!-- <div class="tile-body">-->
		                       <!--     <div class="tile-caption">-->
		                                    
		                       <!--         <a href="#">-->
		                       <!--             <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sed quam vitae augue tempor consequat. Integer ut aliquet orci. Donec ipsum massa nullam.</h3>-->
		                       <!--         </a>-->
		                       <!--         <p class="date"><span class="ion-android-pin" aria-hidden="true"></span> Lorem ipsum dolor sit amet</p>-->
		                       <!--     </div>-->
		                       <!--     <div class="buttons">-->
		                       <!--         <a class="btn btn-xs btn-link" href="#">Ver más</a>-->
		                       <!--     </div>-->
		                            
		                       <!-- </div>-->
	                        <!--</section>-->
						</div>
					</div>
				</div>
			</div>
		</section>
@endsection
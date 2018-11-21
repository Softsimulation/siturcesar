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
</style>
@endsection
@section('content')
<section id="slider">
	        
            <div id="carousel-main-page" class="carousel slide carousel-fade" data-ride="carousel">
              <ol class="carousel-indicators">
                <li data-target="#carousel-main-page" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-main-page" data-slide-to="1"></li>
              </ol>
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img class="d-block w-100" src="/img/slider/slide1.jpg" alt="First slide">
                  <div class="carousel-caption d-none d-md-block">
				    <h3 class="text-center text-lg-left col-12 col-lg-6">Vacaciones recreo y ocio <small class="d-block">es el principal motivo de viaje para visitar el departamento en el 2017</small></h3>
				  </div>
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" src="/img/slider/slide2.jpg" alt="Second slide">
                  <div class="carousel-caption d-none d-md-block">
				    <h3 class="text-center col-12">Vacaciones recreo y ocio <small class="d-block">es el principal motivo de viaje para visitar el departamento en el 2017</small></h23>
				  </div>
                </div>
              </div>
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
		    						<i class="links links-noticias" aria-hidden="true"></i>
		    						Noticias
		    					</a>
		    				</div>
		    				<div class="col text-center">
		    					<a href="/quehacer?tipo=4">
		    						<i class="links links-eventos" aria-hidden="true"></i>
		    						Eventos
		    					</a>
		    				</div>
		    				<div class="col text-center">
		    					<a href="/promocionBolsaEmpleo/vacantes">
		    						<i class="links links-bolsaEmpleo" aria-hidden="true"></i>
		    						Bolsa de empleo
		    					</a>
		    				</div>
		    				<div class="col text-center">
		    					<a href="/promocionPublicacion/listado">
		    						<i class="links links-biblioteca" aria-hidden="true"></i>
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
			<div class="row">
				
				<div class="col-12 col-sm-6 col-md-3 col-lg-2">
					<div class="card">
						<div class="card-body">
							<span class="stats stats-receptor d-inline-block" aria-hidden="true"></span>
						    <h5 class="card-title">Turismo receptor</h5>
						    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
						    
						</div>
						<div class="card-footer bg-success text-white"><a href="/indicadores/receptor" class="text-white">Ir al indicador</a></div>
					</div>
					
				</div>
				<div class="col-12 col-sm-6 col-md-3 col-lg-2">
					<div class="card">
						<div class="card-body">
							<span class="stats stats-interno d-inline-block" aria-hidden="true"></span>
						    <h5 class="card-title">Turismo interno</h5>
						    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
						    
						</div>
						<div class="card-footer bg-success text-white"><a href="/indicadores/interno" class="text-white">Ir al indicador</a></div>
					</div>
					
				</div>
				<div class="col-12 col-sm-6 col-md-3 col-lg-2">
					<div class="card">
						<div class="card-body">
							<span class="stats stats-emisor d-inline-block" aria-hidden="true"></span>
						    <h5 class="card-title">Turismo emisor</h5>
						    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
						    
						</div>
						<div class="card-footer bg-success text-white"><a href="/indicadores/emisor" class="text-white">Ir al indicador</a></div>
					</div>
					
				</div>
				<div class="col-12 col-sm-6 col-md-3 col-lg-2">
					<div class="card">
						<div class="card-body">
							<span class="stats stats-oferta d-inline-block" aria-hidden="true"></span>
						    <h5 class="card-title">Oferta turística</h5>
						    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
						    
						</div>
						<div class="card-footer bg-success text-white"><a href="/indicadores/oferta" class="text-white">Ir al indicador</a></div>
					</div>
					
				</div>
				<div class="col-12 col-sm-6 col-md-3 col-lg-2">
					<div class="card">
						<div class="card-body">
							<span class="stats stats-empleo d-inline-block" aria-hidden="true"></span>
						    <h5 class="card-title">Empleo</h5>
						    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
						    
						</div>
						<div class="card-footer bg-success text-white"><a href="/indicadores/empleo" class="text-white">Ir al indicador</a></div>
					</div>
					
				</div>
				<div class="col-12 col-sm-6 col-md-3 col-lg-2">
					<div class="card">
						<div class="card-body">
							<span class="stats stats-sostenible d-inline-block" aria-hidden="true"></span>
						    <h5 class="card-title">Turismo sostenible</h5>
						    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
						    
						</div>
						<div class="card-footer bg-success text-white"><a href="/indicadores/sostenibilidad" class="text-white">Ir al indicador</a></div>
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
						<h2>Noticias <small><a href="#" class="btn btn-link">Ver todo</a></small></h2>
						{{$noticias}}
						<div class="tiles">
							<section class="tile inline-tile">
	                            <div class="tile-img">
	                            
		                        </div>
		                        <div class="tile-body">
		                            <div class="tile-caption">
		                                    
		                                <a href="#">
		                                    <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc euismod justo nec urna consequat elementum. Vivamus maximus pharetra laoreet. Nulla facilisis aliquam risus a egestas. Suspendisse nullam.</h3>
		                                </a>
		                                <p class="date"><span class="ion-calendar" aria-hidden="true"></span> Publicado el 01/01/2018 00:01 AM</p>
		                            </div>
		                            <div class="buttons">
		                                <a class="btn btn-xs btn-link" href="#">Ver más</a>
		                            </div>
		                            
		                        </div>
	                        </section>
	                        <section class="tile inline-tile">
	                            <div class="tile-img">
	                            
		                        </div>
		                        <div class="tile-body">
		                            <div class="tile-caption">
		                                    
		                                <a href="#">
		                                    <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sed quam vitae augue tempor consequat. Integer ut aliquet orci. Donec ipsum massa nullam.</h3>
		                                </a>
		                                <p class="date"><span class="ion-calendar" aria-hidden="true"></span> Publicado el 01/01/2018 00:01 AM</p>
		                            </div>
		                            <div class="buttons">
		                                <a class="btn btn-xs btn-link" href="#">Ver más</a>
		                            </div>
		                            
		                        </div>
	                        </section>
	                        <section class="tile inline-tile">
	                            <div class="tile-img">
	                            
		                        </div>
		                        <div class="tile-body">
		                            <div class="tile-caption">
		                                    
		                                <a href="#">
		                                    <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sed quam vitae augue tempor consequat. Integer ut aliquet orci. Donec ipsum massa nullam.</h3>
		                                </a>
		                                <p class="date"><span class="ion-calendar" aria-hidden="true"></span> Publicado el 01/01/2018 00:01 AM</p>
		                            </div>
		                            <div class="buttons">
		                                <a class="btn btn-xs btn-link" href="#">Ver más</a>
		                            </div>
		                            
		                        </div>
	                        </section>
						</div>
						
					</div>
					<div class="col-12 col-md-6">
						<h2>Eventos <small><a href="#" class="btn btn-link">Ver todo</a></small></h2>
						<div id="events" class="tiles">
							
	                        <section class="tile inline-tile">
	                        	<div class="tile-img">
                                    <span class="day">10</span>
                                    <span class="month">diciembre de 2018</span>
                                    <span class="hour">08:30 AM</span>
                                </div>
		                        <div class="tile-body">
		                            <div class="tile-caption">
		                                    
		                                <a href="#">
		                                    <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sed quam vitae augue tempor consequat. Integer ut aliquet orci. Donec ipsum massa nullam.</h3>
		                                </a>
		                                <p class="date"><span class="ion-android-pin" aria-hidden="true"></span> Lorem ipsum dolor sit amet</p>
		                            </div>
		                            <div class="buttons">
		                                <a class="btn btn-xs btn-link" href="#">Ver más</a>
		                            </div>
		                            
		                        </div>
	                        </section>
	                        <section class="tile inline-tile">
	                            <div class="tile-img">
	                            	<span class="day">11</span>
                                    <span class="month">septiembre de 2001</span>
                                    <span class="hour">08:30 AM</span>
		                        </div>
		                        <div class="tile-body">
		                            <div class="tile-caption">
		                                    
		                                <a href="#">
		                                    <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sed quam vitae augue tempor consequat. Integer ut aliquet orci. Donec ipsum massa nullam.</h3>
		                                </a>
		                                <p class="date"><span class="ion-android-pin" aria-hidden="true"></span> Lorem ipsum dolor sit amet</p>
		                            </div>
		                            <div class="buttons">
		                                <a class="btn btn-xs btn-link" href="#">Ver más</a>
		                            </div>
		                            
		                        </div>
	                        </section>
						</div>
					</div>
				</div>
			</div>
		</section>
@endsection
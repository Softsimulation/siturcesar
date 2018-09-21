<?php
/*
* Vista para listados del portal
*/
header("Access-Control-Allow-Origin: *");
?>
@extends('layout._publicLayout')

@section('Title','Experiencias')
@section ('estilos')
    <link href="{{asset('/css/public/pages.css')}}" rel="stylesheet">
    <link href="//cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css" rel="stylesheet">
    <style>
    .carousel-caption.d-md-block{
        align-items:flex-end;
    }
    #carousel-main-page .carousel-caption h2{
        font-size: 2rem;
        text-transform: uppercase;
        text-shadow: 1px 2px 3px rgba(0,0,0,.6);
    }
    #map {
        height: 400px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
    }
    section{
        padding: 2% 0;
        position:relative;
    }
    section h3{
        padding-bottom: .25rem;
        margin-bottom: 1.5rem;
        position: relative;
        text-align:center;
        text-transform: uppercase;
    }
    section h3:before{
        position: absolute;
        content: "";
        width: 33.3%;
        left: calc(50% - 16.65%);
        top: 100%;
        border-bottom: 1px solid orange;
    }
    section h3:after{
        position: absolute;
        content: "";
        top: calc(100% + 1px);
        left: calc(50% - 5px);
        width: 0;
    	height: 0;
    	border-left: 10px solid transparent;
    	border-right: 10px solid transparent;
    	border-top: 10px solid orange;
    }
    .ionicons{
        display:block;
        text-align:center;
        font-size: 2rem;
        margin-bottom: .25rem;
    }
    .ionicons-inline{
        font-size: 2rem;
        display:inline-block;
    }
    .tile h5{
        font-weight: 400;
        text-align: center;
    }
    .tile h5 a{
        color: #333;
    }
    .tiles{
        margin: 1% 0;
    }
    #puntajes{
        margin: 1rem 0;
    }
    #puntajes p{
        margin-bottom: .25rem;
    }
    #puntajes .ionicons-inline{
        color: darkorange;
    }
    #btn-favorite{
        color: red;
    }
    .checks .form-check {
        position: relative;
    }
    
    .checks .form-check .form-check-input {
        position: absolute;
        left: calc(50% - .5rem);
        z-index: 0;
        opacity: 0;
    }
    .checks .form-check .form-check-label .ionicons-inline {
        position: relative;
        z-index: 2;
        cursor: pointer;
    }
    .ion-android-star, .ion-android-star-outline {
        color: darkorange;
        
    }
    .form-check .ion-android-star:hover,.form-check .ion-android-star-outline:hover{
        text-shadow: 0px 1px 2px rgba(0,0,0,.45);
    }
    </style>
@endsection
@section ('content')
    <div id="carousel-main-page" class="carousel slide carousel-fade" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carousel-main-page" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-main-page" data-slide-to="1"></li>
      </ol>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img class="d-block" src="/img/slider/slide1.jpg" alt="First slide">
          
        </div>
        <div class="carousel-item">
          <img class="d-block" src="/img/slider/slide2.jpg" alt="Second slide">
          
        </div>
        <div class="carousel-caption d-none d-md-block">
		    <h2 class="text-center container">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vitae condimentum enim, vel pulvinar purus. Fusce dictum tellus sit amet erat massa nunc.
		        <small class="d-block">
		            <span class="mdi mdi-star-outline"></span>
		            <span class="mdi mdi-star-outline"></span>
		            <span class="mdi mdi-star-outline"></span>
		            <span class="mdi mdi-star-outline"></span>
		            <span class="mdi mdi-star-outline"></span>
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
    				<div class="col text-center">
    					<a href="#paraTenerEnCuenta">
    						<i class="ionicons ion-help-circled" aria-hidden="true"></i>
    						¿Qué debo tener en cuenta?
    					</a>
    				</div>
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
            <div class="text-center">
                <button type="button" class="btn btn-lg btn-link" id="btn-favorite">
                    <span class="ionicons ion-android-favorite-outline" aria-hidden="true"></span>
                </button>
            </div>
            <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam porttitor, augue quis tempus dictum, augue dui molestie sem, vitae molestie augue ipsum id turpis. Fusce feugiat vestibulum ante. Sed a consequat eros, finibus luctus nisl. In ut diam congue, condimentum sem vel, sagittis dolor. Nunc ut vestibulum ex, vitae eleifend metus. Proin id ex eu erat aliquet egestas. Fusce id suscipit velit, ut sodales turpis. Aliquam turpis risus, luctus vitae lobortis finibus, condimentum in felis. Pellentesque vel erat tellus. Suspendisse potenti. Integer porta sed lorem ac iaculis. Pellentesque pretium ex et convallis condimentum. In luctus leo nulla, eu finibus justo volutpat quis.</p>

            <p class="text-center">Integer blandit risus semper libero molestie, at pulvinar ligula sodales. Sed ut nisl ac velit gravida tempus ut vitae augue. Nam feugiat posuere hendrerit. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Pellentesque dignissim nec odio eget varius. Class aptent taciti massa nunc.</p>    
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
                                    <span class="ion-android-pin" aria-hidden="true"></span> 
                                </div>
                                <div class="col">
                                    Dapibus ac facilisis in
                                </div>
                            </div>
                            
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-xs-2">
                                    <span class="ion-android-call" aria-hidden="true"></span> 
                                </div>
                                <div class="col">
                                    (000) 000 000 0000
                                </div>
                            </div>
                            
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-xs-2">
                                    <span class="ion-android-time" aria-hidden="true"></span> 
                                </div>
                                <div class="col">
                                    Dapibus ac facilisis in
                                </div>
                            </div>
                            
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-xs-2">
                                    <span class="ion-android-globe" aria-hidden="true"></span> 
                                </div>
                                <div class="col">
                                    <a href="#">Ver sitio web</a>
                                </div>
                            </div>
                            
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section id="paraTenerEnCuenta">
        <div class="container">
            <h3>¿Qué debo tener en cuenta?</h3>
            <div class="row">
                <div class="col-xs-12 col-md-4">
                    <h4>Recomendaciones</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam porttitor, augue quis tempus dictum, augue dui molestie sem, vitae molestie augue ipsum id turpis. Fusce feugiat vestibulum ante. Sed a consequat eros, finibus luctus nisl. In ut diam congue, condimentum sem vel, sagittis dolor. Nunc ut vestibulum ex, vitae eleifend metus. Proin id ex eu erat aliquet egestas. Fusce id suscipit velit, ut sodales turpis. Aliquam turpis risus, luctus vitae lobortis finibus, condimentum in felis. Pellentesque vel erat tellus. Suspendisse potenti. Integer porta sed lorem ac iaculis. Pellentesque pretium ex et convallis condimentum. In luctus leo nulla, eu finibus justo volutpat quis.</p>        
                </div>
                <div class="col-xs-12 col-md-4">
                    <h4>Recomendaciones</h4>
                    <p>Integer blandit risus semper libero molestie, at pulvinar ligula sodales. Sed ut nisl ac velit gravida tempus ut vitae augue. Nam feugiat posuere hendrerit. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Pellentesque dignissim nec odio eget varius. Class aptent taciti massa nunc.</p>
                </div>
                <div class="col-xs-12 col-md-4">
                    <h4>Cómo llegar</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam porttitor, augue quis tempus dictum, augue dui molestie sem, vitae molestie augue ipsum id turpis. Fusce feugiat vestibulum ante. Sed a consequat eros, finibus luctus nisl. In ut diam congue, condimentum sem vel, sagittis dolor. Nunc ut vestibulum ex, vitae eleifend metus. Proin id ex eu erat aliquet egestas. Fusce id suscipit velit, ut sodales turpis. Aliquam turpis risus, luctus vitae lobortis finibus, condimentum in felis. Pellentesque vel erat tellus. Suspendisse potenti. Integer porta sed lorem ac iaculis. Pellentesque pretium ex et convallis condimentum. In luctus leo nulla, eu finibus justo volutpat quis.</p>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-12">
                    <h4 class="text-center">Actividades que puedes realizar</h4>
                    <div class="tiles justify-content-center">
                        <div class="tile">
                            <div class="tile-img">
                                <img src="https://www.maravillastereo.com/wp-content/uploads/2017/05/8_procuraduria_reclama_medidas_urgentes_para_evitar_el_deterioro_del_rio_guatapuri.jpg" alt="" class="bg-img"/>
                            </div>
                            <div class="tile-body">
                                <div class="tile-caption">
                                    <h5><a href="#">Lorem ipsum dolor sit amet</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-center">
                    <a href="" class="btn btn-lg btn-success">Ver más</a>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-12">
                    <h4 class="text-center">Encuentra los proveedores de servicios turísticos que necesitas</h4>
                    <div class="tiles justify-content-center">
                        <div class="tile">
                            <div class="tile-img">
                                <img src="http://cesar.gov.co/d/images/boletines/2018/0000/0000-2018-imgtbp.jpg" alt="Logo de 1" class="bg-img"/>
                            </div>
                            <div class="tile-body">
                                <div class="tile-caption">
                                    <h5><a href="">Lorem ipsum dolor sit amet</a></h5>
                                </div>
                            </div>
                        </div>
                        <div class="tile">
                            <div class="tile-img">
                                <img src="https://www.iqreventos.com/templates/rt_xenon/custom/images/comerciovalledupar.png" alt="Logo de 2" class="bg-img"/>
                            </div>
                            <div class="tile-body">
                                <div class="tile-caption">
                                    <h5><a href="#">Lorem ipsum dolor sit amet</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-center">
                    <a href="" class="btn btn-lg btn-success">Ver más</a>
                </div>
            </div>
        </div>
        
    </section>
    <section id="comentarios">
        <div class="container">
            <h3>Comentarios</h3>
            <p class="text-center">Te invitamos a que compartas tu opinión acerca de Class aptent taciti massa nunc.</p>   
            <div class="text-center">
                <a href="#" class="btn btn-primary" target="_blank" rel="noopener noreferrer"><span class="ion-social-facebook" aria-hidden="true"></span> Facebook</a>
                <a href="#" class="btn btn-info" target="_blank" rel="noopener noreferrer"><span class="ion-social-twitter" aria-hidden="true"></span> Twitter</a>
                <a href="#" class="btn btn-danger" target="_blank" rel="noopener noreferrer"><span class="ion-social-googleplus" aria-hidden="true"></span> Google +</a>
            </div>
            <div class="row" id="puntajes">
                <div class="col-xs-12 col-md-4">
                    <p class="text-center">¿Fue fácil llegar?</p>
                    <small class="d-block text-center">
    		            <span class="ionicons-inline ion-android-star-outline"></span>
    		            <span class="ionicons-inline ion-android-star-outline"></span>
    		            <span class="ionicons-inline ion-android-star-outline"></span>
    		            <span class="ionicons-inline ion-android-star-outline"></span>
    		            <span class="ionicons-inline ion-android-star-outline"></span>
    		        </small>
                </div>
                <div class="col-xs-12 col-md-4">
                    <p class="text-center">¿Lo recomendaría?</p>
                    <small class="d-block text-center">
    		            <span class="ionicons-inline ion-android-star-outline"></span>
    		            <span class="ionicons-inline ion-android-star-outline"></span>
    		            <span class="ionicons-inline ion-android-star-outline"></span>
    		            <span class="ionicons-inline ion-android-star-outline"></span>
    		            <span class="ionicons-inline ion-android-star-outline"></span>
    		        </small>
                </div>
                <div class="col-xs-12 col-md-4">
                    <p class="text-center">¿Regresaría?</p>
                    <small class="d-block text-center">
    		            <span class="ionicons-inline ion-android-star-outline"></span>
    		            <span class="ionicons-inline ion-android-star-outline"></span>
    		            <span class="ionicons-inline ion-android-star-outline"></span>
    		            <span class="ionicons-inline ion-android-star-outline"></span>
    		            <span class="ionicons-inline ion-android-star-outline"></span>
    		        </small>
                </div>
            </div>
            <div class="text-center">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalComentario">Comentar</button>
            </div>
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
                    <form id="formEnviarComentario" name="formEnviarComentario" method="post" action="#">
                        <div class="modal-body">
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
@endsection
@section('javascript')
<!--<script src="{{asset('/js/public/vibrant.js')}}"></script>-->
<!--<script src="{{asset('/js/public/setProminentColorImg.js')}}"></script>-->
<script>
    // Initialize and add the map
    function initMap() {
      // The location of Uluru
      var uluru = {lat: 9.270037, lng: -74.634567};
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
<script>
    $(document).ready(function(){
        $('#modalComentario').on('hidden.bs.modal', function (e) {
            $(this).find('form')[0].reset();
            $(this).find('.checks .ionicons-inline').removeClass('ion-android-star');
            $(this).find('.checks .ionicons-inline').addClass('ion-android-star-outline');
        })
    });
</script>
<script>
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
@endsection
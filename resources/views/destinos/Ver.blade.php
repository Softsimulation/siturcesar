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

@section('Title',$destino->destinoConIdiomas[0]->nombre)

@section('TitleSection','Destinos')

@section('meta_og')
<meta property="og:title" content="Visita a {{$destino->destinoConIdiomas[0]->nombre}} en el departamento del Cesar" />
<meta property="og:image" content="{{asset('/res/img/brand/128.png')}}" />
<meta property="og:description" content="{{$destino->destinoConIdiomas[0]->descripcion}}"/>
@endsection

@section ('estilos')
    <link href="{{asset('/css/public/pages.css')}}" rel="stylesheet">
    <link href="{{asset('/css/public/details.css')}}" rel="stylesheet">
    <link href="//cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css" rel="stylesheet">
    
@endsection

@section('content')
    <div id="carousel-main-page" class="carousel slide carousel-fade" data-ride="carousel">
      <ol class="carousel-indicators">
        @for($i = 0; $i < count($destino->multimediaDestinos); $i++)
            <li data-target="#carousel-main-page" data-slide-to="{{$i}}" {{  $i === 0 ? 'class=active' : '' }}></li>
        @endfor
      </ol>
      <div class="carousel-inner">
      
        @for($i = 0; $i < count($destino->multimediaDestinos); $i++)
        <div class="carousel-item {{  $i === 0 ? 'active' : '' }}">
          <img class="d-block" src="{{$destino->multimediaDestinos[$i]->ruta}}" alt="Imagen de presentación de {{$destino->destinoConIdiomas[0]->nombre}}">
          
        </div>
        @endfor
        
        <div class="carousel-caption d-none d-md-block">
		    <h2 class="text-center container">{{$destino->destinoConIdiomas[0]->nombre}}
		    {{--Tipo de destino: {{$destino->tipoDestino->tipoDestinoConIdiomas[0]->nombre}} --}}
		        <small class="d-block">
		            <span class="{{ ($destino->calificacion_legusto > 0.0) ? (($destino->calificacion_legusto <= 0.9) ? 'ion-android-star-half' : 'ion-android-star') : 'ion-android-star-outline'}}" aria-hidden="true"></span>
		            <span class="{{ ($destino->calificacion_legusto > 1.0) ? (($destino->calificacion_legusto <= 1.9) ? 'ion-android-star-half' : 'ion-android-star') : 'ion-android-star-outline'}}" aria-hidden="true"></span>
		            <span class="{{ ($destino->calificacion_legusto > 2.0) ? (($destino->calificacion_legusto <= 2.9) ? 'ion-android-star-half' : 'ion-android-star') : 'ion-android-star-outline'}}" aria-hidden="true"></span>
		            <span class="{{ ($destino->calificacion_legusto > 3.0) ? (($destino->calificacion_legusto <= 3.9) ? 'ion-android-star-half' : 'ion-android-star') : 'ion-android-star-outline'}}" aria-hidden="true"></span>
		            <span class="{{ ($destino->calificacion_legusto > 4.0) ? (($destino->calificacion_legusto <= 5.0) ? 'ion-android-star-half' : 'ion-android-star') : 'ion-android-star-outline'}}" aria-hidden="true"></span>
		            <span class="sr-only">Posee una calificación de {{$destino->calificacion_legusto}}</span>
		            
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
            <h4 class="text-center">{{$destino->destinoConIdiomas[0]->nombre}}</h4>
            <div class="text-center">
                <button type="button" class="btn btn-lg btn-link" id="btn-favorite">
                    <span class="ionicons ion-android-favorite-outline" aria-hidden="true"></span>
                </button>
            </div>
            @if($video_promocional != null)
            <iframe src="https://www.youtube.com/embed/{{print(parse_yturl($video_promocional))}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="width: 100%; height: 350px;"></iframe>
            @endif
            
            <p style="white-space: pre-line;">{{$destino->destinoConIdiomas[0]->descripcion}}</p>
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
                    <div class="row">
                        <h4>Sectores</h4>
                        @foreach ($destino->sectores as $sector)
                        <div class="col-sm-12 col-md-12 col-xs-12">
                            {{$sector->sectoresConIdiomas[0]->nombre}}
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="comentarios">
        <div class="container">
            <h3>Comentarios</h3>
            <p class="text-center">Te invitamos a que compartas tu opinión acerca de {{$destino->destinoConIdiomas[0]->nombre}}</p>   
            <div class="text-center">
                <a id="btn-share-facebook" href="https://www.facebook.com/sharer/sharer.php?u={{\Request::url()}}" class="btn btn-primary" target="_blank" rel="noopener noreferrer"><span class="ion-social-facebook" aria-hidden="true"></span> Facebook</a>
                <a id="btn-share-twitter" href="https://twitter.com/intent/tweet?text=Visita a {{$destino->destinoConIdiomas[0]->nombre}} en el departamento del Cesar.&url={{\Request::url()}}&hashtags=SITURCesar" class="btn btn-info" target="_blank" rel="noopener noreferrer"><span class="ion-social-twitter" aria-hidden="true"></span> Twitter</a>
                <a id="btn-share-googleplus" href="https://plus.google.com/share?url={{\Request::url()}}" class="btn btn-danger" target="_blank" rel="noopener noreferrer"><span class="ion-social-googleplus" aria-hidden="true"></span> Google +</a>
            </div>
            <div class="row" id="puntajes">
                <div class="col-xs-12 col-md-4">
                    <p class="text-center">¿Fue fácil llegar?</p>
                    <small class="d-block text-center">
    		            <span class="{{ ($destino->calificacion_llegar > 0.0) ? (($destino->calificacion_llegar <= 0.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($destino->calificacion_llegar > 1.0) ? (($destino->calificacion_llegar <= 1.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($destino->calificacion_llegar > 2.0) ? (($destino->calificacion_llegar <= 2.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($destino->calificacion_llegar > 3.0) ? (($destino->calificacion_llegar <= 3.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($destino->calificacion_llegar > 4.0) ? (($destino->calificacion_llegar <= 5.0) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		        </small>
                </div>
                <div class="col-xs-12 col-md-4">
                    <p class="text-center">¿Lo recomendaría?</p>
                    <small class="d-block text-center">
    		            <span class="{{ ($destino->calificacion_recomendar > 0.0) ? (($destino->calificacion_recomendar <= 0.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($destino->calificacion_recomendar > 1.0) ? (($destino->calificacion_recomendar <= 1.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($destino->calificacion_recomendar > 2.0) ? (($destino->calificacion_recomendar <= 2.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($destino->calificacion_recomendar > 3.0) ? (($destino->calificacion_recomendar <= 3.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($destino->calificacion_recomendar > 4.0) ? (($destino->calificacion_recomendar <= 5.0) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		        </small>
                </div>
                <div class="col-xs-12 col-md-4">
                    <p class="text-center">¿Regresaría?</p>
                    <small class="d-block text-center">
    		            <span class="{{ ($destino->calificacion_volveria > 0.0) ? (($destino->calificacion_volveria <= 0.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($destino->calificacion_volveria > 1.0) ? (($destino->calificacion_volveria <= 1.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($destino->calificacion_volveria > 2.0) ? (($destino->calificacion_volveria <= 2.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($destino->calificacion_volveria > 3.0) ? (($destino->calificacion_volveria <= 3.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($destino->calificacion_volveria > 4.0) ? (($destino->calificacion_volveria <= 5.0) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
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
        var lat = parseFloat("<?php print($destino->latitud); ?>"), long = parseFloat("<?php print($destino->longitud); ?>");
      // The location of Uluru
      var pos = {lat: lat, lng: long};
      // The map, centered at Uluru
      var map = new google.maps.Map(
          document.getElementById('map'), {zoom: 12, center: pos});
      // The marker, positioned at Uluru
      var marker = new google.maps.Marker({position: pos, map: map});
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
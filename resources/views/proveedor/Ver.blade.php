<?php
header("Access-Control-Allow-Origin: *");
$paraTenerEnCuentaContieneAlgo = count($proveedor->actividadesProveedores) > 0;
function parse_yturl($url) 
{
    $pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
    preg_match($pattern, $url, $matches);
    return (isset($matches[1])) ? $matches[1] : false;
}
?>
@extends('layout._publicLayout')

@section('Title',$proveedor->proveedorRnt->razon_social)

@section('TitleSection','Proveedores')

@section('meta_og')
<meta property="og:title" content="Conoce a {{$proveedor->proveedorRnt->razon_social}} en el departamento del Cesar" />
<meta property="og:image" content="{{asset('/res/img/brand/128.png')}}" />
<meta property="og:description" content="{{$proveedor->proveedorRnt->idiomas[0]->descripcion}}"/>
@endsection

@section ('estilos')
    <link href="{{asset('/css/public/pages.css')}}" rel="stylesheet">
    <link href="{{asset('/css/public/details.css')}}" rel="stylesheet">
    <link href="//cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css" rel="stylesheet">
    
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
    @if(count($proveedor->multimediaProveedores) > 0)
    <div id="carousel-main-page" class="carousel slide carousel-fade" data-ride="carousel">
      <ol class="carousel-indicators">
        @for($i = 0; $i < count($proveedor->multimediaProveedores); $i++)
            <li data-target="#carousel-main-page" data-slide-to="{{$i}}" {{  $i === 0 ? 'class=active' : '' }}></li>
        @endfor
      </ol>
      <div class="carousel-inner">
      
        @for($i = 0; $i < count($proveedor->multimediaProveedores); $i++)
        <div class="carousel-item {{  $i === 0 ? 'active' : '' }}">
          <img class="d-block" src="{{$proveedor->multimediaProveedores[$i]->ruta}}" alt="Imagen de presentación de {{$proveedor->proveedorRnt->razon_social}}">
          
        </div>
        @endfor
        
        <div class="carousel-caption d-none d-md-block">
		    <h2 class="text-center container">{{$proveedor->proveedorRnt->razon_social}}
		        <small class="d-block">
		            <span class="{{ ($proveedor->calificacion_legusto > 0.0) ? (($proveedor->calificacion_legusto <= 0.9) ? 'mdi mdi-star-half' : 'mdi mdi-star') : 'mdi mdi-star-outline'}}" aria-hidden="true"></span>
		            <span class="{{ ($proveedor->calificacion_legusto > 1.0) ? (($proveedor->calificacion_legusto <= 1.9) ? 'mdi mdi-star-half' : 'mdi mdi-star') : 'mdi mdi-star-outline'}}" aria-hidden="true"></span>
		            <span class="{{ ($proveedor->calificacion_legusto > 2.0) ? (($proveedor->calificacion_legusto <= 2.9) ? 'mdi mdi-star-half' : 'mdi mdi-star') : 'mdi mdi-star-outline'}}" aria-hidden="true"></span>
		            <span class="{{ ($proveedor->calificacion_legusto > 3.0) ? (($proveedor->calificacion_legusto <= 3.9) ? 'mdi mdi-star-half' : 'mdi mdi-star') : 'mdi mdi-star-outline'}}" aria-hidden="true"></span>
		            <span class="{{ ($proveedor->calificacion_legusto > 4.0) ? (($proveedor->calificacion_legusto <= 5.0) ? 'mdi mdi-star-half' : 'mdi mdi-star') : 'mdi mdi-star-outline'}}" aria-hidden="true"></span>
		            <span class="sr-only">Posee una calificación de {{$proveedor->calificacion_legusto}}</span>
		            
		        </small>
	        </h2>
		  </div>
      </div>
      
    </div>
    @else
    <div class="text-center mt-3 mb-3">
        <h2 class="text-center container">{{$proveedor->proveedorRnt->razon_social}}
	        <small class="d-block">
	            <span class="{{ ($proveedor->calificacion_legusto > 0.0) ? (($proveedor->calificacion_legusto <= 0.9) ? 'mdi mdi-star-half' : 'mdi mdi-star') : 'mdi mdi-star-outline'}}" aria-hidden="true"></span>
	            <span class="{{ ($proveedor->calificacion_legusto > 1.0) ? (($proveedor->calificacion_legusto <= 1.9) ? 'mdi mdi-star-half' : 'mdi mdi-star') : 'mdi mdi-star-outline'}}" aria-hidden="true"></span>
	            <span class="{{ ($proveedor->calificacion_legusto > 2.0) ? (($proveedor->calificacion_legusto <= 2.9) ? 'mdi mdi-star-half' : 'mdi mdi-star') : 'mdi mdi-star-outline'}}" aria-hidden="true"></span>
	            <span class="{{ ($proveedor->calificacion_legusto > 3.0) ? (($proveedor->calificacion_legusto <= 3.9) ? 'mdi mdi-star-half' : 'mdi mdi-star') : 'mdi mdi-star-outline'}}" aria-hidden="true"></span>
	            <span class="{{ ($proveedor->calificacion_legusto > 4.0) ? (($proveedor->calificacion_legusto <= 5.0) ? 'mdi mdi-star-half' : 'mdi mdi-star') : 'mdi mdi-star-outline'}}" aria-hidden="true"></span>
	            <span class="sr-only">Posee una calificación de {{$proveedor->calificacion_legusto}}</span>
	            
	        </small>
        </h2>
    </div>
    @endif
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
    
    <div class="text-center">
        @if(Auth::check())
            <form role="form" action="/proveedor/favorito" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="proveedor_id" value="{{$proveedor->id}}" />
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
    
    <section id="informacionGeneral">
        <div class="container">
            <h3>Información general</h3>
            @if(count($proveedor->multimediaProveedores) > 0)
            <h4 class="text-center">{{$proveedor->proveedorRnt->razon_social}}</h4>
            @endif
            @if(Session::has('message'))
                <div class="alert alert-info" role="alert" style="text-align: center;">{{Session::get('message')}}</div>
            @endif
            
            @if(isset($video_promocional) && $video_promocional != null)
            <iframe src="https://www.youtube.com/embed/<?php echo parse_yturl($video_promocional)?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="width: 100%; height: 350px;"></iframe>
            @endif
            <p style="white-space: pre-line;">{{$proveedor->proveedorRnt->idiomas[0]->descripcion}}</p>
        </div>
        
    </section>
    <section id="caracteristicas">
        <div class="container">
            <h3>Características</h3>
            <!--<p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam porttitor, augue quis tempus dictum, augue dui molestie sem, vitae molestie augue ipsum id turpis. Fusce feugiat vestibulum ante. Sed a consequat eros, finibus luctus nisl. In ut diam congue, condimentum sem vel, sagittis dolor. Nunc ut vestibulum ex, vitae eleifend metus. Proin id ex eu erat aliquet egestas. Fusce id suscipit velit, ut sodales turpis. Aliquam turpis risus, luctus vitae lobortis finibus, condimentum in felis. Pellentesque vel erat tellus. Suspendisse potenti. Integer porta sed lorem ac iaculis. Pellentesque pretium ex et convallis condimentum. In luctus leo nulla, eu finibus justo volutpat quis.</p>-->
            @if(false)
            <ul class="list-group list-group-flush text-center">
              <li class="list-group-item">
                  <div class="row justify-content-center">
                    <div class="col-xs-2">
                        <span class="ion-cash" aria-hidden="true"></span> <span class="sr-only">Valor</span>
                    </div>
                    <div class="col-auto">
                        ${{number_format(intval($proveedor->valor_min))}} - ${{number_format(intval($proveedor->valor_max))}}
                    </div>
                    
                </div>
              </li>
              @if(isset($proveedor->proveedoresConIdiomas) && count($proveedor->proveedoresConIdiomas) > 0)
              <li class="list-group-item">
                            
                    <div class="row justify-content-center">
                        <div class="col-xs-2">
                            <span class="ion-android-time" aria-hidden="true"></span> <span class="sr-only">Horario</span>
                        </div>
                        <div class="col-auto">
                            {{$proveedor->proveedoresConIdiomas[0]->horario}}
                        </div>
                        
                    </div>
                </li>
                @endif
                @if($proveedor->telefono != null)
              <li class="list-group-item">
                  
                    <div class="row justify-content-center">
                        <div class="col-xs-2">
                            <span class="ion-android-call" aria-hidden="true"></span> <span class="sr-only">Telefóno</span>
                        </div>
                        <div class="col-auto">
                            {{$proveedor->telefono}}
                        </div>
                        
                    </div>
                             
              </li>
              @endif   
              @if($proveedor->sitio_web != null)
              <li class="list-group-item">
                  
                    <div class="row">
                        <div class="col-xs-2">
                            <span class="ion-android-globe" aria-hidden="true"></span> <span class="sr-only">Sitio web</span>
                        </div>
                        <div class="col">
                            <a href="{{$proveedor->sitio_web}}" target="_blank" rel="noopener noreferrer">Clic para ir al sitio web</a>
                        </div>
                    </div>
                            
              </li>
              @endif    
            </ul>
            @else
            <div class="row">
                <div class="col-12 col-md-8">
                    <div id="map"></div>
                </div>
                <div class="col-12 col-md-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-uppercase"><strong class="text-primary">Detalles</strong></li>
                        
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-1">
                                    <span class="ion-cash" aria-hidden="true"></span> <span class="sr-only">Valor</span>
                                </div>
                                <div class="col">
                                    ${{number_format(intval($proveedor->valor_min))}} - ${{number_format(intval($proveedor->valor_max))}}
                                </div>
                                
                            </div>
                        </li>
                            @if(isset($proveedor->proveedoresConIdiomas) && count($proveedor->proveedoresConIdiomas) > 0)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-1">
                                        <span class="ion-android-time" aria-hidden="true"></span> <span class="sr-only">Horario</span>
                                    </div>
                                    <div class="col">
                                        {{$proveedor->proveedoresConIdiomas[0]->horario}}
                                    </div>
                                    
                                </div>
                            </li>
                            @endif
                            @if($proveedor->telefono != null)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-1">
                                        <span class="ion-android-call" aria-hidden="true"></span> <span class="sr-only">Telefóno</span>
                                    </div>
                                    <div class="col">
                                        {{$proveedor->telefono}}
                                    </div>
                                    
                                </div>
                            </li>
                            @endif
                            @if($proveedor->sitio_web != null)
                            <li class="list-group-item">
                            <div class="row">
                                <div class="col-1">
                                    <span class="ion-android-globe" aria-hidden="true"></span> <span class="sr-only">Sitio web</span>
                                </div>
                                <div class="col">
                                    <a href="{{$proveedor->sitio_web}}" target="_blank" rel="noopener noreferrer">Clic para ir al sitio web</a>
                                </div>
                            </div>
                            </li>
                            @endif
                    </ul>
                </div>
            </div>
            @endif
            
        </div>
    </section>
    {{--@if(count($proveedor->actividadesProveedores) > 0)
    Actividades
    <div class="row">
        @foreach ($proveedor->actividadesProveedores as $actividad)
        <div class="col-sm-12 col-md-12 col-xs-12">
            Actividad {{$actividad->id}}: {{$actividad->actividadesConIdiomas[0]->nombre}}
        </div>
        @endforeach
    </div>
    @endif--}}
    <section id="comentarios">
        <div class="container">
            <h3>Comentarios</h3>
            <p class="text-center">Te invitamos a que compartas tu opinión acerca de {{$proveedor->proveedorRnt->razon_social}}.</p>   
            <div class="text-center">
                <div class="text-center">
                <a id="btn-share-facebook" href="https://www.facebook.com/sharer/sharer.php?u={{\Request::url()}}" class="btn btn-primary" target="_blank" rel="noopener noreferrer"><span class="ion-social-facebook" aria-hidden="true"></span> Facebook</a>
                <a id="btn-share-twitter" href="https://twitter.com/home?status=Realiza {{$proveedor->proveedorRnt->razon_social}} en el departamento del Cesar. Conoce más en {{\Request::url()}}" class="btn btn-info" target="_blank" rel="noopener noreferrer"><span class="ion-social-twitter" aria-hidden="true"></span> Twitter</a>
                <a id="btn-share-googleplus" href="https://plus.google.com/share?url={{\Request::url()}}" class="btn btn-danger" target="_blank" rel="noopener noreferrer"><span class="ion-social-googleplus" aria-hidden="true"></span> Google +</a>
            </div>
            </div>
            <div class="row justify-content-center" id="puntajes">
                <div class="col-xs-12">
                    <p class="text-center">¿Le gustó?</p>
                    <small class="d-block text-center">
    		            <span class="{{ ($proveedor->calificacion_legusto > 0.0) ? (($proveedor->calificacion_legusto <= 0.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($proveedor->calificacion_legusto > 1.0) ? (($proveedor->calificacion_legusto <= 1.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($proveedor->calificacion_legusto > 2.0) ? (($proveedor->calificacion_legusto <= 2.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($proveedor->calificacion_legusto > 3.0) ? (($proveedor->calificacion_legusto <= 3.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		            <span class="{{ ($proveedor->calificacion_legusto > 4.0) ? (($proveedor->calificacion_legusto <= 5.0) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
    		        </small>
                </div>
                
            </div>
            <div class="text-center">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalComentario">Comentar</button>
            </div>
            @if(count($proveedor->comentariosProveedores) > 0)
            <div class="mt-3">
                 <ul class="list-group list-group-flush no-list-style">
                    @foreach ($proveedor->comentariosProveedores as $comentario)
                         <li class="list-group-item">
                             <p class="text-muted m-0"><i class="ion-person"></i> {{$comentario->user->username}} - <i class="ion-calendar"></i> {{date("j/m/y", strtotime($comentario->fecha))}}</p>
        
                            <blockquote>
                            {{$comentario->comentario}}
                            </blockquote>
                        </li>
                    @endforeach
                      
                               
                </ul>
            </div>
            
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
                    <form id="formEnviarComentario" name="formEnviarComentario" method="post" action="/proveedor/guardarcomentario">
                        <div class="modal-body">
                            <input type="hidden" name="id" value="{{$proveedor->id}}" />
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
<script>
    // Initialize and add the map
    function initMap() {
        var lat = parseFloat("<?php print($proveedor->proveedorRnt->latitud); ?>"), long = parseFloat("<?php print($proveedor->proveedorRnt->longitud); ?>");
      // The location of Uluru
      var pos = {lat: lat, lng: long};
      // The map, centered at Uluru
      var map = new google.maps.Map(
          document.getElementById('map'), {zoom: 12, center: pos});
      // The marker, positioned at Uluru
      var marker = new google.maps.Marker({position: pos, map: map});
    }
</script>
<script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC55uUNZFEafP0702kEyGLlSmGE29R9s5k&callback=initMap">

</script>
@endsection

@extends('layout._publicLayout')

@section('Title','Rutas')

@section('TitleSection','Rutas')

@section('estilos')
    @if($ruta->portada == null)
        <style>
            header{
                position:static;
            }
        </style>
    @endif
@endsection

@section('content')
    @if($ruta->portada != null && $ruta->portada != '')
    <div id="carousel-main-page" class="carousel slide carousel-fade" data-ride="carousel">
      
      <div class="carousel-inner">
      
        <div class="carousel-item active">
          <img class="d-block" src="{{$ruta->portada}}" alt="Imagen de presentación de {{$ruta->rutasConIdiomas->nombre}}">
          
        </div>
        <div class="carousel-caption d-flex align-items-start flex-column justify-content-end flex-wrap">
            <h2 class="text-center container">
                {{$ruta->rutasConIdiomas->nombre}}
            </h2>
        </div>
       
      </div>
      
    </div>
    @else
    <div class="container">
        <h2 class="text-center text-uppercase">
            {{$ruta->rutasConIdiomas->nombre}}
        </h2>
    </div>
    @endif
    
    <div class="container mt-3 pt-3 pb-3">
        <p style="white-space: pre-line;">{{$ruta->rutasConIdiomas->descripcion}}</p>
        <p>Las atracciones que contiene esta ruta turística son:</p>
        <div class="d-flex flex-wrap justify-content-center">
            @foreach ($ruta->rutasConAtracciones as $atraccion)
            <div class="card col-md-4 col-xl-3 no-gutters mx-2">
               
              @if(count($atraccion->sitio->multimediaSitios) > 0)
              <img src="{{$atraccion->sitio->multimediaSitios[0]->ruta}}" class="card-img-top" alt="Fotografia de {{$atraccion->sitio->sitiosConIdiomas->nombre}}">
              @endif
              <div class="card-body">
                <h5 class="card-title">{{$atraccion->sitio->sitiosConIdiomas->nombre}}</h5>
                <a href="/atracciones/ver/{{$atraccion->id}}" class="btn btn-sm btn-success">Ver atracción</a>
              </div>
            </div>
            
            @endforeach
        </div>
    </div>

    
    <div id="map" style="height: 400px;"></div>
    
@endsection
@section('javascript')
<script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC55uUNZFEafP0702kEyGLlSmGE29R9s5k&callback=initMap">
</script>
<script>
    function initMap() {
        
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        var lat = 9.2700371, long = -74.6345401;
        var rutas = <?php echo $ruta->rutasConAtracciones ?>;
        
      // The location of Uluru
      var pos = {lat: lat, lng: long};
      // The map, centered at Uluru
      var map = new google.maps.Map(
          document.getElementById('map'), {zoom: 8, center: pos});
      // The marker, positioned at Uluru
      
      
      if(rutas.length > 0){
          if(rutas.length > 1){
              calculateAndDisplayRoute(directionsService, directionsDisplay, rutas);
          }else{
           //    var marker = new google.maps.Marker({position: pos, map: map});
              
          }
      }else{
          alert("La ruta turística no contiene lugares que mostrar");
      }
      directionsDisplay.setMap(map);
    }
    function calculateAndDisplayRoute(directionsService, directionsDisplay, rutas) {
        var waypts = [];
        
        //var checkboxArray = document.getElementById('waypoints');
        for (var i = 1; i < rutas.length - 1; i++) {
          
            waypts.push({
              location: new google.maps.LatLng(rutas[i].sitio.latitud, rutas[i].sitio.longitud),
              stopover: true
            });
          
        }
        console.log(waypts);
        directionsService.route({
          origin: new google.maps.LatLng(rutas[0].sitio.latitud, rutas[0].sitio.longitud),
          destination: new google.maps.LatLng(rutas[rutas.length - 1].sitio.latitud, rutas[rutas.length - 1].sitio.longitud),
          waypoints: waypts,
          optimizeWaypoints: true,
          travelMode: 'DRIVING'
        }, function(response, status) {
          if (status === 'OK') {
            directionsDisplay.setDirections(response);
            var route = response.routes[0];
            // var summaryPanel = document.getElementById('directions-panel');
            // summaryPanel.innerHTML = '';
            // // For each route, display summary information.
            // for (var i = 0; i < route.legs.length; i++) {
            //   var routeSegment = i + 1;
            //   summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +
            //       '</b><br>';
            //   summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
            //   summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
            //   summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
            // }
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
      }
</script>
@endsection

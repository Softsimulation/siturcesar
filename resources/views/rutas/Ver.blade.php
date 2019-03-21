
@extends('layout._publicLayout')

@section('Title','Rutas')

@section('TitleSection','Rutas')

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-12 col-xs-12 text-center">
            <h1>Nombre: {{$ruta->rutasConIdiomas[0]->nombre}}</h1>
        </div>
    </div>
    <div class="row">
        <img src="{{$ruta->portada}}"></img>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-4 col-sm-offset-4">
            {{$ruta->rutasConIdiomas[0]->descripcion}}
        </div>
    </div>
    <div class="row">
        @foreach ($ruta->rutasConAtracciones as $atraccion)
        <div class="col-sm-12 col-md-12 col-xs-12">
            Atraccion {{$atraccion->id}}: {{$atraccion->sitio->sitiosConIdiomas[0]->nombre}}
        </div>
        @endforeach
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
      // The location of Uluru
      var pos = {lat: lat, lng: long};
      // The map, centered at Uluru
      var map = new google.maps.Map(
          document.getElementById('map'), {zoom: 8, center: pos});
      // The marker, positioned at Uluru
      //var marker = new google.maps.Marker({position: pos, map: map});
      directionsDisplay.setMap(map);
      
      //calculateAndDisplayRoute(directionsService, directionsDisplay);
    }
    function calculateAndDisplayRoute(directionsService, directionsDisplay) {
        var waypts = [];
        var checkboxArray = document.getElementById('waypoints');
        for (var i = 0; i < checkboxArray.length; i++) {
          if (checkboxArray.options[i].selected) {
            waypts.push({
              location: checkboxArray[i].value,
              stopover: true
            });
          }
        }

        directionsService.route({
          origin: document.getElementById('start').value,
          destination: document.getElementById('end').value,
          waypoints: waypts,
          optimizeWaypoints: true,
          travelMode: 'DRIVING'
        }, function(response, status) {
          if (status === 'OK') {
            directionsDisplay.setDirections(response);
            var route = response.routes[0];
            var summaryPanel = document.getElementById('directions-panel');
            summaryPanel.innerHTML = '';
            // For each route, display summary information.
            for (var i = 0; i < route.legs.length; i++) {
              var routeSegment = i + 1;
              summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +
                  '</b><br>';
              summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
              summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
              summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
            }
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
      }
</script>
@endsection

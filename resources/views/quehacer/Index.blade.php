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

@section('Title', '¿Qué hacer?')

@section('TitleSection','Actividades')

@section('meta_og')
<meta property="og:title" content="que hacer" />
<meta property="og:image" content="{{asset('/res/img/brand/128.png')}}" />
<meta property="og:description" content="¿Qué hacer?"/>
@endsection

@section ('estilos')
    <link href="{{asset('/css/public/pages.css')}}" rel="stylesheet">
    <link href="{{asset('/css/public/details.css')}}" rel="stylesheet">
    <link href="//cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css" rel="stylesheet">
    
@endsection

@section('content')
    {{print_r($query)}}
@endsection
@section('javascript')
<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNCXa64urvn7WPRdFSW29prR-SpZIHZPs&callback=initMap">
</script>
<script>
    
    function initMap() {
          var sitiosConActividades = <?php //print($actividad->sitiosConActividades); ?>;
          console.log(sitiosConActividades);
          var lat = 10.1287919, long = -75.366555;
          var posInit = {lat: lat, lng: long};
          // Initialize and add the map
          var map = new google.maps.Map(
              document.getElementById('map'), {zoom: 8, center: posInit});
          for (i = 0; i < sitiosConActividades.length; i++) { 
              var pos = {lat: parseFloat(sitiosConActividades[i].latitud), lng: parseFloat(sitiosConActividades[i].longitud)};
              var marker = new google.maps.Marker({position: pos, map: map});
          }
            
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
@endsection

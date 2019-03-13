<!DOCTYPE html>

<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Sistema de Información Turística del Cesar y de Valledupar">
        <meta name="keywords" content="SITUR Cesar, Visita Cesar, Visit Cesar, Turismo en el Cesar, estadisticas Cesar, Cesar" />
        <meta name="author" content="Softsimulation S.A.S" />
        <meta name="copyright" content="SITUR Capítulo Cesar, Softsimulation S.A.S" />
        
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{\Request::url()}}" />
        @yield('meta_og')
        <title>@yield('title') SITUR Cesar</title>
        <link rel='manifest' href='{{asset("/manifest.json")}}'>
        <meta name='mobile-web-app-capable' content='yes'>
        <meta name='apple-mobile-web-app-capable' content='yes'>
        <meta name='application-name' content='SITUR Cesar'>
        <meta name='apple-mobile-web-app-status-bar-style' content='blue'>
        <meta name='apple-mobile-web-app-title' content='SITUR Cesar'>
        <link rel='icon' sizes='192x192' href='{{asset("/img/brand/192.png")}}'>
        <link rel='apple-touch-icon' href='{{asset("/img/brand/192.png")}}'>
        <meta name='msapplication-TileImage' content='{{asset("/img/brand/144.png")}}'>
        <meta name='msapplication-TileColor' content='#004A87'>
        <meta name="theme-color" content="#004A87" />
        <meta http-equiv="cache-Control" content="max-age=21600" />
        <meta http-equiv="cache-control" content="no-cache" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Roboto:300,400,700" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="//cdn.materialdesignicons.com/2.6.95/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="{{asset('/css/public/style.css')}}" type="text/css" />
        <link href="{{asset('/css/public/style_768.css')}}" rel="stylesheet" media="(min-width: 768px)">
        <link href="{{asset('/css/public/style_992.css')}}" rel="stylesheet" media="(min-width: 992px)">
        <link href="{{asset('/css/public/style_1200.css')}}" rel="stylesheet" media="(min-width: 1200px)">
        <link href="{{asset('/css/public/style_1600.css')}}" rel="stylesheet" media="(min-width: 1600px)">
        <style>
            /*Google traductor*/
            .goog-te-gadget img {
                display: none!important;
            }
            .goog-te-gadget-simple {
                background: transparent!important;
                color: white!important;
                border: 0!important;
            }
            .goog-te-gadget-simple .goog-te-menu-value span {
                color: #333!important;
                font-size: 1rem!important;
                padding-right: .5rem!important;
                font-family: Futura, sans-serif!important;
            }
            .goog-te-banner {
                background: black!important;
                color: tton button {
                color: #333!important;
            }
            .goog-te-button div {
                background: transparent!important;
                border: 0!important;
            }
            .goog-te-button button {
                color: #333!important;
                border: 0!important;
                background-color: transparent!important;
                font-family: Futura, sans-serif!important;
            }
            .goog-te-button {
                border: 0!important;
            }
            .goog-te-menu-value span {
                color: tton button {
                color: #333!important;
                font-family: Futura, sans-serif!important;
            }
        </style>
        
        <script src="{{secure_asset('/js/plugins/angular.min.js')}}"></script>

        @yield('estilos')
        
    </head>
    <body @yield('app') @yield('controller') >
        <!-- vista parcial de cabecera de vista pública -->
        @include('layout.partial.headerPublic')
        
        <main id="content-main" role="main">
            @yield('content')
        </main>
        
        <!-- vista parcial de pie de página de vista pública -->
        @include('layout.partial.footerPublic')
        
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script src="{{asset('/js/public/script-main.js')}}"></script>
        
        <script src="{{asset('/js/sweetalert.min.js')}}" async></script>
        
        @yield('javascript')
        
        <script type="text/javascript" defer>
            if ('serviceWorker' in navigator) {
                console.log('CLIENT: service worker situr Cesar registration in progress.');
                navigator.serviceWorker.register('/service-worker.js', { scope: '/' }).then(function () {
                    console.log('CLIENT: service worker situr Cesar registration complete.');
                }, function () {
                    console.log('CLIENT: service worker situr Cesar registration failure.');
                });
            } else {
                console.log('CLIENT: service worker situr Cesar is not supported.');
                document.getElementsByTagName("html")[0].setAttribute("manifest", "/cache.appcache");
            }
        </script>
        <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function (event) {
                
                jQuery('.loadingContent').delay(1000).fadeOut("slow");
                
            });
        </script>

        
        
        
        <noscript>Su buscador no soporta Javascript!</noscript>
        
    </body>
</html>
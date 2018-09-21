<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de Información Turística del CESAR y de Valledupar">
    <meta name="keywords" content="SITUR Cesar, Visita CESAR, Visit Cesar, Turismo en el Cesar, estadisticas Cesar, Cesar" />
    <meta name="author" content="Softsimulation S.A.S" />
    <meta name="copyright" content="SITUR Cesar, Softsimulation S.A.S" />
    <meta property="og:title" content="SITUR Cesar" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.siturcesar.com" />
    <meta property="og:image" content="{{asset('/res/img/brand/128.png')}}" />
    <meta property="og:description" content="Sistema de Información Turística del Cesar y de Valledupar"/>
    <title>@yield('Title') SITUR Cesar</title>
    <link rel='manifest' href='res/manifest.json'>
    <meta name='mobile-web-app-capable' content='yes'>
    <meta name='apple-mobile-web-app-capable' content='yes'>
    <meta name='application-name' content='SITUR Cesar'>
    <meta name='apple-mobile-web-app-status-bar-style' content='blue'>
    <meta name='apple-mobile-web-app-title' content='SITUR Cesar'>
    <link rel='icon' sizes='192x192' href='res/img/brand/192.png'>
    <link rel='apple-touch-icon' href='res/img/brand/192.png'>
    <meta name='msapplication-TileImage' content='res/img/brand/144.png'>
    <meta name='msapplication-TileColor' content='#004A87'>
    <meta name="theme-color" content="#004A87" />
    <meta http-equiv="cache-Control" content="max-age=21600" />
    <meta http-equiv="cache-control" content="no-cache" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Roboto:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('/css/public/style.css')}}" type="text/css" />
    <link href="{{asset('/css/public/style_768.css')}}" rel="stylesheet" media="(min-width: 768px)">
    <link href="{{asset('/css/public/style_992.css')}}" rel="stylesheet" media="(min-width: 992px)">
    <link href="{{asset('/css/public/style_1200.css')}}" rel="stylesheet" media="(min-width: 1200px)">
    <link href="{{asset('/css/public/style_1600.css')}}" rel="stylesheet" media="(min-width: 1600px)">
    @yield('estilos')
    <style>
        #introduce p, #introduce ul{
            font-weight: 300;
            font-size: 1.325rem;
            text-align:center;
            margin: 0;
            padding-top: .5rem;
            padding-bottom: 1rem;
        }
		#title-main-page {
		    background-color: #018037;
		    padding: 2% 0;
		    color: white;
		    margin-bottom: 2%;
		}
		#title-main-page a{
			color: white;
			font-weight: 400;
			text-transform: uppercase;
		}
		#infoWeather{
			padding: 4%; width: 100%; background-color: #eee;text-align:center;display:flex;align-items: center; justify-content: center;flex-wrap: wrap;
			background-image: url(/img/bg-clima.jpg);
			background-size: cover;
			background-position: center center;
			color: white;
			position:relative;
		}
		#infoWeather:before {
		    content: "";
		    width: 100%;
		    height: 100%;
		    position: absolute;
		    background-color: rgba(0,0,0,.25);
		    box-shadow: inset 0px 1px 8px 0px rgba(0,0,0,.5);
		}
		#infoWeather h3{
			text-shadow: 0px 1px 2px rgba(0,0,0,.65);
		}
		
		#publicaciones{
			padding: 2% 0;
		}
		.tiles .tile:not(:last-child) {
		    border-bottom: 1px solid #eee;
		}
		#events .tile.inline-tile:nth-child(odd) .tile-img{
			background-color: green;
		}
		#events .tile.inline-tile:nth-child(even) .tile-img{
			background-color: #8bbe44;
		}
    </style>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	@include('layout.partial.headerPublic')
	<main id="content-main" role="main">
	    @yield('content')
		
	</main>
	@include('layout.partial.footerPublic')
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    <script src="/js/public/script-main.js"></script>
    @yield('javascript')
    <script type="text/javascript">
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
</body>
</html>
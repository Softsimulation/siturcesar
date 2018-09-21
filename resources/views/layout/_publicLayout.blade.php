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
	<header class="row no-gutters">
		<div class="brand col-md-3">
			<a href="/">
				<img src="/img/brand/96.png" alt="Logo de SITUR Magdalena">
				<h1 class="sr-only">SITUR Cesar</h1>
			</a>
			
		</div>
		<div id="nav-bar-main" class="col-md">
			<div id="toolbar-main" class="row no-gutters justify-content-end align-items-center">
			    <a href="#content-main" id="goto-top" class="sr-only">Ir al contenido</a>
				<div id="socialNetworks-fixed">
				    <a href="https://twitter.com/siturcesar?lang=es" target="_blank" rel="noreferrer noopener" title="Ir a twitter"><span class="ion-social-twitter" aria-hidden="true"></span> <span class="sr-only">Twitter</span></a>
    				<!--<a href="#" target="_blank" rel="noreferrer noopener" title="Ir a Facebook"><span class="ion-social-facebook" aria-hidden="true"></span> <span class="sr-only">Facebook</span></a>-->
    				<a href="https://www.instagram.com/siturcesar/" target="_blank" rel="noreferrer noopener" title="Ir a Instagram"><span class="ion-social-instagram" aria-hidden="true"></span> <span class="sr-only">Instagram</span></a>    
				</div>
				
				<form name="searchMainForm" method="get" action="" class="form-inline">
				    <div class="form-group">
				        <label class="sr-only" for="searchMainTBox">Campo de búsqueda</label>
    					<input type="text" id="searchMainTBox" name="search" maxlength="255" placeholder="¿Qué desea buscar?" required autocomplete="off"/>
    					<button type="submit" title="Buscar"><span class="ion-search" aria-hidden="true"></span> <span class="sr-only">Buscar</span></button>    
				    </div>
					
				</form>
				<a href="#">Mapa del sitio</a>
				<form name="langForm" method="get" action="">
					<label class="sr-only" for="languange">Selección de idioma</label>
					<select id="languange" name="lang" onchange="this.form.submit();">
						<option value="es" selected>Español</option>
						<option value="en">Inglés</option>
					</select>
				</form>
				<a href="#"><span class="ion-person" aria-hidden="true"></span> <span class="d-none d-sm-inline">Iniciar sesión</span></a>
			</div>
			<div id="navbar-mobile" class="text-center">
                <button type="button" class="btn btn-block btn-primary" title="Menu de navegación"><span aria-hidden="true" class="ion-navicon-round"></span><span class="sr-only">Menú de navegación</span></button>
            </div>
			<div id="nav-menu-main">
				<nav role="navigation" id="nav-main">
                    <ul role="menubar">
                        <li>
                            <a id="menu-inicio" role="menuitem" href="/">Inicio</a>
                        </li>
                        <li>
                            <a role="menuitem" href="#menu-visitarAlCesar" aria-haspopup="true" aria-expanded="false">Visita al Cesar</a>
                            <ul role="menu" id="menu-visitarAlCesar" aria-label="Visita al Cesar">
                                <li role="none">
                                    <a role="menuitem" href="/QueHacer">Qué hacer</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="/Experiencias">Experiencias</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="/PST">Proveedores de Servicios Turísticos</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a role="menuitem" href="#menu-estadisticas" aria-haspopup="true" aria-expanded="false">Estadísticas</a>
                            <ul role="menu" id="menu-estadisticas" aria-label="Estadísticas">
                                <li role="none">
                                    <a role="menuitem" href="#">Turismo receptor</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="#">Turismo interno</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="#">Turismo emisor</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="#">Oferta turística</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="#">Empleo</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="#">Turismo sostenible</a>
                                </li>
                            </ul>
                        </li>
                        
                        <li>
                            <a role="menuitem" href="#menu-publicaciones" aria-haspopup="true" aria-expanded="false">Publicaciones</a>
                            <ul role="menu" id="menu-publicaciones" aria-label="Publicaciones">
                                <li role="none">
                                    <a role="menuitem" href="#">Noticias</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="#">Eventos</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a id="menu-contacto" role="menuitem" href="#">Contáctenos</a>
                        </li>
                    </ul>
                </nav>
			</div>
		</div>
	</header>
	<main id="content-main" role="main">
	    @yield('content')
		
	</main>
	<footer>
	    <div id="logosFooter" class="container text-center">
	        <img src="/img/brand/others/logo_gobierno.png" alt="Logo de Gobierno de Colombia">
	        <img src="/img/brand/others/logo_mincit.png" alt="Logo de Ministerio de Comercio, Industria y Turismo">
	        <img src="/img/brand/others/logo_fontur.png" alt="Logo de FONTUR" style="margin: 0 6px;">
	        <img src="/img/brand/others/logo_camaraComercio.png" alt="Logo de la camara de comercio de Valledupar" style="margin: 0 6px;">
	        <img src="/img/brand/others/logo_gobernacion.jpg" alt="Logo de la gobernación del Cesar" style="margin: 0 6px;">
	    </div>
	    <div class="container">
	        <div class="row align-items-center">
	            <div class="col-12 col-md-4 text-center">
	            	<div style="height: 150px; width: 150px; background:white; border-radius: 50%;overflow: hidden;margin: 1rem 0" class="d-inline-flex align-middle">
	            		<img src="/img/brand/others/logo_cesar.png" alt="" role="presentation" style="width: 100%;">
	            	</div>
	                
	            </div>
	            <div class="col-12 col-md-8">
	                <h3>Información de contacto</h3>
	                
	                <ul class="list-footer">
                        <li><span class="glyphicon glyphicon-earphone"></span> Tel: +57 (5) 897868 - +57 (5) 845413 <br></li>
                        <li><span class="glyphicon glyphicon-map-marker"></span> Calle 15 N 4 - 33 Sede Principal</li>
                    </ul>
	            </div>
	        </div>
	    </div>
	    <div id="sign-footer">
	        <div class="container text-center">
	            Desarrollado por Softsimulation S.A.S - SITUR Cesar &copy; 2018
	            <a href="#goto-top" class="sr-only">Volver al inicio</a>
	        </div>
	        
	    </div>
		
	</footer>
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
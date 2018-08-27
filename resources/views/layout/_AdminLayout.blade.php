<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistema de Información Turistica del Magdalena y Santa Marta">
    <meta name="author" content="SITUR Magdalena">
    <title>@yield('Title')</title>
    <link rel="icon" type="image/ico" href="{{asset('Content/icons/favicon-96x96.png')}}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!--<link href="{{asset('/css/bootstrap-material-design.css')}}" rel="stylesheet" type="text/css" />-->
    <link href="{{asset('/css/ripples.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/sweetalert.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/ionicons.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/styleLoading.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/object-table-style.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/ADM-dateTimePicker.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/select.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/select2.css')}}" rel='stylesheet' type='text/css' />
   
   
<link href="{{asset('css/dashboard/style.css')}}" rel='stylesheet' type='text/css' />
<!-- Graph CSS -->
<link href="{{asset('css/dashboard/font-awesome.css')}}" rel="stylesheet"> 
<!-- jQuery -->
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'>
<!-- lined-icons -->
<link rel="stylesheet" href="{{asset('css/dashboard/icon-font.min.css')}}" type='text/css' />
<!-- //lined-icons -->
<script src="{{asset('js/administrador/dashboard/jquery-1.10.2.min.js')}}"></script>
<script src="{{asset('js/administrador/dashboard/amcharts.js')}}"></script>	
<script src="{{asset('js/administrador/dashboard/serial.js')}}"></script>	
<script src="{{asset('js/administrador/dashboard/light.js')}}"></script>	
<script src="{{asset('js/administrador/dashboard/radar.js')}}"></script>	
<link href="{{asset('css/dashboard/barChart.css')}}" rel='stylesheet' type='text/css' />
<link href="{{asset('css/dashboard/fabochart.css')}}" rel='stylesheet' type='text/css' />
<!--clock init-->
<script src="{{asset('js/administrador/dashboard/css3clock.js')}}"></script>
<!--Easy Pie Chart-->
<!--skycons-icons-->
<script src="{{asset('js/administrador/dashboard/skycons.js')}}"></script>

<script src="{{asset('js/administrador/dashboard/jquery.easydropdown.js')}}"></script>
        
    @yield('estilos')
    <style>
        .carga {
           display: none;
           position: fixed;
           z-index: 1000;
           top: 0;
           left: 0;
           height: 100%;
           width: 100%;
           background: rgba(0, 0, 0, 0.57) url({{asset('Content/Cargando.gif')}}) 50% 50% no-repeat
       }
       
        body.charging { overflow: hidden; }
        body.charging .carga { display: block; }
    
        .banner {
            background-color: white;
            padding-top: 1em;
            padding-bottom: 1em;
            color: dimgray;
            text-align: center;
            font-weight: 700;
        }

            .banner img {
                height: 6em;
            }

        .title-section {
            background-color: dodgerblue;
            color: white;
            width: 100%;
            padding: 4%;
            padding-top: .5em;
            padding-bottom: .5em;
            text-align: center;
            /*margin-bottom: 1em;*/
        }

        .asterik {
            color: red;
            font-size: 1em;
        }

        .checkbox {
            margin-bottom: 0.5em;
        }

        .checkbox label, .radio label {
            color: dimgray;
        }

        .form-group {
            margin: 0;
        }

        .table > tbody > tr > td {
            padding-bottom: 0;
            font-weight: 400;
            font-size: 16px;
        }

        .table > thead > tr > th {
            text-align: center;
        }

        .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
            vertical-align: middle;
        }

        .fixed {
            position: fixed;
            top: 0;
            width: 100%;
        }

        .alert-fixed {
            position: fixed;
            width: 80%;
            top: 2%;
            left: 10%;
            box-shadow: 0px 0px 3px 0px rgba(0,0,0,.5);
            z-index: 10;
        }

        .control-label {
            color: dimgrey !important;
        }

        .label-danger {
            font-size: 1em;
        }

        .progress {
            height: 1.4em;
        }

        .progress-bar {
            font-size: 1.2em;
            font-weight: 500;
            line-height: 1.3em;
        }

        .radio label, label.radio-inline {
            padding-left: 1.8em;
        }
        #log form {
            float: none !important;
        }

            #log form a {
                text-decoration: none;
                color: #333 !important;
                font-size: 1em !important;
                font-weight: 400;
                padding: 3px 20px;
            }
            .tooltip-inner {
                text-align:left !important;
            }
            .btn-default-focus{
                outline: none;
                outline-offset: 0;
                box-shadow: none;
                background-color: transparent;
            }
            .ui-select-multiple.ui-select-bootstrap .ui-select-match-item{
                font-size: 16px;
            }
             .ADMdtp-box footer .timeSelectIcon, .ADMdtp-box footer .today, .ADMdtp-box footer .calTypeContainer p{
                fill: darkorange;
                color: darkorange;
            }
            .ADMdtp-box footer .calTypeContainer p{
                display: none;
            }
            .ui-select-multiple.ui-select-bootstrap input.ui-select-search {
                width: 100% !important;
            }
            .sidebar-menu{
                overflow: auto;
            }
    </style>
</head>
<body @yield('app')  @yield('controller') >
    
    <div id="preloader">
        <div>
            <div class="loader"></div>
            <h1>{{ trans('resources.LabelPreloader') }}</h1>
            <h4>Por favor espere</h4>
            <img src="{{asset('Content/image/logo.min.png')}}" width="200" />
        </div>
    </div>
    
  
        
        
        
        
        
            <div class="page-container">
   <!--/content-inner-->
	<div class="left-content">
	   <div class="inner-content">
		<!-- header-starts -->
			<div class="header-section">
						<!--menu-right-->
				
						<!--//menu-right-->
					<div class="clearfix"></div>
				</div>
					<!-- //header-ends -->
				     <div class="title-section">
            <h3 style="margin-top: 0.5em;"><strong>@yield('TitleSection')</strong></h3>
        </div>
       <div class='container'>
        @yield('content')
    </div>
  
									<!--/charts-inner-->
									</div>
										<!--//outer-wp-->
									</div>
								
								</div>
								
								
								
        
        
   
    <!--
    if (ViewContext.HttpContext.User.IsInRole("Admin") || ViewContext.HttpContext.User.IsInRole("Digitador"))
    {
        <footer id="seccion" ng-controller="seccionCtrl">
            <select class="selectLenguage" style="margin: 0" ng-options="seccion as seccion.nombre for seccion in secciones track by seccion.id" ng-model="seccionSelected">
                <option value="" selected disabled>Ir a la sección</option>
            </select>
        </footer>
    }
    -->

    
    	<!--/sidebar-menu-->
				<div class="sidebar-menu">
					<header class="logo">
		 <img  class="img-responsive" width="304" height="236" src="{{asset('Content/image/logo.png')}}"> 
			
				</header>
			<div style="border-top:1px solid rgba(69, 74, 84, 0.7)"></div>
			<!--/down-->
							<div class="down">	
									  <a href="#"><img src="{{asset('Content/image/user.png')}}"></a>
									  <a href="#"><span class=" name-caret">Usuario</span></a>
									 <p>Rol</p>
									<ul>
									<li><a class="tooltips" href=""><span>Profile</span><i class="lnr lnr-user"></i></a></li>
										<li><a class="tooltips" href="#"><span>Settings</span><i class="lnr lnr-cog"></i></a></li>
										<li><a class="tooltips" href="/login/cerrarsesion"><span>Log out</span><i class="lnr lnr-power-switch"></i></a></li>
										</ul>
									</div>
							   <!--//down-->
                           <div class="menu">
									<ul id="menu" >
									    
									    <li id="menu-academico" ><a href="#"><i class="lnr lnr-book"></i> <span>Promoción</span> </span></a>
									          <ul id="menu-academico-sub" >
    										    <li id="menu-academico-avaliacoes" ><a href="{{asset('administradordestinos')}}">Administrar Destinos</a></li>
    										    <li id="menu-academico-avaliacoes" ><a href="{{asset('administradorproveedores')}}">Administrar Proveedores</a></li>
    										    <li id="menu-academico-avaliacoes" ><a href="{{asset('administradoratracciones')}}">Administrar Atracciones</a></li>
    										    <li id="menu-academico-avaliacoes" ><a href="{{asset('administradoractividades')}}">Administrar Actividades</a></li>
    										    <li id="menu-academico-avaliacoes" ><a href="{{asset('administradoreventos')}}">Administrar Eventos</a></li>
    										    <li id="menu-academico-avaliacoes" ><a href="{{asset('administradorrutas')}}">Administrar Rutas turisticas</a></li>
    										  </ul>
									     </li>
										
										 <li id="menu-academico" ><a href="{{asset('turismoreceptor/listadoencuestas')}}"><i class="fa fa-table"></i> <span> Turismo Receptor</span></span></a>
										  
										</li>
										 <li id="menu-academico" ><a href="{{asset('temporada')}}"><i class="fa fa-file-text-o"></i> <span>Turismo Interno y Emisor</span></a>
											
										 </li>
										 <li id="menu-academico" ><a href="{{asset('ofertaempleo/listadoproveedores')}}"><i class="fa fa-table"></i> <span> Oferta y empleo</span></span></a>
										  
										 </li>
										 <li id="menu-academico" ><a href="#"><i class="lnr lnr-book"></i> <span>Sostenibilidad</span> </span></a>
    										  <ul id="menu-academico-sub" >
    										    <li id="menu-academico-avaliacoes" ><a href="{{asset('sostenibilidadhogares/encuestas')}}">Hogares</a></li>
    										  </ul>
									     </li>
										 <li id="menu-academico" ><a href="{{asset('exportacion')}}"><i class="fa fa-file-text-o"></i> <span>Exportación</span></a>
											
										 </li>
								
    									 <li id="menu-academico" ><a href="#"><i class="lnr lnr-book"></i> <span>Administrar paises</span> </span></a>
    										  <ul id="menu-academico-sub" >
    										    <li id="menu-academico-avaliacoes" ><a href="{{asset('administrarpaises')}}">Paises</a></li>
    										    <li id="menu-academico-boletim" ><a href="{{asset('administrardepartamentos')}}">Departamentos</a></li>
    											<li id="menu-academico-boletim" ><a href="{{asset('administrarmunicipios')}}">Municipios</a></li>
    											
    										  </ul>
    									 </li>
									 
								
									 <!--
									 <li><a href="{{asset('MuestraMaestra/periodos')}}"><i class="lnr lnr-envelope"></i> <span>Muestra Maestra</span></a>
									
									</li>
							        <li id="menu-academico" ><a href="{{asset('encuesta/listado')}}"><i class="lnr lnr-layers"></i> <span>Encuetas ADHOC</span></a>
							
									 </li>
								
								
								  </ul>
								  -->
								</div>
							  </div>
   
    <script src="{{asset('/js/plugins/angular.min.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{asset('/Content/bootstrap_material/dist/js/material.min.js')}}"></script>
    <script src="{{asset('/Content/bootstrap_material/dist/js/ripples.min.js')}}"></script>
   
    <script src="{{asset('/js/sweetalert.min.js')}}"></script>
    <script>
        $(window).load(function () { $("#preloader").delay(1e3).fadeOut("slow") });
    </script>
    <script>
            $(window).on('scroll', function () {
                if (!$('.alert').hasClass('no-fixed')) {
                    if ($(this).scrollTop() > 190) {
                        $('.alert').addClass('alert-fixed');
                    } else {
                        $('.alert').removeClass('alert-fixed');
                    }
                }
            });
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
    </script>
    @yield("javascript")
    <noscript>Su buscador no soporta Javascript!</noscript>
   
    <div class="carga" ></div>
   
</body>
</html>
<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistema de Información Turistica del departamento del Cesar y Valledupar">
    <meta name="author" content="SITUR Cesar">
    <title><?php echo $__env->yieldContent('title'); ?> SITUR Cesar</title>
    <link rel="icon" type="image/ico" href="<?php echo e(asset('Content/icons/favicon-96x96.png')); ?>" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800|Roboto:100,400,700" rel="stylesheet">
    <link href="<?php echo e(asset('/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('/css/sweetalert.min.css')); ?>" rel='stylesheet' type='text/css' />
    <!--<link href="<?php echo e(asset('/css/ionicons.min.css')); ?>" rel='stylesheet' type='text/css' />-->
    <link href="<?php echo e(asset('/css/styleLoading.css')); ?>" rel='stylesheet' type='text/css' />
    <link href="<?php echo e(asset('/css/object-table-style.css')); ?>" rel='stylesheet' type='text/css' />
    <link href="<?php echo e(asset('/css/ADM-dateTimePicker.min.css')); ?>" rel='stylesheet' type='text/css' />
    <link href="<?php echo e(asset('/css/select.min.css')); ?>" rel='stylesheet' type='text/css' />
    <link href="<?php echo e(asset('/css/select2.css')); ?>" rel='stylesheet' type='text/css' />
    <link href="<?php echo e(asset('/css/layout/AdminLayoutStyle.css')); ?>" rel='stylesheet' type='text/css' />
    <link href="<?php echo e(asset('/css/layout/AdminLayoutStyle_768.css')); ?>" rel="stylesheet" media="(min-width: 768px)">
    <link href="<?php echo e(asset('/css/layout/AdminLayoutStyle_992.css')); ?>" rel="stylesheet" media="(min-width: 992px)">
    <link href="<?php echo e(asset('/css/layout/AdminLayoutStyle_1024.css')); ?>" rel="stylesheet" media="(min-width: 1024px)">
    <link href="<?php echo e(asset('/css/layout/AdminLayoutStyle_1200.css')); ?>" rel="stylesheet" media="(min-width: 1200px)">
    <script src="<?php echo e(asset('/js/plugins/angular.min.js')); ?>"></script>

    <?php echo $__env->yieldContent('estilos'); ?>
    <style>
        .carga {
           display: none;
           position: fixed;
           z-index: 1060;
           top: 0;
           left: 0;
           height: 100%;
           width: 100%;
           background: rgba(0, 0, 0, 0.57) url(<?php echo e(asset('Content/Cargando.gif')); ?>) 50% 50% no-repeat
       }
       
        body.charging { overflow: hidden; }
        body.charging .carga { display: block; }
    
        
        .checkbox {
            margin-bottom: 0.5em;
        }

        .checkbox label, .radio label {
            color: dimgray;
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

        
        .label-danger {
            font-size: 1em;
        }


        .radio label, label.radio-inline {
            padding-left: 1.8em;
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
            
    </style>
</head>
<body <?php echo $__env->yieldContent('app'); ?>  <?php echo $__env->yieldContent('controller'); ?> >
    
    <div id="preloader">
        <div>
            <div class="loader"></div>
            <h1><?php echo e(trans('resources.LabelPreloader')); ?></h1>
            <h4>Por favor espere</h4>
            <img src="<?php echo e(asset('/img/brand/72.png')); ?>" width="200" />
        </div>
    </div>
    <div id="content-main">
        <aside id="left-side-menu">
            <div id="brand">
                <a href="/">
                    <img src="<?php echo e(asset('/img/brand/72.png')); ?>" alt="Logo de Situr Cesar"> 
                    <h1 class="sr-only">Sistema de información turística del departamento del Cesar</h1>    
                </a>
                
            </div>
            <div id="optionsLoggedUser">
                <p class="text-overflow text-center">usuario@correo.com</p>
                <ul>
    			    <li><a href="#" title="Tablero de usuario"><span class="sr-only">Perfil de usuario</span><i class="ion-person"></i></a></li>
    				<li><a href="#" title="Configuración"><span class="sr-only">Configuración</span><i class="ion-gear-a"></i></a></li>
    				<li><a href="/login/cerrarsesion" title="Cerrar sesión"><span class="sr-only">Cerrar sesión</span><i class="ion-log-out"></i></a></li>
    			</ul>
            </div>
            <div id="navbar-mobile" class="text-center">
                <button type="button" class="btn btn-block btn-primary" title="Menu de navegación"><span aria-hidden="true" class="ion-navicon-round"></span><span class="sr-only">Menú de navegación</span></button>
            </div>
            <div id="nav-menu-main">
                <nav role="navigation">
                    <ul role="menubar">
                        <li>
                            <a role="menuitem" href="#menuPromocion" aria-haspopup="true" aria-expanded="false">Promoción</a>
                            <ul role="menu" id="menuPromocion" aria-label="Promoción">
                                <li role="none">
                                    <a role="menuitem" href="<?php echo e(asset('administradordestinos')); ?>">Administrar destinos</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="<?php echo e(asset('administradorproveedores')); ?>">Administrar proveedores</a>
                                </li>
                                <li role="none"><a role="menuitem" href="<?php echo e(asset('administradoratracciones')); ?>">Administrar atracciones</a></li>
        					    <li role="none"><a role="menuitem" href="<?php echo e(asset('administradoragit ctividades')); ?>">Administrar actividades</a></li>
        					    <li role="none"><a role="menuitem" href="<?php echo e(asset('administradoreventos')); ?>">Administrar eventos</a></li>
        					    <li role="none"><a role="menuitem" href="<?php echo e(asset('administradorrutas')); ?>">Administrar rutas turísticas</a></li>
        					    <li role="none"><a role="menuitem" href="<?php echo e(asset('sliders/listadosliders')); ?>">Galería de imágenes</a></li>
        					            <li>
                            <a role="menuitem" href="<?php echo e(asset('publicaciones/listadoadmin')); ?>">Biblioteca Digital</a>
                        </li>
                                  <li>
                            <a role="menuitem" href="<?php echo e(asset('informes/configuracion')); ?>">Informes</a>
                        </li>
                          <li>
                            <a role="menuitem" href="<?php echo e(asset('noticias/listadonoticias')); ?>">Noticias</a>
                        </li>
                          <li>
                            <a role="menuitem" href="<?php echo e(asset('bolsaEmpleo/vacantes')); ?>">Bolsa de empleo</a>
                        </li>
                            </ul>
                        </li>
                         
                        <li>
                            <a role="menuitem" href="<?php echo e(asset('turismoreceptor/listadoencuestas')); ?>">Turismo receptor</a>
                        </li>
                        <li>
                            <a role="menuitem" href="<?php echo e(asset('temporada')); ?>">Turismo interno y emisor</a>
                        </li>
                       
                       
                           <li>
                            <a role="menuitem" href="#menuSostenibilidad" aria-haspopup="true" aria-expanded="false">Oferta y empleo</a>
                            <ul role="menu" id="menuSostenibilidad" aria-label="Sostenibilidad">
                                <li role="none">
                                    <a role="menuitem" href="<?php echo e(asset('ofertaempleo/listadoproveedores')); ?>">Listado de proveedores</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="<?php echo e(asset('ofertaempleo/listadoproveedoresrnt')); ?>">Activar proveedores</a>
                                </li>
                                  <li role="none">
                                    <a role="menuitem" href="<?php echo e(asset('importarRnt')); ?>">Importar RNT</a>
                                </li>
                            </ul>
                        </li>
                        
                          <li>
                            <a role="menuitem" href="<?php echo e(asset('MuestraMaestra/periodos')); ?>">Muestra Maestra</a>
                        </li>
                        <li>
                            <a role="menuitem" href="#menuSostenibilidad" aria-haspopup="true" aria-expanded="false">Sostenibilidad</a>
                            <ul role="menu" id="menuSostenibilidad" aria-label="Sostenibilidad">
                                <li role="none">
                                    <a role="menuitem" href="<?php echo e(asset('sostenibilidadhogares/encuestas')); ?>">Hogares</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="<?php echo e(asset('sostenibilidadpst/encuestas')); ?>">PST</a>
                                </li>
                            </ul>
                        </li>
                         <li>
                            <a role="menuitem" href="<?php echo e(asset('encuesta/listado')); ?>">Encuestas personalizadas</a>
                        </li>
                  
                          <li>
                            <a role="menuitem" href="<?php echo e(asset('EstadisticasSecundarias/configuracion')); ?>">Estadísticas secundarias</a>
                        </li>
                        
                        <li>
                            <a role="menuitem" href="<?php echo e(asset('exportacion')); ?>">Exportación</a>
                        </li>
                         <li>
                            <a role="menuitem" href="<?php echo e(asset('indicadoresMedicion/listado')); ?>">Gestionar indicadores</a>
                        </li>
                        
                        
                         <li>
                            <a role="menuitem" href="<?php echo e(asset('calcularindicadores')); ?>">Calcular indicadores</a>
                        </li>
                        <li>
                            <a role="menuitem" href="#menuPaises" aria-haspopup="true" aria-expanded="false">Administrar países</a>
                            <ul role="menu" id="menuPaises" aria-label="Administrar países">
                                <li role="none">
                                    <a role="menuitem" href="<?php echo e(asset('administrarpaises')); ?>">Países</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="<?php echo e(asset('administrardepartamentos')); ?>">Departamentos</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="<?php echo e(asset('administrarmunicipios')); ?>">Municipios</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
            
        </aside>
        
        <div id="content-page">
            <div class="title-page">
                <h2 class="container"><?php echo $__env->yieldContent('titulo'); ?></h2>  
                <p><?php echo $__env->yieldContent('subtitulo'); ?></p>
            </div>
            
            <div class="container">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
                
        </div>    
    </div>
        

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   
    <script src="<?php echo e(asset('/js/sweetalert.min.js')); ?>" async></script>
    <script src="/js/public/script-main.js" async></script>
    <script>
        $(window).load(function () { $("#preloader").delay(1e3).fadeOut("slow") });
    </script>
    <script>
            // $(window).on('scroll', function () {
            //     if (!$('.alert').hasClass('no-fixed')) {
            //         if ($(this).scrollTop() > 190) {
            //             $('.alert').addClass('alert-fixed');
            //         } else {
            //             $('.alert').removeClass('alert-fixed');
            //         }
            //     }
            // });
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
            $(function() {
              // whenever we hover over a menu item that has a submenu
              $('#nav-menu-main nav>ul>li').on('mouseover', function() {
                var $menuItem = $(this),
                    $submenuWrapper = $('> ul', $menuItem);
                
                // grab the menu item's position relative to its positioned parent
                var menuItemPos = $menuItem.position();
                
                // place the submenu in the correct position relevant to the menu item
                $submenuWrapper.css({
                  top: menuItemPos.top,
                  left: menuItemPos.left + Math.round($menuItem.outerWidth() * 1)
                });
              });
            });
    </script>
    <script>
        $(".nav-tabs a[data-toggle=tab]").on("click", function(e) { if ($(this).parent().hasClass("disabled")) { e.preventDefault(); return false; } });
    </script>
    <?php echo $__env->yieldContent("javascript"); ?>
    <noscript>Su buscador no soporta Javascript!</noscript>
   
    <div class="carga" ></div>
   
</body>
</html>
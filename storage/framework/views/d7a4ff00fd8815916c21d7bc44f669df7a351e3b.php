<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistema de Información Turistica del Cesar">
    <meta name="author" content="SITUR Cesar">
    <title><?php echo $__env->yieldContent('Title'); ?></title>
    <link rel="icon" type="image/ico" href="<?php echo e(asset('Content/icons/favicon-96x96.png')); ?>" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="<?php echo e(asset('/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
    <!--<link href="<?php echo e(asset('/css/bootstrap-material-design.css')); ?>" rel="stylesheet" type="text/css" />-->
    <link href="<?php echo e(asset('/css/ripples.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('/css/sweetalert.min.css')); ?>" rel='stylesheet' type='text/css' />
    <link href="<?php echo e(asset('/css/ionicons.min.css')); ?>" rel='stylesheet' type='text/css' />
    <link href="<?php echo e(asset('/css/styleLoading.css')); ?>" rel='stylesheet' type='text/css' />
    <link href="<?php echo e(asset('/css/object-table-style.css')); ?>" rel='stylesheet' type='text/css' />
    <link href="<?php echo e(asset('/css/ADM-dateTimePicker.min.css')); ?>" rel='stylesheet' type='text/css' />
    <link href="<?php echo e(asset('/css/select.css')); ?>" rel='stylesheet' type='text/css' />
    <link href="<?php echo e(asset('/css/select2.css')); ?>" rel='stylesheet' type='text/css' />
    <link href="<?php echo e(asset('/css/ADM-dateTimePicker.min.css')); ?>" rel="stylesheet" type="text/css" />
        
    <?php echo $__env->yieldContent('estilos'); ?>
    <style>
        .carga {
           display: none;
           position: fixed;
           z-index: 1000;
           top: 0;
           left: 0;
           height: 100%;
           width: 100%;
           background: rgba(0, 0, 0, 0.57) url(../../Content/Cargando.gif) 50% 50% no-repeat
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
    </style>
</head>
<body <?php echo $__env->yieldContent('app'); ?>  <?php echo $__env->yieldContent('controller'); ?> >
    
    <div id="preloader">
        <div>
            <div class="loader"></div>
            <h1><?php echo e(trans('resources.LabelPreloader')); ?></h1>
            <h4>Resource.LabelPorFavorEspere</h4>
            <img src="<?php echo e(asset('Content/image/logo.min.png')); ?>" width="200" />
        </div>
    </div>
    
    <header>
        <div class="banner">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-2">
                        <img src="<?php echo e(asset('Content/image/logo.png')); ?>" alt="Logo" />
                    </div>
                    <div class="col-xs-12 col-md-9">
                        <h1 style="margin-top: 0.6em; text-transform: uppercase"><strong><?php echo $__env->yieldContent('Title'); ?></strong></h1>
                    </div>
                    <div class="col-xs-12 col-md-1">
                        <div class="btn-group">
                            <a href="bootstrap-elements.html" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown"><i class="material-icons">menu</i></a>
                            <ul class="dropdown-menu">
                                <li><a href="/Temporada">Volver</a></li>
                                <li class="divider"></li>
                                <li id="log">
                                    <!--
                                    using (Html.BeginForm("LogOff", "Account", FormMethod.Post, new { id = "logoutForm", @class  = "navbar-right" }))
                                    {
                                        Html.AntiForgeryToken()

                                        <a href="javascript:document.getElementById('logoutForm').submit()" style="color: white;font-size: 1.2em;"><span class="ion-android-person"></span> Resource.LabelCerrarSesion</a>
                                    }
                                    -->
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="title-section">
            <h3 style="margin-top: 0.5em;"><strong><?php echo $__env->yieldContent('TitleSection'); ?></strong></h3>
        </div>
     
    </header>
    <div class="container" >
        <?php echo $__env->yieldContent('content'); ?>
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

   
    <script src="<?php echo e(asset('/js/plugins/angular.min.js')); ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="<?php echo e(asset('/Content/bootstrap_material/dist/js/material.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/Content/bootstrap_material/dist/js/ripples.min.js')); ?>"></script>
    <script>
        $.material.init();
    </script>
    <script src="<?php echo e(asset('/js/plugins/checklist-model.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/plugins/select.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('/js/plugins/angular-filter.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/plugins/angular-repeat-n.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/ADM-dateTimePicker.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('/js/plugins/angular-sanitize.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('/js/plugins/object-table.js')); ?>" type="text/javascript"></script>
       
    <script src="<?php echo e(asset('/js/administrador/administrador.js')); ?>" type="text/javascript"></script> 
    <script src="<?php echo e(asset('/js/administrador/temporadas.js')); ?>" type="text/javascript"></script> 
    <script src="<?php echo e(asset('/js/administrador/services.js')); ?>" type="text/javascript"></script> 
    
    <script src="<?php echo e(asset('/js/sweetalert.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/dir-pagination.js')); ?>"></script>
  
    
    

    <script>
        $(window).load(function () { $("#preloader").delay(1e3).fadeOut("slow") });
    </script>

    <script>  $.material.init(); </script>

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
    <?php echo $__env->yieldContent("javascript"); ?>
    <noscript>Su buscador no soporta Javascript!</noscript>
   
    <div class="carga" ></div>
   
</body>
</html>
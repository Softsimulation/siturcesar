
@extends('layout._ofertaEmpleoLayaout')

@section('Title','Caracterización de empleados :: SITUR Magdalena')


@section('estilos')
    <style>
        .title-section {
            background-color: #4caf50 !important;
        }

        .table > thead > tr > th {
            background-color: rgba(0,0,0,.1);
        }

        .jp-options {
            position: absolute;
            background-color: white;
            z-index: 2;
            width: 95%;
            max-height: 300px;
            overflow-y: auto;
            -webkit-box-shadow: 0px 3px 8px -1px rgba(0,0,0,0.75);
            -moz-box-shadow: 0px 3px 8px -1px rgba(0,0,0,0.75);
            box-shadow: 0px 3px 8px -1px rgba(0,0,0,0.75);
            color: dimgray;
        }

        .jp-options > div {
            border-bottom: 0.5px solid rgba(0,0,0,.1);
            padding-left: 2%;
        }

        .jp-options > div label {
            cursor: pointer;
        }

        .st-list-tag {
            list-style: none;
            margin: 0;
            padding: 0;
            white-space:0;
        }

        .st-list-tag li {
            display: inline-block;
            margin-bottom: 0.5em;
            min-width: 8.3%;
            margin-right: 1em;
            border-radius: 20px;
            padding: 1em;
            padding-top: .5em;
            padding-bottom: .5em;
            background-color: dodgerblue;
            color: white;
            text-align: center;
            font-weight: 400;
            cursor: pointer;
        }

        .thead-fixed {
            position: fixed;
            z-index: 10;
            width: 100%;
            top: 0;
            background-color: lightgray;
        }

        .carga {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.57) url(../../Content/Cargando.gif) 50% 50% no-repeat;
        }
        /* Cuando el body tiene la clase 'loading' ocultamos la barra de navegacion */
        body.charging {
            overflow: hidden;
        }

        /* Siempre que el body tenga la clase 'loading' mostramos el modal del loading */
        body.charging .carga {
            display: block;
        }

        .alert-fixed {
            z-index: 60;
        }
        label {
            color: dimgray;
        }
        .form-group label {
            font-size: 1em!important;
        }
        .label.label-danger {
            font-size: .9em;
            font-weight: 400;
            padding: .16em .5em;
        }
    </style>
@endsection
@section('TitleSection','Caracterización de empleados')
@section('Progreso','90%')
@section('NumSeccion','90%')
@section('app','ng-app="ofertaempleo"')
@section('controller','ng-controller="empleoCaracterizacion"')

@section('content')

    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>Errores:</b></label>
        <br />
        <div ng-repeat="error in errores" ng-if="error.length>0">
            -@{{error[0]}}
        </div>
    </div>

    <form role="form" name="empleoForm" novalidate>

       <div class="capEmpleoCac">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Necesidades de capacitación: ¿Hubo cargos que requerían capacitación?</b></h3>
                </div>
                <div class="panel-footer"><b>Seleccione una opción</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" id="SiCapacitacionh" value="1" name="opt1h" ng-model="empleo.Hubo_capacitacion" ng-required="true">
                                    Si
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" id="NoCapacitacionh" value="0" name="opt1h" ng-model="empleo.Hubo_capacitacion" ng-required="true">
                                    No
                                </label>
                            </div>
                            <span ng-show="empleoForm.$submitted || empleoForm.opt1h.$touched">
                                <span class="label label-danger" ng-show="empleoForm.opt1h.$error.required">* El campo es requerido.</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-success" ng-if="empleo.Hubo_capacitacion == 1">
                <div class="panel-heading">
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿En cuáles temas realizó la capacitación?</b></h3>
                </div>
                <div class="panel-footer"><b></b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" name="temaCapacitacionh" ng-minlength="1" ng-maxlength="150" class="form-control" ng-model="empleo.TemaCapacitacion" placeholder="Ingrese los temas que realizó capacitación a sus empleados" ng-required="empl.Capacitacion==1"/>
                        </div>
                    </div>
                    <span ng-show="empleoForm.$submitted || empleoForm.temaCapacitacionh.$touched">
                        <span class="label label-danger" ng-show="empleoForm.temaCapacitacionh.$error.required">* El campo es requerido.</span>
                    </span>
                </div>
            </div>
        </div>

       <div class="capEmpleo">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Ha realizado procesos de capacitación en su empresa?</b></h3>
                </div>
                <div class="panel-footer"><b>Seleccione una opción</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" id="SiCapacitacion" value="1" name="opt1" ng-model="empleo.capacitacion" ng-required="true">
                                    Si
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" id="NoCapacitacion" value="0" name="opt1" ng-model="empleo.capacitacion" ng-required="true">
                                    No
                                </label>
                            </div>
                            <span ng-show="empleoForm.$submitted || empleoForm.opt1.$touched">
                                <span class="label label-danger" ng-show="empleoForm.opt1.$error.required">* El campo es requerido.</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

             <div class="panel panel-success" ng-show="empleo.capacitacion == 1">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Tematicas desarrolladas</b></h3>
                            </div>
                            <div class="panel-footer"><b>. Por favor indique en que temáticas ha capacitado la empresa y si fue realizada o no por la entidad</b></div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div style="overflow-x: auto;">
                                            <table id="tgastos" class="table table-condensed table-bordered table-hover">
                                                <thead id="head-tgastos">
                                                    <tr>
                                                        <th class="text-center">Nombre de la tematica</th>
                                                        <th class="text-center">Realiza por la empresa</th>
                                                       <th>
                                                        <!--EncuestaEstanciaBtnAgregarDest. Agregar destino-->
                                                        <button type="button" class="btn btn-success" ng-click="agregar()" title="Agregar tematica"><i class="material-icons">add</i></button>
                                                      
                                                    </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="tematica in empleo.tematicas">
                                                        <td>
                                                                          
                                                        <input type="text" name="temaCapacitacion@{{$index}}" ng-minlength="1" ng-maxlength="250" class="form-control" ng-model="tematica.nombre" placeholder="Ingrese los temas que realizó capacitación a sus empleados" ng-required="empleo.capacitacion ==1"/>
      
                                                        <span ng-show="empleoForm.$submitted || empleoForm.temaCapacitacion@{{$index}}.$touched">
                                                            <span class="label label-danger" ng-show="empleoForm.temaCapacitacion@{{$index}}.$error.required">* El campo es requerido.</span>
                                                        </span>
                                                        </td>
                                                        <td>
                                                            
                                                            <div class="radio radio-primary">
                                                                <label>
                                                                    <input type="radio" id="SiCapacitacion@{{$index}}" value="1" name="opt1@{{$index}}" ng-model="tematica.realizada_empresa" ng-required="true">
                                                                    Si
                                                                </label>
                                                            </div>
                                                            <div class="radio radio-primary">
                                                                <label>
                                                                    <input type="radio" id="NoCapacitacion@{{$index}}" value="0" name="opt1@{{$index}}" ng-model="tematica.realizada_empresa" ng-required="true">
                                                                    No
                                                                </label>
                                                            </div>
                                                            <span ng-show="empleoForm.$submitted || empleoForm.opt1@{{$index}}.$touched">
                                                                <span class="label label-danger" ng-show="empleoForm.opt1@{{$index}}.$error.required">* El campo es requerido.</span>
                                                            </span>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <!--EncuestaEstanciaBtnEliminarDest. Eliminar destino-->
                                                                <button type="button" class="btn btn-danger" ng-click="quitar(tematica)" title="Eliminar tematica"><i class="material-icons">close</i></button>
                                                        </td>
                                                    </tr>
                                                    
                                            
                                                </tbody>
                                            </table>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        </div>
        
       <div>
            <div class="panel panel-success">
            <div class="panel-heading">
         
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>.Dando cumplimiento a la ley de Protección de datos Personales le solicito su autorización para que SITUR
Cesar pueda contactarlo nuevamente en caso de ser necesario ¿Está usted de acuerdo? </b></h3>
            </div>
            <div class="panel-footer"><b>si o no </b></div>
            <div class="panel-body">
                <div class="row">
                <div class="col-md-12">
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" id="SiCapacitacion" value="1" name="autorizacion" ng-model="empleo.autorizacion" ng-required="true">
                                    Si
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" id="NoCapacitacion" value="0" name="autorizacion" ng-model="empleo.autorizacion" ng-required="true">
                                    No
                                </label>
                            </div>
                            <span ng-show="empleoForm.$submitted || empleoForm.autorizacion.$touched">
                                <span class="label label-danger" ng-show="empleoForm.autorizacion.$error.required">* El campo es requerido.</span>
                            </span>
                        </div>
                </div>

            </div>
        </div>
        </div>
        
       <div>
            <div class="panel panel-success">
            <div class="panel-heading">
         
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>D8 Ya para terminar, le solicito su autorización para que SITUR
Cesar comparta sus respuestas con las entidades que contrataron el proyecto si o no </b></h3>
            </div>
            <div class="panel-footer"><b>si o no </b></div>
            <div class="panel-body">
                <div class="row">
                <div class="col-md-12">
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" id="SiCapacitacion" value="1" name="esta_acuerdo" ng-model="empleo.esta_acuerdo" ng-required="true">
                                    Si
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" id="NoCapacitacion" value="0" name="esta_acuerdo" ng-model="empleo.esta_acuerdo" ng-required="true">
                                    No
                                </label>
                            </div>
                            <span ng-show="empleoForm.$submitted || empleoForm.esta_acuerdo.$touched">
                                <span class="label label-danger" ng-show="empleoForm.esta_acuerdo.$error.required">* El campo es requerido.</span>
                            </span>
                        </div>
                </div>

            </div>
        </div>
        </div>
        
       <div>
            <div class="panel panel-success">
            <div class="panel-heading">
         
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>Por cual medio le gustaría actualizar la información </b></h3>
            </div>
            <div class="panel-footer"></div>
            <div class="panel-body">
                <div class="row">
                <div class="col-md-12">
                            <div class="radio radio-primary">
                                <label ng-repeat ="medio in data.actualizaciones ">
                                    <input type="radio" id="SiCapacitacion" value="@{{medio.id}}" name="medios_actualizacion_id" ng-model="empleo.medios_actualizacion_id" ng-required="true">
                                    @{{medio.nombre}}
                                </label>
                            </div>
                            <span ng-show="empleoForm.$submitted || empleoForm.medios_actualizacion_id.$touched">
                                <span class="label label-danger" ng-show="empleoForm.medios_actualizacion_id.$error.required">* El campo es requerido.</span>
                            </span>
                        </div>
                </div>

            </div>
        </div>
        </div>

        <div class="row" style="text-align:center">
            <a href="/ofertaempleo/empleomensual/{{$id}}" class="btn btn-raised btn-default">Anterior</a>
            <input type="submit" class="btn btn-raised btn-success" ng-click="guardar()" value="Siguiente" />
        </div>
        <br />
    </form>

    <div class='carga'>

    </div>
@endsection



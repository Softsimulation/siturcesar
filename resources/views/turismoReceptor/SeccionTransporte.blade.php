@extends('layout._encuestaLayout')

@section('title', 'Encuesta turismo receptor')

@section('estilos')
    <style>
        .title-section {
            background-color: #16469e !important;
        }
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
        /* Cuando el body tiene la clase 'loading' ocultamos la barra de navegacion */
        body.charging {
            overflow: hidden;
        }

            /* Siempre que el body tenga la clase 'loading' mostramos el modal del loading */
            body.charging .carga {
                display: block;
            }
        .input-text-radio {
            position: static!important;
            display: inline-block!important;
            margin-left: .5rem;
            width: auto;
        }
    </style>
@endsection

@section('TitleSection', 'Transporte')

@section('Progreso', '33.33%')

@section('NumSeccion', '33%')

@section('controller','ng-controller="transporte"')

@section('content')
<div class="main-page">
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    
    <div class="alert alert-danger" role="alert" ng-if="errores" ng-repeat="error in errores">
       @{{error[0]}}
    </div>
    <form role="form" name="transForm" novalidate>
        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- ¿Qué tipo de transporte utilizó para llegar al departamento del Magdalena?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>C1. ¿Qué tipo de transporte utilizó para llegar al departamento del Atlántico?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio" ng-repeat="item in transportes">
                            <label>
                                <input type="radio" name="llegar" ng-value="item.id" ng-model="transporte.Llegar" ng-required="true"> @{{item.tipos_transporte_con_idiomas[0].nombre}}
                                <i ng-if="item.id==6" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="left" title="@Resource.AyudaTipoTransporte"
                                   style="text-align:right;">
                                </i>
                            </label>
                            <div class="form-group input-text-radio"  ng-if="item.id==11 && transporte.Llegar==11">
                                <label style="padding:0;" for="otroLlegar" class="sr-only">Ingrese el otro transporte</label>
                                <input type="text" class="input-text-radio form-control" name="otroLlegar" style="display:inline-block;" id="otroLlegar" placeholder="Escriba su otra opción" ng-model="transporte.otroLlegar"  ng-required="transporte.Llegar==11" />    
                            </div>
                        </div>
                        
                    </div>
                </div>
                <span  ng-show="transForm.$submitted || transForm.llegar.$touched">
                    <span class="label label-danger" ng-show="transForm.llegar.$error.required">* El campo es requerido.</span>
                    <span class="label label-danger" ng-show="transForm.otroLlegar.$error.required">* El campo otro es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- ¿Cuál fue el transporte utilizado la mayor parte del tiempo para desplazarse por el departamento?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>C2.  ¿Cuál fue el transporte utilizado la mayor parte del tiempo para desplazarse por el departamento?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio" ng-repeat="item in transportes" ng-if="item.Id != 9">
                            <label>
                                <input type="radio" name="mover" ng-value="item.id" ng-model="transporte.Mover" ng-required="true"> @{{item.tipos_transporte_con_idiomas[0].nombre}}
                                <i ng-if="item.Id==6" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="left" title="@Resource.AyudaTipoTransporte"
                                   style="text-align:right;">
                                </i>
                            </label>
                            <div class="form-group input-text-radio"  ng-if="item.id==11 && transporte.Mover==11">
                                <label style="padding:0;" for="otroMover" class="sr-only">Ingrese el otro transporte</label>
                                <input type="text" class="input-text-radio form-control" name="otroMover" style="display:inline-block;" id="otroMover" placeholder="Escriba su otra opción" ng-model="transporte.otroMover" ng-required="transporte.Mover==11" />    
                            </div>
                        </div>
                    </div>
                </div>
                <span  ng-show="transForm.$submitted || transForm.mover.$touched">
                    <span class="label label-danger" ng-show="transForm.mover.$error.required">* El campo es requerido.</span>
                    <span class="label label-danger" ng-show="transForm.otroMover.$error.required">* El campo otro es requerido.</span>
                </span>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- Experiencia de viaje-->
                <h3 class="panel-title"><b>C3. Sostenibilidad</b></h3>
            </div>
            <div class="panel-footer"><b>En una escala de 1 a 10, donde 1 es Ninguna dificultad y 10 Mucha dificultad. ¿Qué tanta dificultad tuvo para llegar a Atlántico ?</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" style="overflow-x: auto;">
                        <table  align="center" name="tabla_calificacion" class="table table-striped">
                            
                            <tbody>
                                <tr>
                                    @for ($i = 1; $i <= 10; $i++)
                                        <td>
                                            <div class="radio radio-primary">
                                                <label>
                                                    <input type="radio" name="experiencia_@{{it.Id}}" ng-model="transporte.Calificacion" value="{{$i}}">
                                                    {{$i}}
                                                </label>
                                            </div>
                                        </td>
                                    @endfor
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        
        <div class="row" style="text-align:center">
            <a href="/turismoreceptor/seccionestancia/{{$id}}" class="btn btn-raised btn-default">Anterior</a>
            <input type="submit" class="btn btn-raised btn-success" value="Siguiente" ng-click="guardar()">
        </div>
        <br />
    </form>

    <div class='carga'>

    </div>
</div>

@endsection


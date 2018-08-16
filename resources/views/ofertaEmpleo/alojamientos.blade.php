@extends('layout._ofertaEmpleoLayaout')

@section('title', 'Encuesta de oferta y empleo')
@section('establecimeinto', 'establecimeinto')
@section('app','ng-app="appEncuestaAlojamiento"')
@section('controller','ng-controller="OfertaEmpleoAlojamientoCtrl"')


@section('estilos')
    <style>
        .title-section {
            background-color: #4caf50 !important;
        }
    </style>
    <style>
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
        .checkbox .form-group {
            display: inline-block;
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

@section('content')

<div class="main-page" >
    
    <input type="hidden" id="id" value="{{$id}}" />
    
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>Errores:</b></label>
        <br />
        <div ng-repeat="error in errores" ng-if="error.length>0">
            -@{{error[0]}}
        </div>
    </div>

    <form role="form" name="carForm" novalidate>

        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Selecciones las modalidades de alojamiento que ofrece su establecimiento</b></h3>
            </div>
            <div class="panel-footer"><b>Seleccione la opción</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-md-offset-1 col-md-2">
                        <div class="checkbox" style="display: inline-block; margin-right: 1em" >
                            <label>
                                <input type="checkbox"  ng-model="servicios.habitacion" ng-true-value="true" ng-false-value="false" ng-change="resetDatos(1, servicios.habitacion)" > Habitaciones
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <div class="checkbox" style="display: inline-block; margin-right: 1em">
                            <label>
                                <input type="checkbox"  ng-model="servicios.apartamento" ng-true-value="true" ng-false-value="false" ng-change="resetDatos(2, servicios.apartamento)" > Apartamentos
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <div class="checkbox" style="display: inline-block; margin-right: 1em">
                            <label>
                                <input type="checkbox"  ng-model="servicios.casa" ng-true-value="true" ng-false-value="false" ng-change="resetDatos(3, servicios.casa)" > Casas
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <div class="checkbox" style="display: inline-block; margin-right: 1em">
                            <label>
                                <input type="checkbox"  ng-model="servicios.cabana" ng-true-value="true" ng-false-value="false" ng-change="resetDatos(4, servicios.cabana)" > Cabañas
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <div class="checkbox" style="display: inline-block; margin-right: 1em">
                            <label>
                                <input type="checkbox"  ng-model="servicios.camping" ng-true-value="true" ng-false-value="false" ng-change="resetDatos(5, servicios.camping)" > Camping
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <span ng-show="ErrorServicio && !servicios.habitacion && !servicios.apartamento && !servicios.casa && !servicios.cabana && !servicios.camping">
                            <span class="label label-danger" >* Selecione por lo menos un servicio.</span>
                        </span>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="panel panel-success" ng-if="servicios.habitacion" >
            <div class="panel-heading">
                <h3 class="panel-title"><b> Habitaciones </b></h3>
            </div>
            <div class="panel-footer"><b>Complete la información</b></div>
            <div class="panel-body">
                
                <div class="row">
                    <div class="col-xs-12" style="overflow-x: auto;">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        Total habitaciones (Por favor no incluir habitaciones para el personal de la empresa)
                                        <span ng-show="carForm.$submitted || carForm.totalH.$touched">
                                            <span class="label label-danger" ng-show="carForm.totalH.$error.required">* El número total de habitaciones es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.totalH.$error.number">* El número total de habitaciones debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.totalH.$error.min">* El número total de habitaciones debe ser mayor que 0.</span>
                                        </span>
                                    </td>
                                    <td style="width: 15%;min-width: 50px">
                                        <input type="number" name="totalH" class="form-control" min="0" ng-model="alojamiento.habitaciones[0].total" ng-required="servicios.habitacion" placeholder="Ingrese aquí el número total de habitaciones" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        ¿Cuál es la capacidad máxima de alojamiento en personas? (Por favor no cuente las personas que pueden hospedarse en camas creadas a petición del cliente)
                                        <span ng-show="carForm.$submitted || carForm.capacidadMaxH.$touched">
                                            <span class="label label-danger" ng-show="carForm.capacidadMaxH.$error.required">* La capacidad máxima es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.capacidadMaxH.$error.number">* La capacidad máxima debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.capacidadMaxH.$error.min">* La capacidad máxima debe ser mayor que 0.</span>
                                        </span>
                                    </td>
                                    <td style="width: 15%;min-width: 50px">
                                        <input type="number" name="capacidadMaxH" class="form-control" min="0" ng-model="alojamiento.habitaciones[0].capacidad" ng-required="servicios.habitacion" placeholder="Ingrese aquí la capacidad máxima de alojamiento en personas" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tarifa de habitación doble estándar incluido impuestos ($) en el mes
                                        <span ng-show="carForm.$submitted || carForm.HabitacionTarifa.$touched">
                                            <span class="label label-danger" ng-show="carForm.HabitacionTarifa.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.HabitacionTarifa.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.HabitacionTarifa.$error.min">*El campo debe ser mayor que $1,000.</span>
                                        </span>
                                    </td>
                                    <td><input name="HabitacionTarifa" id="HabitacionTarifa" class="form-control" ng-model="alojamiento.habitaciones[0].tarifa" min="1000"  type="number" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>¿Cuántas personas realizaron Check in o ingresaron durante el mes?
                                        <span ng-show="carForm.$submitted || carForm.HabitacionPersonas.$touched">
                                            <span class="label label-danger" ng-show="carForm.HabitacionPersonas.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.HabitacionPersonas.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.HabitacionPersonas.$error.min">*El campo debe ser mayor que $1,000.</span>
                                        </span>
                                    </td>
                                    <td><input type="number" name="HabitacionPersonas" id="HabitacionPersonas" class="form-control" ng-model="alojamiento.habitaciones[0].numero_personas" min="1" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>¿Cuántos viajeros que ingresaron durante el mes anterior tienen residencia fuera del Cesar? (De otros departamentos de Colombia)
                                        <span ng-show="carForm.$submitted || carForm.HabitacionCol.$touched">
                                            <span class="label label-danger" ng-show="carForm.HabitacionCol.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.HabitacionCol.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.HabitacionCol.$error.max">*Este campo no puede ser mayor al numero de personas que hicieron Check in o ingresaron.</span>
                                        </span>
                                    </td>
                                    <td><input type="number" id="HabitacionCol" name="HabitacionCol" class="form-control" ng-model="alojamiento.habitaciones[0].viajeros_locales" max="@{{alojamiento.habitaciones[0].numero_personas}}" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>¿Cuántas habitaciones se ocuparon durante el mes? (Es la suma de habitaciones vendidas cada noche del mes)
                                        <span ng-show="carForm.$submitted || carForm.HabitacionOcupa.$touched">
                                            <span class="label label-danger" ng-show="carForm.HabitacionOcupa.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.HabitacionOcupa.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.HabitacionOcupa.$error.min">*El campo debe ser mayor que 1</span>
                                        </span>    
                                    </td>
                                    <td><input type="number" name="HabitacionOcupa" id="HabitacionOcupa" class="form-control" ng-model="alojamiento.habitaciones[0].habitaciones_ocupadas" min="1" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>¿Total huéspedes durante noches del mes de anterior? (Es la sumatoria de los huéspedes que se encontraban registrados cada noche del mes)
                                        <span ng-show="carForm.$submitted || carForm.HabitacionTotal.$touched">
                                            <span class="label label-danger" ng-show="carForm.HabitacionTotal.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.HabitacionTotal.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.HabitacionTotal.$error.min">*El campo debe ser mayor que 1</span>
                                        </span>   
                                    </td>
                                    <td><input type="number" name="HabitacionTotal" id="HabitacionTotal" class="form-control" ng-model="alojamiento.habitaciones[0].total_huespedes" min="1" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="panel panel-success" ng-if="servicios.apartamento">
            <div class="panel-heading">
                <h3 class="panel-title"><b> Apartamentos </b></h3>
            </div>
            <div class="panel-footer"><b>Complete la información</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        Total apartamentos (Por favor no incluir apartamentos para el personal de la empresa)
                                        <span ng-show="carForm.$submitted || carForm.numeroApto.$touched">
                                            <span class="label label-danger" ng-show="carForm.numeroApto.$error.required">* El número total de apartamentos es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.numeroApto.$error.number">* El número total de apartamentos debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.numeroApto.$error.min">* El número total de apartamentos debe ser mayor o igual que 1.</span>
                                        </span>
                                    </td>
                                    <td style="width: 15%;min-width: 50px">
                                        <input type="number" name="numeroApto" class="form-control" min="1" ng-model="alojamiento.apartamentos[0].total" ng-required="servicios.apartamento" placeholder="Ingrese aquí el número total de apartamentos" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        ¿Cuál es la capacidad máxima de alojamiento en personas? (Por favor no cuente las personas que pueden hospedarse en camas creadas a petición del cliente)
                                        <span ng-show="carForm.$submitted || carForm.capacidadMaxA.$touched">
                                            <span class="label label-danger" ng-show="carForm.capacidadMaxA.$error.required">* La capacidad máxima es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.capacidadMaxA.$error.number">* La capacidad máxima debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.capacidadMaxA.$error.min">*  La capacidad máxima debe ser mayor o igual que 1.</span>
                                        </span>
                                    </td>
                                    <td style="width: 15%;min-width: 50px">
                                        <input type="number" name="capacidadMaxA" class="form-control" min="1" ng-model="alojamiento.apartamentos[0].capacidad" ng-required="servicios.apartamento" placeholder="Ingrese aquí la capacidad máxima de alojamiento en personas" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        ¿Cuál fue la tarifa de un apartamento de acomodación doble incluido impuesto ($) en el mes?
                                        <span ng-show="carForm.$submitted || carForm.ApartamentosTarifa.$touched">
                                            <span class="label label-danger" ng-show="carForm.ApartamentosTarifa.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.ApartamentosTarifa.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.ApartamentosTarifa.$error.min">*El campo debe ser mayor que $1,000.</span>
                                        </span>
                                    </td>
                                    <td><input name="ApartamentosTarifa" id="ApartamentosTarifa" class="form-control" ng-model="alojamiento.apartamentos[0].tarifa" min="1000" type="number" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>¿Cuántas personas realizaron Check in o ingresaron durante el mes?
                                        <span ng-show="carForm.$submitted || carForm.ApartamentosPersonas.$touched">
                                            <span class="label label-danger" ng-show="carForm.ApartamentosPersonas.$error.required">*El campo es requerido</span>
                                            <span class="label label-danger" ng-show="carForm.ApartamentosPersonas.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.ApartamentosPersonas.$error.min">*El campo debe ser mayor que 1.</span>
                                        </span> 
                                    </td>
                                    <td><input type="number" name="ApartamentosPersonas" id="ApartamentosPersonas" class="form-control" ng-model="alojamiento.apartamentos[0].viajeros" min="1" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>¿Cuántos viajeros que ingresaron durante el mes anterior tienen residencia fuera del Cesar? (De otros departamentos de Colombia)
                                        <span ng-show="carForm.$submitted || carForm.ApartamentosCol.$touched">
                                            <span class="label label-danger" ng-show="carForm.ApartamentosCol.$error.required">*El campo es requerido</span>
                                            <span class="label label-danger" ng-show="carForm.ApartamentosCol.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.ApartamentosCol.$error.max">*Este campo no puede ser mayor al numero de personas que hicieron Check in o ingresaron.</span>
                                        </span>
                                    </td>
                                    <td><input type="number" id="ApartamentosCol" name="ApartamentosCol" class="form-control" ng-model="alojamiento.apartamentos[0].viajeros_colombianos" max="@{{alojamiento.apartamentos[0].viajeros}}" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>¿cuántas apartamentos se ocuparon durante el mes?  (Es la suma de apartamentos vendidos cada noche del mes) Si usted vendió el mismo apartamento por 15 días, entonces, el apartamento fue ocupado 15 veces.
                                        <span ng-show="carForm.$submitted || carForm.ApartamentosCamas.$touched">
                                            <span class="label label-danger" ng-show="carForm.ApartamentosCamas.$error.required">*El campo es requerido</span>
                                            <span class="label label-danger" ng-show="carForm.ApartamentosCamas.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.ApartamentosCamas.$error.min">*El campo debe ser mayor que 1.</span>
                                        </span>    
                                    </td>
                                    <td><input type="number" name="ApartamentosCamas" id="ApartamentosCamas" class="form-control" ng-model="alojamiento.apartamentos[0].capacidad_ocupada" min="1" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>¿Total huéspedes durante noches del mes de anterior? (Es la sumatoria de los huéspedes que se encontraban registrados cada noche del mes)
                                        <span ng-show="carForm.$submitted || carForm.ApartamentosTotal.$touched">
                                            <span class="label label-danger" ng-show="carForm.ApartamentosTotal.$error.required">*El campo es requerido</span>
                                            <span class="label label-danger" ng-show="carForm.ApartamentosTotal.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.ApartamentosTotal.$error.min">*El campo debe ser mayor que 1.</span>
                                        </span>    
                                    </td>
                                    <td><input type="number" name="ApartamentosTotal" id="ApartamentosTotal" class="form-control" ng-model="alojamiento.apartamentos[0].total_huespedes" min="1" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
                
            </div>
        </div>

        <div class="panel panel-success" ng-if="servicios.casa">
            <div class="panel-heading">
                <h3 class="panel-title"><b> Casas </b></h3>
            </div>
            <div class="panel-footer"><b>Complete la información</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12" style="overflow-x: auto;">
                        <table class="table">
                            <tbody>
                               <tr>
                                    <td>
                                        Total casas (Por favor no incluir casas para el personal de la empresa)
                                        <span ng-show="carForm.$submitted || carForm.numeroCasas.$touched">
                                            <span class="label label-danger" ng-show="carForm.numeroCasas.$error.required">* El número total de casas es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.numeroCasas.$error.number">* El número total de casas debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.numeroCasas.$error.min">* El número total de casas debe ser mayor que 0.</span>
                                        </span>
                                    </td>
                                    <td style="width: 15%;min-width: 50px">
                                        <input type="number" name="numeroCasas" class="form-control" min="0" ng-model="alojamiento.casas[0].total" ng-required="servicios.casa" placeholder="Ingrese aquí el número total de casas" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        ¿Cuál es la capacidad máxima de alojamiento en personas? (Por favor no cuente las personas que pueden hospedarse en camas creadas a petición del cliente)
                                        <span ng-show="carForm.$submitted || carForm.capacidadMaxC.$touched">
                                            <span class="label label-danger" ng-show="carForm.capacidadMaxC.$error.required">* La capacidad máxima es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.capacidadMaxC.$error.number">* La capacidad máxima debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.capacidadMaxC.$error.min">* La capacidad máxima debe ser mayor que 0.</span>
                                        </span>
                                    </td>
                                    <td style="width: 15%;min-width: 50px">
                                        <input type="number" name="capacidadMaxC" class="form-control" min="0" ng-model="alojamiento.casas[0].capacidad" ng-required="servicios.casa" placeholder="Ingrese aquí la capacidad máxima de alojamiento en personas" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Número promedio de personas por casa
                                        <span ng-show="carForm.$submitted || carForm.promedioC.$touched">
                                            <span class="label label-danger" ng-show="carForm.promedioC.$error.required">* El número promedio de personas es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.promedioC.$error.number">* El número promedio de personas debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.promedioC.$error.min">* El número promedio de personas debe ser mayor que 0.</span>
                                        </span>
                                    </td>
                                    <td style="width: 15%;min-width: 50px">
                                        <input type="number" name="promedioC" class="form-control" min="0" ng-model="alojamiento.casas[0].promedio" ng-required="servicios.casa" placeholder="Ingrese aquí el número promedio de personas por casa" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tarifa de la casa incluido impuestos ($) en el mes
                                        <span ng-show="carForm.$submitted || carForm.CasaTarifa.$touched">
                                            <span class="label label-danger" ng-show="carForm.CasaTarifa.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.CasaTarifa.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.CasaTarifa.$error.min">*El campo debe ser mayor que $1000.</span>
                                        </span>
                                    </td>
                                    <td><input name="CasaTarifa" id="CasaTarifa" class="form-control" ng-model="alojamiento.casas[0].tarifa" min="1000" type="number" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td> ¿Cuántas personas realizaron Check in o ingresaron durante el mes?
                                        <span ng-show="carForm.$submitted || carForm.CasaPersonas.$touched">
                                            <span class="label label-danger" ng-show="carForm.CasaPersonas.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.CasaPersonas.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.CasaPersonas.$error.min">*El campo debe ser mayor que 1.</span>
                                        </span>
                                    </td>
                                    <td><input type="number" name="CasaPersonas" id="CasaPersonas" class="form-control" ng-model="alojamiento.casas[0].viajeros" min="1" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>¿Cuántos viajeros que ingresaron durante el mes anterior tienen residencia fuera del Cesar? (De otros departamentos de Colombia)
                                        <span ng-show="carForm.$submitted || carForm.CasaCol.$touched">
                                            <span class="label label-danger" ng-show="carForm.CasaCol.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.CasaCol.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.CasaCol.$error.max">*Este campo no puede ser mayor al numero de personas que hicieron Check in o ingresaron.</span>
                                        </span>    
                                    </td>
                                    <td><input type="number" id="CasaCol" name="CasaCol" class="form-control" ng-model="alojamiento.casas[0].viajeros_colombia" max="@{{alojamiento.casas[0].viajeros}}" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>
                                        ¿Cuántas casas se ocuparon durante el mes? (Es la suma de casas vendidas cada noche del mes) Si usted vendió la misma casa por 15 días, entonces, la casa fue ocupada 15 veces.
                                        <span ng-show="carForm.$submitted || carForm.CasaCapacidad.$touched">
                                            <span class="label label-danger" ng-show="carForm.CasaCapacidad.$error.required">*El campo es requerido</span>
                                            <span class="label label-danger" ng-show="carForm.CasaCapacidad.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.CasaCapacidad.$error.min">*El campo debe ser mayor que 1.</span>
                                        </span>
                                    </td>
                                    <td><input type="number" name="CasaCapacidad" id="CasaCapacidad" class="form-control" ng-model="alojamiento.casas[0].capacidad_ocupadas" min="1" ng-required="true" placeholder="Solo números" /></td>
                                </tr>
                                <tr>
                                    <td>¿Total huéspedes durante noches del mes de anterior? (Es la sumatoria de los huéspedes que se encontraban registrados cada noche del mes)
                                        <span ng-show="carForm.$submitted || carForm.CasaTotal.$touched">
                                            <span class="label label-danger" ng-show="carForm.CasaTotal.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.CasaTotal.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.CasaTotal.$error.min">*El campo debe ser mayor que 1.</span>
                                        </span>    
                                    </td>
                                    <td><input type="number" name="CasaTotal" id="CasaTotal" class="form-control" ng-model="alojamiento.casas[0].total_huespedes" min="1" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
                
            </div>
        </div>

        <div class="panel panel-success" ng-if="servicios.cabana">
            <div class="panel-heading">
                <h3 class="panel-title"><b> Cabañas </b></h3>
            </div>
            <div class="panel-footer"><b>Complete la información</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12" style="overflow-x: auto;">
                        <table class="table">
                            <tr>
                                <td>
                                    Total cabañas (Por favor no incluir cabañas para el personal de la empresa)
                                    <span ng-show="carForm.$submitted || carForm.numeroCab.$touched">
                                        <span class="label label-danger" ng-show="carForm.numeroCab.$error.required">* El número promedio de cabañas es requerido.</span>
                                        <span class="label label-danger" ng-show="carForm.numeroCab.$error.number">* El número promedio de cabañas debe ser un número.</span>
                                        <span class="label label-danger" ng-show="carForm.numeroCab.$error.min">* El número promedio de cabañas debe ser mayor que 0.</span>
                                    </span>
                                </td>
                                <td style="width: 15%;min-width: 50px">
                                    <input type="number" name="numeroCab" class="form-control" min="0" ng-model="alojamiento.cabanas[0].total" ng-required="servicios.cabana" placeholder="Ingrese aquí el número total de cabañas" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    ¿Cuál es la capacidad máxima de alojamiento en personas? (Por favor no cuente las personas que pueden hospedarse en camas creadas a petición del cliente)
                                    <span ng-show="carForm.$submitted || carForm.capacidadMaxCb.$touched">
                                        <span class="label label-danger" ng-show="carForm.capacidadMaxCb.$error.required">* La capacidad máxima es requerido.</span>
                                        <span class="label label-danger" ng-show="carForm.capacidadMaxCb.$error.number">* La capacidad máxima debe ser un número.</span>
                                        <span class="label label-danger" ng-show="carForm.capacidadMaxCb.$error.min">* La capacidad máxima debe ser mayor que 0.</span>
                                    </span>
                                </td>
                                <td style="width: 15%;min-width: 50px">
                                    <input type="number" name="capacidadMaxCb" class="form-control" min="0" ng-model="alojamiento.cabanas[0].capacidad" ng-required="servicios.cabana" placeholder="Ingrese aquí la capacidad máxima de alojamiento en personas" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Número promedio de personas por cabaña
                                    <span ng-show="carForm.$submitted || carForm.promedioP.$touched">
                                        <span class="label label-danger" ng-show="carForm.promedioP.$error.required">* El número promedio de personas es requerido.</span>
                                        <span class="label label-danger" ng-show="carForm.promedioP.$error.number">* El número promedio de personas debe ser un número.</span>
                                        <span class="label label-danger" ng-show="carForm.promedioP.$error.min">* El número promedio de personas debe ser mayor que 0.</span>
                                    </span>
                                </td>
                                <td style="width: 15%;min-width: 50px">
                                    <input type="number" name="promedioP" class="form-control" min="0" ng-model="alojamiento.cabanas[0].promedio" ng-required="servicios.cabana" placeholder="Ingrese aquí el número promedio de personas por cabaña" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Tarifa de la cabaña incluido impuestos ($) en el mes
                                    <span ng-show="carForm.$submitted || carForm.CabTarifa.$touched">
                                        <span class="label label-danger" ng-show="carForm.CabTarifa.$error.required">*El campo es requerido.</span>
                                        <span class="label label-danger" ng-show="carForm.CabTarifa.$error.number">*El campo debe ser un número.</span>
                                        <span class="label label-danger" ng-show="carForm.CabTarifa.$error.min">*El campo debe ser mayor que $1,000.</span>
                                    </span>
                                </td>
                                <td><input name="CabTarifa" id="CabTarifa" class="form-control" ng-model="alojamiento.cabanas[0].tarifa" min="1000" type="number" ng-required="true" placeholder="Solo números"/></td>
                            </tr>
                            <tr>
                                <td>¿Cuántas personas realizaron Check in o ingresaron durante el mes?
                                    <span ng-show="carForm.$submitted || carForm.CabPersonas.$touched">
                                        <span class="label label-danger" ng-show="carForm.CabPersonas.$error.required">*El campo es requerido.</span>
                                        <span class="label label-danger" ng-show="carForm.CabPersonas.$error.number">*El campo debe ser un número.</span>
                                        <span class="label label-danger" ng-show="carForm.CabPersonas.$error.min">*El campo debe ser mayor que 1.</span>
                                    </span>    
                                </td>
                                <td><input type="number" name="CabPersonas" id="CabPersonas" class="form-control" ng-model="alojamiento.cabanas[0].viajeros" min="1" ng-required="true" placeholder="Solo números"/></td>
                            </tr>
                            <tr>
                                <td>¿Cuántos viajeros que ingresaron durante el mes anterior tienen residencia fuera del Cesar? (De otros departamentos de Colombia)
                                    <span ng-show="carForm.$submitted || carForm.CabCol.$touched">
                                        <span class="label label-danger" ng-show="carForm.CabCol.$error.required">*El campo es requerido.</span>
                                        <span class="label label-danger" ng-show="carForm.CabCol.$error.number">*El campo debe ser un número.</span>
                                        <span class="label label-danger" ng-show="carForm.CabCol.$error.max">*Este campo no puede ser mayor al numero de personas que hicieron Check in o ingresaron.</span>
                                    </span>
                                </td>
                                <td><input type="number" id="CabCol" name="CabCol" class="form-control" ng-model="alojamiento.cabanas[0].viajeros_colombia" max="@{{alojamiento.cabanas[0].viajeros}}" ng-required="true" placeholder="Solo números"/></td>
                            </tr>
                            <tr>
                                <td>
                                    ¿Cuántas cabañas se ocuparon durante el mes? (Es la suma de cabañas vendidas cada noche del mes) Si usted vendió la misma cabaña por 15 días, entonces, la cabaña fue ocupada 15 veces.
                                    <span ng-show="carForm.$submitted || carForm.CabaniaCapacidad.$touched">
                                        <span class="label label-danger" ng-show="carForm.CabaniaCapacidad.$error.required">*El campo es requerido</span>
                                        <span class="label label-danger" ng-show="carForm.CabaniaCapacidad.$error.number">*El campo debe ser un número.</span>
                                        <span class="label label-danger" ng-show="carForm.CabaniaCapacidad.$error.min">*El campo debe ser mayor que 1.</span>
                                    </span>
                                </td>
                                <td><input type="number" name="CabaniaCapacidad" id="CabaniaCapacidad" class="form-control" ng-model="alojamiento.cabanas[0].capacidad_ocupada" min="1" ng-required="true" placeholder="Solo números" /></td>
                            </tr>
                            <tr>
                                <td>¿Total huéspedes durante noches del mes de anterior? (Es la sumatoria de los huéspedes que se encontraban registrados cada noche del mes)
                                    <span ng-show="carForm.$submitted || carForm.CabTotal.$touched">
                                        <span class="label label-danger" ng-show="carForm.CabTotal.$error.required">*El campo es requerido.</span>
                                        <span class="label label-danger" ng-show="carForm.CabTotal.$error.number">*El campo debe ser un número.</span>
                                        <span class="label label-danger" ng-show="carForm.CabTotal.$error.min">*El campo debe ser mayor que 1.</span>
                                    </span>     
                                </td>
                                <td><input type="number" name="CabTotal" id="CabTotal" class="form-control" ng-model="alojamiento.cabanas[0].total_huespedes" min="1" ng-required="true" placeholder="Solo números"/></td>
                            </tr>
                            
                        </table>
                    </div>
                    
                </div>
                
            </div>
        </div>

        <div class="panel panel-success" ng-if="servicios.camping">
            <div class="panel-heading">
                <h3 class="panel-title"><b> Camping </b></h3>
            </div>
            <div class="panel-footer"><b>Complete la información</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12">
                        <table class="table">
                            <tr>
                                <td>
                                    Área del terreno para Camping? (m2)
                                    <span ng-show="carForm.$submitted || carForm.areaC.$touched">
                                        <span class="label label-danger" ng-show="carForm.areaC.$error.required">* El área es requerido.</span>
                                        <span class="label label-danger" ng-show="carForm.areaC.$error.number">* El área debe ser un número.</span>
                                        <span class="label label-danger" ng-show="carForm.areaC.$error.min">* El área debe ser mayor que 0.</span>
                                    </span>
                                </td>
                                <td style="width: 15%;min-width: 50px">
                                    <input type="number" name="areaC" class="form-control" min="0" ng-model="alojamiento.campings[0].area" ng-required="servicios.camping" placeholder="Ingrese aquí el área del terreno para camping en m2" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Total parcelas (N° espacios para carpas)
                                    <span ng-show="carForm.$submitted || carForm.totalP.$touched">
                                        <span class="label label-danger" ng-show="carForm.totalP.$error.required">* El número total de parcelas es requerido.</span>
                                        <span class="label label-danger" ng-show="carForm.totalP.$error.number">* El número total de parcelas debe ser un número.</span>
                                        <span class="label label-danger" ng-show="carForm.totalP.$error.min">* El número total de parcelas debe ser mayor que 0.</span>
                                    </span>
                                </td>
                                <td style="width: 15%;min-width: 50px">
                                    <input type="number" name="totalP" class="form-control" min="0" ng-model="alojamiento.campings[0].total_parcelas" ng-required="servicios.camping" placeholder="Ingrese aquí el número total de parcelas" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Capacidad en número de personas
                                    <span ng-show="carForm.$submitted || carForm.capacidadMaxCg.$touched">
                                        <span class="label label-danger" ng-show="carForm.capacidadMaxCg.$error.required">* La capacidad máxima es requerido.</span>
                                        <span class="label label-danger" ng-show="carForm.capacidadMaxCg.$error.number">* La capacidad máxima debe ser un número.</span>
                                        <span class="label label-danger" ng-show="carForm.capacidadMaxCg.$error.min">* La capacidad máxima debe ser mayor que 0.</span>
                                    </span>
                                </td>
                                <td style="width: 15%;min-width: 50px">
                                    <input type="number" name="capacidadMaxCg" class="form-control" min="0" ng-model="alojamiento.campings[0].capacidad" ng-required="servicios.camping" placeholder="Ingrese aquí la capacidad en número de personas" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Tarifa del camping incluido impuestos ($) en el mes
                                    <span ng-show="carForm.$submitted || carForm.CamTarifa.$touched">
                                        <span class="label label-danger" ng-show="carForm.CamTarifa.$error.required">*El campo es requerido.</span>
                                        <span class="label label-danger" ng-show="carForm.CamTarifa.$error.number">*El campo debe ser un número.</span>
                                        <span class="label label-danger" ng-show="carForm.CamTarifa.$error.min">*El campo debe ser mayor que $1,000.</span>
                                    </span>
                                </td>
                                <td><input name="CamTarifa" id="CamTarifa" class="form-control" ng-model="alojamiento.campings[0].tarifa" min="1000" type="number" ng-required="true" placeholder="Solo números"/></td>
                            </tr>
                            <tr>
                                <td>¿Cuántos viajeros se hospedaron durante el mes?
                                    <span ng-show="carForm.$submitted || carForm.CamPersonas.$touched">
                                        <span class="label label-danger" ng-show="carForm.CamPersonas.$error.required">*El campo es requerido.</span>
                                        <span class="label label-danger" ng-show="carForm.CamPersonas.$error.number">*El campo debe ser un número.</span>
                                        <span class="label label-danger" ng-show="carForm.CamPersonas.$error.min">*El campo debe ser mayor que 1.</span>
                                    </span>
                                </td>
                                <td><input type="number" name="CamPersonas" id="CamPersonas" class="form-control" ng-model="alojamiento.campings[0].viajeros" min="1" ng-required="true" placeholder="Solo números"/></td>
                            </tr>
                            <tr>
                                <td>¿Cuántos viajeros que ingresaron durante el mes de junio tienen residencia fuera del Cesar? 
                                    <span ng-show="carForm.$submitted || carForm.CamExtra.$touched">
                                        <span class="label label-danger" ng-show="carForm.CamExtra.$error.required">*El campo es requerido.</span>
                                        <span class="label label-danger" ng-show="carForm.CamExtra.$error.number">*El campo debe ser un número.</span>
                                        <span class="label label-danger" ng-show="carForm.CamExtra.$error.max">*Este campo no puede ser mayor al numero de viajeros que se hospedaron.</span>
                                    </span>
                                </td>
                                <td><input type="number" id="CamExtra" name="CamExtra" class="form-control" ng-model="alojamiento.campings[0].viajeros_extranjeros" max="@{{alojamiento.campings[0].viajeros}}" ng-required="true" placeholder="Solo números"/></td>
                            </tr>
                            <tr>
                                <td>
                                    ¿Cuántas parcelas (N° de espacios para carpas-casas rodantes) se ocuparon durante el mes? (Es la suma de espacios vendidos cada noche del mes) Si usted vendió solo un espacio por 15 días, 
                                    <span ng-show="carForm.$submitted || carForm.CampingCapacidad.$touched">
                                        <span class="label label-danger" ng-show="carForm.CampingCapacidad.$error.required">*El campo es requerido</span>
                                        <span class="label label-danger" ng-show="carForm.CampingCapacidad.$error.number">*El campo debe ser un número.</span>
                                        <span class="label label-danger" ng-show="carForm.CampingCapacidad.$error.min">*El campo debe ser mayor que 1.</span>
                                    </span>
                                </td>
                                <td><input type="number" name="CampingCapacidad" id="CampingCapacidad" class="form-control" ng-model="alojamiento.campings[0].capacidad_ocupada" min="1" ng-required="true" placeholder="Solo números" /></td>
                            </tr>
                            <tr>
                                <td>¿Total huéspedes durante noches del mes de anterior? (Es la sumatoria de los huéspedes que se encontraban registrados cada noche del mes)
                                    <span ng-show="carForm.$submitted || carForm.CamTotal.$touched">
                                        <span class="label label-danger" ng-show="carForm.CamTotal.$error.required">*El campo es requerido.</span>
                                        <span class="label label-danger" ng-show="carForm.CamTotal.$error.number">*El campo debe ser un número.</span>
                                        <span class="label label-danger" ng-show="carForm.CamTotal.$error.min">*El campo debe ser mayor que 1.</span>
                                    </span>    
                                </td>
                                <td><input type="number" name="CamTotal" id="CamTotal" class="form-control" ng-model="alojamiento.campings[0].total_huespedes" min="1" ng-required="true" placeholder="Solo números"/></td>
                            </tr>
                        </table>
                    </div>

                    
                </div>
                
            </div>
        </div>

        <div class="row" style="text-align:center">
            <input type="submit" ng-click="guardar()" class="btn btn-raised btn-success" value="Siguiente" />
        </div>
    </form>

    <div class='carga'></div>
    
</div>

@endsection


@section('javascript')
    <script src="{{asset('/js/encuestas/ofertaempleo/alojamiento.js')}}"></script>
    <script src="{{asset('/js/encuestas/ofertaempleo/servicios.js')}}"></script>
@endsection
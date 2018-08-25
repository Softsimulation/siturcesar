@extends('layout._ofertaEmpleoLayaout')

@section('title', 'Encuesta de oferta y empleo')
@section('establecimeinto', 'establecimeinto')
@section('app','ng-app="appEncuestaAlojamiento"')
@section('controller','ng-controller="AlojamientoMensualCtrl"')


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
                                    <td>¿Cuántas habitaciones se ocuparon durante el mes? (Es la suma de habitaciones vendidas cada noche del mes)
                                        <span ng-show="carForm.$submitted || carForm.HabitacionOcupa.$touched">
                                            <span class="label label-danger" ng-show="carForm.HabitacionOcupa.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.HabitacionOcupa.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.HabitacionOcupa.$error.min">*El campo debe ser mayor que 1</span>
                                            <span class="label label-danger" ng-show="carForm.HabitacionOcupa.$error.max">*Este campo no puede ser mayor al número total de habitaciones por el número de días de actividad comercial.</span>
                                        </span>    
                                    </td>
                                    <td><input type="number" name="HabitacionOcupa" id="HabitacionOcupa" class="form-control" ng-model="alojamiento.habitaciones[0].habitaciones_ocupadas" min="1" max="@{{alojamiento.habitaciones[0].total*numero_dias}}" ng-required="true" placeholder="Solo números"/></td>
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
                                    <td>¿cuántas apartamentos se ocuparon durante el mes?  (Es la suma de apartamentos vendidos cada noche del mes) Si usted vendió el mismo apartamento por 15 días, entonces, el apartamento fue ocupado 15 veces.
                                        <span ng-show="carForm.$submitted || carForm.ApartamentosCamas.$touched">
                                            <span class="label label-danger" ng-show="carForm.ApartamentosCamas.$error.required">*El campo es requerido</span>
                                            <span class="label label-danger" ng-show="carForm.ApartamentosCamas.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.ApartamentosCamas.$error.min">*El campo debe ser mayor que 1.</span>
                                            <span class="label label-danger" ng-show="carForm.ApartamentosCamas.$error.max">*Este campo no puede ser mayor al número total de apartamentos por el número de días de actividad comercial.</span>
                                        </span>    
                                    </td>
                                    <td><input type="number" name="ApartamentosCamas" id="ApartamentosCamas" class="form-control" ng-model="alojamiento.apartamentos[0].capacidad_ocupada" min="1" max="@{{alojamiento.apartamentos[0].total*numero_dias}}" ng-required="true" placeholder="Solo números"/></td>
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
                                        ¿Cuántas casas se ocuparon durante el mes? (Es la suma de casas vendidas cada noche del mes) Si usted vendió la misma casa por 15 días, entonces, la casa fue ocupada 15 veces.
                                        <span ng-show="carForm.$submitted || carForm.CasaCapacidad.$touched">
                                            <span class="label label-danger" ng-show="carForm.CasaCapacidad.$error.required">*El campo es requerido</span>
                                            <span class="label label-danger" ng-show="carForm.CasaCapacidad.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.CasaCapacidad.$error.min">*El campo debe ser mayor que 1.</span>
                                            <span class="label label-danger" ng-show="carForm.CasaCapacidad.$error.max">*Este campo no puede ser mayor al número total de casas por el número de días de actividad comercial.</span>
                                        </span>
                                    </td>
                                    <td><input type="number" name="CasaCapacidad" id="CasaCapacidad" class="form-control" ng-model="alojamiento.casas[0].capacidad_ocupadas" min="1" max="@{{alojamiento.casas[0].total*numero_dias}}" ng-required="true" placeholder="Solo números" /></td>
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
                                    ¿Cuántas cabañas se ocuparon durante el mes? (Es la suma de cabañas vendidas cada noche del mes) Si usted vendió la misma cabaña por 15 días, entonces, la cabaña fue ocupada 15 veces.
                                    <span ng-show="carForm.$submitted || carForm.CabaniaCapacidad.$touched">
                                        <span class="label label-danger" ng-show="carForm.CabaniaCapacidad.$error.required">*El campo es requerido</span>
                                        <span class="label label-danger" ng-show="carForm.CabaniaCapacidad.$error.number">*El campo debe ser un número.</span>
                                        <span class="label label-danger" ng-show="carForm.CabaniaCapacidad.$error.min">*El campo debe ser mayor que 1.</span>
                                        <span class="label label-danger" ng-show="carForm.CabaniaCapacidad.$error.max">*Este campo no puede ser mayor al número total de cabañas por el número de días de actividad comercial.</span>
                                    </span>
                                </td>
                                <td><input type="number" name="CabaniaCapacidad" id="CabaniaCapacidad" class="form-control" ng-model="alojamiento.cabanas[0].capacidad_ocupada" min="1" max="@{{alojamiento.cabanas[0].total*numero_dias}}" ng-required="true" placeholder="Solo números" /></td>
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
                                    ¿Cuántas parcelas (N° de espacios para carpas-casas rodantes) se ocuparon durante el mes? (Es la suma de espacios vendidos cada noche del mes) Si usted vendió solo un espacio por 15 días, 
                                    <span ng-show="carForm.$submitted || carForm.CampingCapacidad.$touched">
                                        <span class="label label-danger" ng-show="carForm.CampingCapacidad.$error.required">*El campo es requerido</span>
                                        <span class="label label-danger" ng-show="carForm.CampingCapacidad.$error.number">*El campo debe ser un número.</span>
                                        <span class="label label-danger" ng-show="carForm.CampingCapacidad.$error.min">*El campo debe ser mayor que 1.</span>
                                        <span class="label label-danger" ng-show="carForm.CampingCapacidad.$error.max">*Este campo no puede ser mayor al número total de parcelas por el número de días de actividad comercial.</span>
                                    </span>
                                </td>
                                <td><input type="number" name="CampingCapacidad" id="CampingCapacidad" class="form-control" ng-model="alojamiento.campings[0].capacidad_ocupada" min="1" max="@{{alojamiento.campings[0].area*numero_dias}}" ng-required="true" placeholder="Solo números" /></td>
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
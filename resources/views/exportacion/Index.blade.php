@extends('layout._AdminLayout')

@section('Title','Administrador de Exportaciones :: SITUR Atlántico')
@section('app','ng-app="admin.exportaciones"')
@section ('estilos')
    <style>
        .image-preview-input {
            position: relative;
            overflow: hidden;
            margin: 0px;
            color: #333;
            background-color: #fff;
            border-color: #ccc;
        }

        .image-preview-input input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
        }

        .image-preview-input-title {
            margin-left: 2px;
        }

        .messages {
            color: #FA787E;
        }

        
    </style>
@endsection
@section('controller','ng-controller="ExportacionCtrl"')
@section('titulo','Exportación')
@section('subtitulo','')
@section('content')
    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        
        <div class="row">
            <div class="col-xs-12 text-center">
                <input type="button" ng-click="exportar()" class="btn btn-lg btn-success" value="Generar exportación" />
            </div>
        </div>
        <!--
        <div class="row">
            <div class="col-xs-12" style="overflow-x: auto;">
                <table class="table table-hover" ng-show="exportaciones.length > 0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha de realización</th>
                            <th>Fecha inicio</th>
                            <th>Fecha fin</th>
                            <th>Periodo</th>
                            <th>Estado</th>
                            <th>Usuario</th>
                            <th>Descargar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr dir-paginate="item in exportaciones | itemsPerPage: 10">
                            <td>@{{item.nombre}}</td>
                            <td>@{{item.fecha_realizacion}}</td>
                            <td>@{{item.fecha_inicio |date: "dd/MM/yyyy"}}</td>
                            <td>@{{item.fecha_fin |date: "dd/MM/yyyy"}}</td>
                            <td>@{{item.periodo}}</td>
                            <td>@{{item.estado}}</td>
                            <td>@{{item.usuario_realizado}}</td>
                            <td>@{{item.ruta}}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="alert alert-warning" role="alert" ng-if="exportaciones.length == 0">
                    No hay exportaciones
                </div>
            </div>

            <div class="col-xs-12" style="text-align: center;">
                <dir-pagination-controls></dir-pagination-controls>
            </div>
        </div>
        -->
    </div>

    <!-- Modal crear exportacion-->
    <div class="modal fade" id="exportacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Generar exportación</h4>
                </div>
                <form role="form" name="addForm" novalidate>
                        <div class="modal-body">
                            <div class="alert alert-danger" ng-if="errores != null">
                                <p ng-repeat="error in errores" >
                                    -@{{error[0]}}
                                </p>
                            </div>
                
                        <div class="row">
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="inputNombre"><span style="color:red;">*</span> Exportacion a realizar</label>
                                    <select name="nombre" class="form-control" ng-model="exportacion.nombre" required>
                                        <option value="" disabled>--Seleccione--</option>
                                        <option value="receptor">Turismo Receptor</option>
                                        <option value="interno">Turismo Interno</option>
                                    </select>
                                    <span class="messages" ng-show="addForm.$submitted || addForm.nombre.$touched">
                                        <span ng-show="addForm.nombre.$error.required">* El campo es requerido.</span>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-xs-12 col-sm-12">
                                <div class="form-group">
                                    
                                        <label class="control-label" for="inputNombre"><span style="color:red;">*</span>Fecha inicial</label>
                                        <adm-dtp name="fechainicio" id="fechaAplicacion" ng-model="exportacion.fecha_inicial" maxdate="'{{\Carbon\Carbon::now()->format('Y-m-d')}}'" options="optionFecha" ng-required ="true"></adm-dtp>
                                        <span class="messages" ng-show="addForm.$submitted || addForm.fechainicio.$touched">
                                            <span ng-show="addForm.fechainicio.$error.required">* El campo es requerido.</span>
                                        </span>
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-12 col-sm-12">
                                <div class="form-group">
                                   
                                        <label class="control-label" for="inputNombre"><span style="color:red;">*</span>Fecha final</label>
                                        <adm-dtp name="fechafin" id="fechaAplicacion" ng-model="exportacion.fecha_final" maxdate="'{{\Carbon\Carbon::now()->format('Y-m-d')}}'" options="optionFecha" ng-required="true" ></adm-dtp>
                                        <span class="messages" ng-show="addForm.$submitted || addForm.fechafin.$touched">
                                            <span ng-show="addForm.fechafin.$error.required">* El campo es requerido.</span>
                                        </span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" ng-click="guardar()" class="btn btn-success">Guardar</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

@endsection
@section('javascript')
<script src="{{asset('/js/ADM-dateTimePicker.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/administrador/exportacion/services.js')}}"></script>
<script src="{{asset('/js/administrador/exportacion/exportaciones.js')}}"></script>
@endsection
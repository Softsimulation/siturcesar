
@extends('layout._AdminLayout')

@section('title', 'Encuestas oferta y empleo')

@section('estilos')
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

@section('TitleSection', 'Listado encuestas oferta y empleo')

@section('app','ng-app="proveedoresoferta"')

@section('controller','ng-controller="listadoecuesta"')

@section('titulo','Encuestas')
@section('subtitulo','El siguiente listado cuenta con @{{encuestas.length}} registro(s)')

@section('content')

 <input type="hidden" ng-model="id" ng-init="id={{$id}}" />

<div class="alert alert-danger" ng-if="errores != null">
    <label><b>Errores:</b></label>
    <br />
    <div ng-repeat="error in errores" ng-if="error.length>0">
        -@{{error[0]}}
    </div>

</div>    
<div class="flex-list">
    <div class="form-group has-feedback" style="display: inline-block;">
        <label class="sr-only">Búsqueda de encuestas</label>
        <input type="text" ng-model="prop.searchAntiguo" class="form-control input-lg" id="inputEmail3" placeholder="Buscar encuesta...">
        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
    </div>      
</div>
<div class="text-center" ng-if="(encuestas|filter:prop.searchAntiguo).length > 0 && (prop.searchAntiguo != '' && prop.searchAntiguo != undefined)">
    <p>Hay @{{(encuestas|filter:prop.searchAntiguo).length}} registro(s) que coinciden con su búsqueda</p>
</div>
<div class="alert alert-info" ng-if="encuestas.length == 0">
    <p>No hay registros almacenados</p>
</div>
<div class="alert alert-warning" ng-if="(encuestas|filter:prop.searchAntiguo).length == 0 && encuestas.length > 0">
    <p>No existen registros que coincidan con su búsqueda</p>
</div>


            <div class="row" ng-show="(encuestas|filter:prop.searchAntiguo).length > 0 && encuestas.length > 0">
                <div class="col-xs-12">
                    <table class="table table-striped">
                  <thead>
                        <tr>
                            <th>Id</th>
                            <th>Mes</th>
                            <th>Año</th>
                            <th>Estado</th>
                            <th style="width: 90px;"></th>
                        </tr>
                    </thead>
                     <tbody>
                        <tr dir-paginate="item in encuestas|filter:prop.searchAntiguo|itemsPerPage:10 as results" pagination-id="paginacion_antiguos" >
                            <td>@{{item.id}}</td>
                            <td>@{{item.mes}}</td>
                            <td>@{{item.anio}}</td>
                            <td>@{{item.estado}}</td>
                            <td>
                                <a ng-if="((item.estado!='Cerrada' || item.estado!='Cerrada Calculada' || item.estado!='Cerrada sin calcular')&& item.actividad ==1 )" href="@{{ruta}}/@{{item.id}}" class="btn btn-default btn-xs" title="Editar encuesta oferta" ng-if="(item.estado_id != 7 || item.estado_id != 8 || item.estado_id != 4)&& item.actividad==1"><span class="glyphicon glyphicon-edit"></span></a>
                                <a ng-if="((item.estado!='Cerrada' || item.estado!='Cerrada Calculada' || item.estado!='Cerrada sin calcular')&& item.actividad == 1 )" href="/ofertaempleo/empleomensual/@{{item.id}}" class="btn btn-default btn-xs" title="Editar encuesta empleo" ng-if="(item.estado_id != 7 || item.estado_id != 8 || item.estado_id != 4)&& item.actividad==1"><span class="glyphicon glyphicon-pencil"></span></a>  </td>
                            </tr>
                    </tbody>
                    </table>
                    
                </div>
            </div>
            <div class="row">
              <div class="col-xs-12 text-center">
              <dir-pagination-controls pagination-id="paginacion_antiguos"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
              </div>
            </div>
    <div class='carga'>
    </div>

@endsection


@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
<script src="{{asset('/js/plugins/angular-sanitize.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/plugins/select.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/encuestas/ofertaempleo/proveedoresapp.js')}}"></script>
<script src="{{asset('/js/encuestas/ofertaempleo/servicesproveedor.js')}}"></script>
        
@endsection
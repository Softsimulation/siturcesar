
@extends('layout._AdminLayout')

@section('title', 'Listado de encuestas')

@section('estilos')
    
@endsection

@section('TitleSection', 'Listado encuestas')
@section('app','ng-app="receptor"')

@section('controller','ng-controller="listadoEncuestasCtrl"')

@section('titulo','Encuestas')
@section('subtitulo','El siguiente listado cuenta con @{{encuestas.length}} registro(s)')

@section('content')
<div class="flex-list">
    <a href="/turismoreceptor/datosencuestados" class="btn btn-lg btn-success" role="button">
      Crear encuesta
    </a> 
    
    <div class="form-group has-feedback" style="display: inline-block;">
        <label class="sr-only">Búsqueda de encuesta </label>
        <input type="text" ng-model="prop.search" class="form-control input-lg" id="inputEmail3" placeholder="@{{(campoSelected != undefined && campoSelected != '') ? 'YYYY-MM-DD' : 'Buscar encuesta...'}}">
        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
    </div> 
    <button type="button" class="btn btn-lg btn-default" data-toggle="collapse" data-target="#filtrosEncuestas" aria-expanded="false" aria-controls="filtrosEncuestas" title="Filtros de búsqueda">
        <span class="glyphicon glyphicon-filter" aria-hidden="true"></span><span class="sr-only">Filtros de búsqueda</span>
    </button>
</div>
<div class="flex-list">
    <p> Fecha inicial
        <adm-dtp name="fecha_inicial" id="fecha_inicial" ng-model='fecha_inicial'  maxdate="'@{{fecha_final}}'"
                                             options="optionFecha" ng-required="true"></adm-dtp>
    </p>
    <p> Fecha final
        <adm-dtp name="fecha_final" id="fecha_final" ng-model='fecha_final' mindate="'@{{fecha_inicial}}'"
                                             options="optionFecha" ng-required="true"></adm-dtp>
    </p>
    <button type="button" class="btn btn-info" ng-click="buscarEncuestasPorRango()">Buscar</button>
    <button type="button" class="btn btn-info" ng-click="refrescar()">Refrescar</button>
</div>
<div class="collapse" id="filtrosEncuestas">
  <div class="well">
    <div class="flex-list">
        <div class="form-group" style="display: inline-block;">
            <label class="sr-only" for="tipoEncuesta">Tipo de encuesta</label>
            <select class="form-control input-lg" id="tipoEncuesta" ng-model="filtroEstadoEncuesta" ng-init="filtroEstadoEncuesta = ''">
                <option value="" selected>Todas las encuestas</option>
                <option value="calculadas">Calculadas</option>
                <option value="sincalcular">Sin calcular</option>
            </select>
        </div>
        <div class="form-group" style="display: inline-block;">
            <label class="sr-only" for="campoDeBusqueda">Campo de búsqueda</label>
            <select class="form-control input-lg" id="campoDeBusqueda" ng-model="campoSelected">
                <option value="" selected>Cualquier campo</option>
                <option value="fecha">Fecha de aplicación</option>
                <option value="fechallegada">Fecha de llegada</option>
            </select>
        </div>
    </div>
  </div>
</div>
<div class="text-center" ng-if="(encuestas|filter:filtrarEncuesta|filter:filtrarCampo|filter:prop.search).length > 0 && (prop.search != '' && prop.search != undefined)">
    <p>Hay @{{(encuestas|filter:filtrarEncuesta|filter:filtrarCampo|filter:prop.search).length}} registro(s) que coinciden con su búsqueda</p>
</div>
<div class="alert alert-info" ng-if="encuestas.length == 0">
    <p>No hay registros almacenados</p>
</div>
<div class="alert alert-warning" ng-if="(encuestas|filter:filtrarEncuesta|filter:filtrarCampo|filter:prop.search).length == 0 && encuestas.length > 0">
    <p>No existen registros que coincidan con su búsqueda</p>
</div>

        <div class="row"  ng-show="encuestas.length > 0 && (encuestas|filter:filtrarEncuesta|filter:filtrarCampo|filter:prop.search).length > 0">
            <div class="col-xs-12">
                <table class="table table-striped">
                    <tr>
                         
                            <th>Cód. de encuesta</th>
                            <th>ID de encuesta</th>
                            <th style="width: 120px;">Fecha de digitación</th>
                            <th style="width: 120px;">Fecha de llegada</th>
                            <th style="width: 120px;">Fecha de salida</th>
                            <th>Encuestador</th>
                            <th style="width: 150px;">Estado</th>
                            <th style="width: 110px;">Última sección</th>
                            <th style="width: 170px;"></th>
                        
                    </tr>
                    <tr dir-paginate="item in encuestas|filter:filtrarEncuesta|filter:filtrarCampo|filter:prop.search |itemsPerPage:10 as results" pagination-id="paginacion_encuestas" >
                        
                            <td>@{{item.codigoencuesta}}</td>
                            <td>@{{item.codigogrupo}}</td>
                            <td>@{{item.fechadigitacion | date:'dd/MM/yyyy'}}</td>
                            <td>@{{item.fechallegada | date:'dd/MM/yyyy'}}</td>
                            <td>@{{item.fechasalida | date:'dd/MM/yyyy'}}</td>
                            <td>@{{item.username}}</td>
                            <td>@{{item.estado}}</td>
                            <td style="text-align: center;">@{{item.ultima}}</td>
                            <td style="text-align: center;">
                                <div class="dropdown" style="display: inline-block;">
                                  <button  id="dLabel" type="button" class="btn btn-xs btn-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Ir a
                                    <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu" aria-labelledby="dLabel">
                                    <li><a href="/turismoreceptor/seccionestancia/@{{item.id}}">Estancia y visitados</a></li>
                                    <li><a href="/turismoreceptor/secciontransporte/@{{item.id}}">Transporte</a></li>
                                    <li><a href="/turismoreceptor/secciongrupoviaje/@{{item.id}}">Viaje en grupo</a></li>
                                    <li><a href="/turismoreceptor/secciongastos/@{{item.id}}">Gastos</a></li>
                                    <li><a href="/turismoreceptor/seccionpercepcionviaje/@{{item.id}}">Percepcción del viaje</a></li>
                                    <li><a href="/turismoreceptor/seccionfuentesinformacion/@{{item.id}}">Fuentes de información</a></li>
                                  </ul>
                                </div>
                                <button  id="dLabel" type="button" class="btn btn-xs btn-default" title="Eliminar encuesta" ng-click="eliminarEncuesta(item)">
                                    <span class="glyphicon glyphicon-trash"></span><span class="sr-only">Eliminar</span>
                                </button>
                                <a class="btn btn-xs btn-link" href="/turismoreceptor/editardatos/@{{item.id}}" title="Editar encuesta" ng-if="item.EstadoId != 7 && item.EstadoId != 8"><span class="glyphicon glyphicon-pencil"></span></a>
                            </td>
                    </tr>
                </table>
                
            </div>
            
        </div>
        <div class="row">
          <div class="col-xs-12 text-center">
          <dir-pagination-controls pagination-id="paginacion_encuestas"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
          </div>
        </div>
    <div class='carga'>

    </div>

@endsection

@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
<script src="{{asset('/js/administrador/listadoreceptor/services.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/administrador/listadoreceptor/listadoreceptor.js')}}" type="text/javascript"></script>
@endsection


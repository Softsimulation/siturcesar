
@extends('layout._AdminLayout')

@section('title', 'Proveedores oferta y empleo')

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

@section('TitleSection', 'Listado proveedores oferta y empleo')

@section('app','ng-app="proveedoresoferta"')

@section('controller','ng-controller="listado"')

@section('titulo','Proveedores')
@section('subtitulo','El siguiente listado cuenta con @{{proveedores.length}} registro(s)')

@section('content')
<div class="flex-list">
     
    <div class="form-group has-feedback" style="display: inline-block;">
        <label class="sr-only">Búsqueda de proveedor</label>
        <input type="text" ng-model="prop.searchAntiguo" class="form-control input-lg" id="inputEmail3" placeholder="Buscar proveedor...">
        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
    </div>      
</div>
<div class="text-center" ng-if="(proveedores|filter:prop.searchAntiguo).length > 0 && (prop.searchAntiguo != '' && prop.searchAntiguo != undefined)">
    <p>Hay @{{(proveedores|filter:prop.searchAntiguo).length}} registro(s) que coinciden con su búsqueda</p>
</div>
<div class="alert alert-info" ng-if="proveedores.length == 0">
    <p>No hay registros almacenados</p>
</div>
<div class="alert alert-warning" ng-if="(proveedores|filter:prop.searchAntiguo).length == 0 && proveedores.length > 0">
    <p>No existen registros que coincidan con su búsqueda</p>
</div>

<div class="alert alert-danger" ng-if="errores != null">
    <label><b>Errores:</b></label>
    <br />
    <div ng-repeat="error in errores" ng-if="error.length>0">
        -@{{error[0]}}
    </div>

</div>    

            <div class="row" ng-show="(proveedores|filter:prop.searchAntiguo).length > 0 && proveedores.length > 0">
                <div class="col-xs-12">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th style="width: 50px;"></th>                           
                            <th>No. de RNT</th>
                            <th>Nombre comercial</th>
                            <th>Categoría</th>
                            <th>Tipo</th>
                            <th>Contacto</th>
  
                            <th style="width: 90px;"></th>
                        </tr>
                        </thead>
                         <tbody>
                        <tr dir-paginate="item in proveedores|filter:prop.searchAntiguo|itemsPerPage:10 as results" pagination-id="paginacion_antiguos" >
                                <td>@{{$index+1}}</td>
                                <td>@{{item.rnt}}</td>
                                <td>@{{item.razon_social}}</td>
                                <td>@{{item.subcategoria}}</td>
                                <td>@{{item.categoria}}</td>
                                <td>@{{item.email}}</td>
                      
                                <td style="text-align: center;">
                                <a href="/ofertaempleo/encuesta/@{{item.id}}" class="btn btn-default btn-xs" title="Encuesta sin realizar" role="button"><span class = "ionicons ion-document"></span><span class="sr-only">Encuestas sin realizar</span></a>
                                <a href="/ofertaempleo/encuestas/@{{item.id}}" class="btn btn-default btn-xs" title="Encuesta realizadas" role="button"><span class="ionicons ion-clipboard"></span><span class="sr-only">Encuestas realizadas</span></a>
                                
                                </td>
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

@extends('layout._AdminLayout')

@section('title', 'Listado de actividades')


@section('TitleSection', 'Listado de actividades')

@section('app', 'ng-app="actividadesApp"')

@section('controller','ng-controller="actividadesIndexController"')
@section('titulo','Actividades')
@section('subtitulo','El siguiente listado cuenta con @{{actividades.length}} registro(s)')
@section('content')
<div class="flex-list">
    <a href="/administradoractividades/crear" type="button" class="btn btn-lg btn-success">
      Agregar actividad
    </a> 
    <div class="form-group has-feedback" style="display: inline-block;">
        <label class="sr-only">Búsqueda de proveedor</label>
        <input type="text" ng-model="prop.search" class="form-control input-lg" id="inputEmail3" placeholder="Buscar actividad...">
        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
    </div>      
</div>
<div class="text-center" ng-if="(actividades | filter:prop.search).length > 0 && (prop.search != '' && prop.search != undefined)">
    <p>Hay @{{(actividades | filter:prop.search).length}} registro(s) que coinciden con su búsqueda</p>
</div>
<div class="alert alert-info" ng-if="actividades.length == 0">
    <p>No hay registros almacenados</p>
</div>
<div class="alert alert-warning" ng-if="(actividades | filter:prop.search).length == 0 && actividades.length > 0">
    <p>No existen registros que coincidan con su búsqueda</p>
</div>
<div class="tiles">
    <div class="tile inline-tile" dir-paginate="actividad in actividades | filter:prop.search | itemsPerPage:10" pagination-id="pagination_actividades">
        <div class="tile-img">
            <img ng-src="@{{actividad.multimedias_actividades.length > 0 ?  actividad.multimedias_actividades[0].ruta : 'img/app/noimage.jpg'}}" alt="@{{actividad.proveedor_rnt.razon_social}}"/>
        </div>
        <div class="tile-body">
            <div class="tile-caption">
                <h3>@{{actividad.actividades_con_idiomas[0].nombre}}</h3>
            </div>
            <p>@{{actividad.actividades_con_idiomas[0].descripcion | limitTo: 255}}<span ng-if="actividad.actividades_con_idiomas[0].descripcion.length > 255">...</span></p>
            <div class="inline-buttons">
                <a href="/administradoractividades/editar/@{{actividad.id}}" class="btn btn-warning">Editar</a>
                <button class="btn btn-@{{actividad.estado ? 'danger' : 'success'}}" ng-click="desactivarActivar(actividad)">@{{actividad.estado ? 'Desactivar' : 'Activar'}}</button>
                <button title="@{{actividad.sugerido ? 'No sugerir' : 'Sugerir'}}" class="btn btn-info" ng-click="sugerir(actividad)"><span class="glyphicon glyphicon-@{{actividad.sugerido ? 'star' : 'star-empty'}}"></span></button>
                <a href="/administradoractividades/idioma/@{{actividad.id}}/@{{traduccion.idioma.id}}" ng-repeat="traduccion in actividad.actividades_con_idiomas" class="btn btn-default"> @{{traduccion.idioma.culture}}</a>
                <button type="button" class="btn btn-default" ng-click="modalIdioma(actividad)" ng-if="actividad.actividades_con_idiomas.length < idiomas.length" title="Agregar idioma"> <span class="glyphicon glyphicon-plus"></span><span class="sr-only">Agregar idioma</span></button>
            </div>  
            
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12" style="text-align:center;">
        <dir-pagination-controls pagination-id="pagination_actividades"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
    </div>
</div>
<div class='carga'>

</div>
<div class="modal fade" tabindex="-1" role="dialog" id="idiomaModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nuevo idioma para la actividad</h4>
            </div>
                
            <form>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="idioma">Seleccione un idioma</label>
                        <select ng-model="idiomaEditSelected" ng-options="idioma.id as idioma.nombre for idioma in idiomas|idiomaFilter:actividadEdit.actividades_con_idiomas" class="form-control" required>
                            <option value="" disabled>Seleccione un idioma</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" ng-click="nuevoIdioma()" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
<script src="{{asset('/js/plugins/select.min.js')}}"></script>
<script src="{{asset('/js/administrador/actividades/indexController.js')}}"></script>
<script src="{{asset('/js/administrador/actividades/crearController.js')}}"></script>
<script src="{{asset('/js/administrador/actividades/editarController.js')}}"></script>
<script src="{{asset('/js/administrador/actividades/idiomaController.js')}}"></script>
<script src="{{asset('/js/administrador/actividades/services.js')}}"></script>
<script src="{{asset('/js/administrador/actividades/app.js')}}"></script>
<script src="{{asset('/js/plugins/directiva-tigre.js')}}"></script>
<script src="{{asset('/js/plugins/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('/js/plugins/ckeditor/ngCkeditor-v2.0.1.js')}}"></script>
@endsection
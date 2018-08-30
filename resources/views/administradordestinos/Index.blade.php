
@extends('layout._AdminLayout')

@section('title', 'Listado de destinos')

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

        form.ng-submitted input.ng-invalid {
            border-color: #FA787E;
        }

        form input.ng-invalid.ng-touched {
            border-color: #FA787E;
        }

        .form-group label, .form-group .control-label, label {
            font-size: smaller;
        }
        .input-group {
            display: flex;
        }
        .input-group-addon {
            width: 3em;
        }
        .text-error {
            color: #a94442;
            font-style: italic;
            font-size: .7em;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        
    </style>
@endsection

@section('TitleSection', 'Listado de destinos')

@section('Progreso', '0%')

@section('NumSeccion', '0%')

@section('app', 'ng-app="destinosApp"')

@section('controller','ng-controller="destinosIndexController"')
@section('titulo','Lista de destinos')
@section('subtitulo','El siguiente listado cuenta con @{{destinos.length}} registro(s)')
@section('content')
<div class="col-sm-12">
    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        <div class="flex-list">
            <a href="/administradordestinos/crear" type="button" class="btn btn-lg btn-success" >
              Insertar destino
            </a> 
            <div class="form-group has-feedback" style="display: inline-block;">
                <label class="sr-only">Búsqueda de destinos</label>
                <input type="text" ng-model="prop.search" class="form-control input-lg" id="inputEmail3" placeholder="Buscar destino...">
                <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
            </div>      
        </div>
        <div class="text-center" ng-if="(destinos | filter:prop.search).length > 0 && (prop.search != '' && prop.search != undefined)">
            <p>Hay @{{(destinos | filter:prop.search).length}} registro(s) que coinciden con su búsqueda</p>
        </div>
        <div class="alert alert-info" ng-if="destinos.length == 0">
            <p>No hay registros almacenados</p>
        </div>
        <div class="alert alert-warning" ng-if="(destinos | filter:prop.search).length == 0 && destinos.length > 0">
            <p>No existen registros que coincidan con su búsqueda</p>
        </div>
        <div class="tiles">
            <div class="tile inline-tile" dir-paginate="destino in destinos | filter:prop.search | itemsPerPage:10" pagination-id="pagination_destinos">
                <div class="tile-img">
                    <img src="@{{destino.multimedia_destinos.length > 0 ?  destino.multimedia_destinos[0].ruta : 'img/app/noimage.jpg'}}" alt="@{{destino.destino_con_idiomas[0].nombre}}"></img>
                </div>
                <div class="tile-body">
                    <div class="tile-caption">
                        <h3>@{{destino.destino_con_idiomas[0].nombre}}</h3>
                    </div>
                    <p>@{{destino.destino_con_idiomas[0].descripcion}}</p>
                    <div class="inline-buttons">
                        <a href="/administradordestinos/editar/@{{destino.id}}" class="btn btn-warning" title="Editar">Editar</a>
                        <button class="btn btn-@{{destino.estado ? 'danger' : 'success'}}" ng-click="desactivarActivar(destino)">@{{destino.estado ? 'Desactivar' : 'Activar'}}</button>
                        
                        <a href="/administradordestinos/idioma/@{{destino.id}}/@{{traduccion.idioma.id}}" ng-repeat="traduccion in destino.destino_con_idiomas" class="btn btn-default" title="@{{traduccion.idioma.culture}}"> @{{traduccion.idioma.culture}}</a>
                        <a href="javascript:void(0)" ng-click="modalIdioma(destino)" ng-if="destino.destino_con_idiomas.length < idiomas.length" class="btn btn-default" title="Agregar idioma"> <span class="glyphicon glyphicon-plus"></span><span class="sr-only">Agregar idioma</span></a>
                        
                    </div>  
                    
                </div>
            </div>
        </div>
        
        <div class="row">
          <div class="col-xs-12 text-center">
          <dir-pagination-controls pagination-id="pagination_destinos"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
          </div>
        </div>
    </div>
    
    <div class='carga'>

    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="idiomaModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nuevo idioma para el destino</h4>
                </div>
                <div class="modal-body">
            </div>
            <form>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="idioma">Elija un idioma</label>
                        <select ng-model="idiomaEditSelected" ng-options="idioma.id as idioma.nombre for idioma in idiomas|idiomaFilter:destinoEdit.destino_con_idiomas" class="form-control">
                            <option value="">Seleccione un idioma</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" ng-click="nuevoIdioma()" class="btn btn-primary">Enviar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
<script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
<script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
<script src="{{asset('/js/plugins/select.min.js')}}"></script>
<script src="{{asset('/js/administrador/destinos/indexController.js')}}"></script>
<script src="{{asset('/js/administrador/destinos/crearController.js')}}"></script>
<script src="{{asset('/js/administrador/destinos/editarController.js')}}"></script>
<script src="{{asset('/js/administrador/destinos/idiomaController.js')}}"></script>
<script src="{{asset('/js/administrador/destinos/services.js')}}"></script>
<script src="{{asset('/js/administrador/destinos/app.js')}}"></script>
<script src="{{asset('/js/plugins/directiva-tigre.js')}}"></script>
<script src="https://maps.google.com/maps/api/js?libraries=placeses,visualization,drawing,geometry,places"></script>
<script src="{{asset('/js/plugins/gmaps.js')}}"></script>
@endsection
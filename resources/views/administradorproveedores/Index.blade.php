
@extends('layout._AdminLayout')

@section('title', 'Listado de proveedores')

@section('estilos')
    <style>
        .panel-body {
            max-height: 400px;
            color: white;
        }

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
        .row {
            margin: 1em 0 0;
        }
        .form-group {
            margin: 0;
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

@section('TitleSection', 'Listado de proveedores')

@section('Progreso', '0%')

@section('NumSeccion', '0%')

@section('app', 'ng-app="proveedoresApp"')

@section('controller','ng-controller="proveedoresIndexController"')
@section('titulo','Lista de proveedores')
@section('subtitulo','El siguiente listado cuenta con @{{proveedores.length}} registro(s)')
@section('content')
<div class="flex-list">
    <a href="/administradorproveedores/crear" type="button" class="btn btn-lg btn-success" data-toggle="tooltip" data-placement="bottom" title="Esta acción permitirá publicar un proveedor que se encuentre almacenado en el sistema.">
      Publicar proveedor
    </a> 
    <div class="form-group has-feedback" style="display: inline-block;">
        <label class="sr-only">Búsqueda de proveedor</label>
        <input type="text" ng-model="prop.search" class="form-control input-lg" id="inputEmail3" placeholder="Buscar proveedor...">
        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
    </div>      
</div>
<div class="text-center" ng-if="(proveedores | filter:prop.search).length > 0 && (prop.search != '' && prop.search != undefined)">
    <p>Hay @{{(proveedores | filter:prop.search).length}} registro(s) que coinciden con su búsqueda</p>
</div>
<div class="alert alert-info" ng-if="proveedores.length == 0">
    <p>No hay registros almacenados</p>
</div>
<div class="alert alert-warning" ng-if="(proveedores | filter:prop.search).length == 0 && proveedores.length > 0">
    <p>No existen registros que coincidan con su búsqueda</p>
</div>

<div class="tiles">
    <div class="tile inline-tile" dir-paginate="proveedor in proveedores | filter:prop.search | itemsPerPage:10" pagination-id="pagination_proveedores">
        <div class="tile-img">
            <img ng-src="@{{proveedor.multimedia_proveedores.length > 0 ?  proveedor.multimedia_proveedores[0].ruta : 'img/app/noimage.jpg'}}" alt="@{{proveedor.proveedor_rnt.razon_social}}"/>
        </div>
        <div class="tile-body">
            <div class="tile-caption">
                <h3>@{{proveedor.proveedor_rnt.razon_social}}</h3>
            </div>
            <p>@{{proveedor.proveedor_rnt.proveedor_rnt_idioma[0].descripcion}}</p>
            <div class="inline-buttons">
                <a href="/administradorproveedores/editar/@{{proveedor.id}}" class="btn btn-warning">Editar</a>
                <button class="btn btn-@{{proveedor.estado ? 'danger' : 'success'}}" ng-click="desactivarActivar(proveedor)">@{{proveedor.estado ? 'Desactivar' : 'Activar'}}</button>
                
            </div>  
            
        </div>
    </div>
</div>


    <div class="row">
      <div class="col-xs-12 text-center">
          <dir-pagination-controls pagination-id="pagination_proveedores"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
      </div>
    </div>

    <div class='carga'>

    </div>

<!--<div class="modal fade" tabindex="-1" role="dialog" id="idiomaModal">-->
<!--    <div class="modal-dialog" role="document">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--                <h4 class="modal-title">Nuevo idioma para la atracción</h4>-->
<!--                </div>-->
<!--                <div class="modal-body">-->
<!--            </div>-->
<!--            <form>-->
<!--                <div class="modal-body">-->
<!--                    <div class="form-group">-->
<!--                        <label for="idioma">Elija un idioma</label>-->
<!--                        <select ng-model="idiomaEditSelected" ng-options="idioma.id as idioma.nombre for idioma in idiomas|filter:{id: idioma.id}:true" class="form-control">-->
<!--                            <option value="">Seleccione un idioma</option>-->
<!--                        </select>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="modal-footer">-->
<!--                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>-->
<!--                    <button type="button" ng-click="nuevoIdioma()" class="btn btn-primary">Enviar</button>-->
<!--                </div>-->
<!--            </form>-->
<!--        </div><!-- /.modal-content -->
<!--    </div><!-- /.modal-dialog -->
<!--</div><!-- /.modal -->

@endsection

@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
<script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
<script src="{{asset('/js/plugins/select.min.js')}}"></script>
<script src="{{asset('/js/administrador/proveedores/indexController.js')}}"></script>
<script src="{{asset('/js/administrador/proveedores/crearController.js')}}"></script>
<script src="{{asset('/js/administrador/proveedores/editarController.js')}}"></script>
<!--<script src="{{asset('/js/administrador/atracciones/idiomaController.js')}}"></script>-->
<script src="{{asset('/js/administrador/proveedores/services.js')}}"></script>
<script src="{{asset('/js/administrador/proveedores/app.js')}}"></script>
<script src="{{asset('/js/plugins/directiva-tigre.js')}}"></script>
<script>
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@endsection
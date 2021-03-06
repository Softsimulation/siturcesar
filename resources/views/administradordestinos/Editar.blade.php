
@extends('layout._AdminLayout')

@section('title', 'Editar destino')

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

        .row {
            margin: 1em 0 0;
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
        .ui-select-container{
            width: 100%;
        }
        .ui-select-container span{
            margin-top: 0;
        }
    </style>
@endsection

@section('TitleSection', 'Editar destino')

@section('app', 'ng-app="destinosApp"')

@section('controller','ng-controller="destinosEditarController"')
@section('titulo','Destinos')
@section('subtitulo','Formulario para la modificación de destinos')
@section('content')
<div class="text-center">
    <div class="alert alert-info">
        <p>Destino a modificar:</p>
        <h3 style="margin: 0">@{{destinoNombre}}</h3>
    </div>
    
</div>
<div class="alert alert-danger" ng-if="errores != null">
    <label><b>Errores:</b></label>
    <br />
    <div ng-repeat="error in errores" ng-if="error.length>0">
        -@{{error[0]}}
    </div>
</div>
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#info">Información básica</a></li>
        <li><a data-toggle="tab" href="#multimedia">Multimedia</a></li>
        <li><a data-toggle="tab" href="#sectores">Sectores</a></li>
    </ul>
        
        <div class="tab-content">
            <!--Información básica-->
            <div id="info" class="tab-pane fade in active">
                
                <form novalidate role="form" name="editarDestinoForm">
                    <fieldset>
                        <legend>
                            Información básica
                        </legend>
                        <div class="alert alert-info">
                            <p>Los campos marcados con asterisco (*) son obligatorios.</p>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <p class="form-control-static">@{{destinoNombre}}</p>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-5">
                                <div class="form-group" ng-class="{'has-error': (crearDestinoForm.$submitted || crearDestinoForm.tipo.$touched) && crearDestinoForm.tipo.$error.required}">
                                    <label for="tipo"><span class="asterisk">*</span> Tipo de destino</label>
                                    
                                    <ui-select theme="bootstrap" ng-required="true" ng-model="destino.datosGenerales.tipo" id="tipo" name="tipo">
                                       <ui-select-match placeholder="Tipo de destino.">
                                           <span ng-bind="$select.selected.tipo_destino_con_idiomas[0].nombre"></span>
                                       </ui-select-match>
                                       <ui-select-choices repeat="tipo.id as tipo in (tipos_sitio| filter: $select.search)">
                                           <span ng-bind="tipo.tipo_destino_con_idiomas[0].nombre" title="@{{tipo.tipo_destino_con_idiomas[0].nombre}}"></span>
                                       </ui-select-choices>
                                    </ui-select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div class="form-group">
                                    <label for="adress">Dirección</label>
                                    <div class="form-inline">
                                        <input required type="text" class="form-control" id="address" name="address" placeholder="Ingrese una dirección">
                                        <button type="button" ng-click="searchAdress()" class="btn btn-default">Buscar</button>
                                    </div>
                                    
                                </div>
                                
                            </div>
                            <div class="col-sm-12" >
                                <div id="direccion_map" style="height: 400px; margin: 1rem 0;">
                                    
                                </div>
                            </div>
                            <div class="col-sm-12 text-center">
                                <button type="submit" ng-click="guardarDatosGenerales()" class="btn btn-lg btn-success">Guardar</button>
                                <a href="{{asset('/administradordestinos')}}" class="btn btn-lg btn-default">Cancelar</a>
                            </div>
                        </div>
                    </fieldset>
                    
                </form>
            </div>
            
            <!--Multimedia-->
            <div id="multimedia" class="tab-pane fade">
                <h3>Multimedia</h3>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <strong>Tenga en cuenta que para subir imágenes.</strong>
                    <ul>
                        <li>Se recomienda que las imágenes presenten buena calidad (mínimo recomendado 850px × 480px).</li>
                        <li>Puede subir máximo 5 imágenes. El peso de cada imagen debe ser menor o igual a 2MB.</li>
                        <li>Si alguna de sus imágenes sobrepasa el tamaño permitido se le sugiere comprimir la imagen en <a href="https://tinyjpg.com" target="_blank">tinyjgp.com <span class="glyphicon glyphicon-share"></span></n></a>, <a href="http://optimizilla.com" target="_blank">optimizilla.com <span class="glyphicon glyphicon-share"></span></a>, o cualquier otro compresor de imágenes.</li>
                        <li>Para seleccionar varias imágenes debe mantener presionada la tecla ctrl o arrastre el ratón sobre las imágenes que desea seleccionar.</li>
                    </ul>
                </div>
                <form novalidate role="form" name="multimediaForm">
                    <div class="row">
                        <h4><span class="text-danger"><span class="glyphicon glyphicon-asterisk"></span></span> Imagen de portada</h4>
                        <div class="col-sm-12">
                            <file-input text="portadaIMGText" ng-model="portadaIMG" preview="previewportadaIMG" accept="image/*" icon-class="glyphicon glyphicon-plus" id-input="portadaIMG" label="Seleccione la imagen de portada."></file-input>
                        </div>
                    </div>
                    <div>
                        <h4>Subir imágenes</h4>
                        <div class="col-sm-12">
                            <file-input text="previewImagenesText" ng-model="imagenes" preview="previewImagenes" accept="image/*" icon-class="glyphicon glyphicon-plus" id-input="imagenes" label="Seleccione las imágenes de la atracción." multiple max-files="19"></file-input>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            <label for="video"><h4>Video (opcional)</h4></label>
                            <input type="text" name="video" id="video" class="form-control" placeholder="URL del video de YouTube" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <button ng-click="guardarMultimedia()" type="submit" class="btn btn-lg btn-success" >Guardar</button>
                            <a href="{{asset('/administradordestinos')}}" class="btn btn-lg btn-default">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
            <!--Sectores-->
            <div id="sectores" class="tab-pane fade">
                <fieldset>
                    <legend>
                        Sectores
                    </legend>
                    <div class="flex-list">
                        <button class="btn btn-success" ng-click="modalSector()">Agregar</button> 
                        <div class="form-group has-feedback" style="display: inline-block;">
                            <label class="sr-only">Búsqueda de destinos</label>
                            <input type="text" ng-model="prop.search" class="form-control" id="inputEmail3" placeholder="Buscar sector...">
                            <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                        </div>      
                    </div>
                    <div class="text-center" ng-if="(sectores | filter:prop.search).length > 0 && (prop.search != '' && prop.search != undefined)">
                        <p>Hay @{{(sectores|filter:prop.search).length}} registro(s) que coinciden con su búsqueda</p>
                    </div>
                    <div class="alert alert-info" ng-if="sectores.length == 0">
                        <p>No hay registros almacenados</p>
                    </div>
                    <div class="alert alert-warning" ng-if="(sectores|filter:prop.search).length == 0 && sectores.length > 0">
                        <p>No existen registros que coincidan con su búsqueda</p>
                    </div>
                    <div class="row" style="margin: 0;">
                        <div class="col-xs-12">
                            <table class="table table-hover" ng-show="sectores.length > 0">
                                <thead>
                                    <tr style="cursor: pointer;">
                                        <th ng-click="orderByField='id'; reverseSort = !reverseSort">Id <span ng-show="orderByField == 'id'"><span ng-show="!reverseSort" class="glyphicon glyphicon-menu-up"></span><span ng-show="reverseSort" class="glyphicon glyphicon-menu-down"></span></span></th>
                                        <th ng-click="orderByField='sectores_con_idiomas[0].nombre'; reverseSort = !reverseSort">Nombre <span ng-show="orderByField == 'sectores_con_idiomas[0].nombre'"><span ng-show="!reverseSort" class="glyphicon glyphicon-menu-up"></span><span ng-show="reverseSort" class="glyphicon glyphicon-menu-down"></span></span></th>
                                        <th ng-click="orderByField='es_urbano'; reverseSort = !reverseSort">Urbano <span ng-show="orderByField == 'es_urbano'"><span ng-show="!reverseSort" class="glyphicon glyphicon-menu-up"></span><span ng-show="reverseSort" class="glyphicon glyphicon-menu-down"></span></span></th>
                                        <th> Idiomas </th>
                                        <th> Eliminar </th>
    
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr dir-paginate="sector in sectores|filter:prop.search|orderBy:orderByField:reverseSort|itemsPerPage:10 as results">
                                        <td class="text-center">@{{sector.id}}</td>
                                        <td>@{{sector.sectores_con_idiomas[0].nombre}}</td>
    
                                        <td class="text-center">@{{sector.es_urbano ? 'Si':'No'}}</td>
                                        <td class="text-center">
                                            <button type="button" ng-repeat="i in sector.sectores_con_idiomas" class="btn btn-sm btn-default" ng-click="idiomaSectorModal(sector, i.idioma.id)">
                                                @{{i.idioma.culture}}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-default" ng-click="idiomaSectorModal(sector, 0)" ng-if="sector.sectores_con_idiomas.length < idiomas.length" title="Ingresar información con otro idioma"><span class="glyphicon glyphicon-plus"></span><span class="sr-only">Agregar idioma</span></button>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-default" ng-click="deleteSector(sector)" title="Eliminar"><span class="glyphicon glyphicon-trash"></span><span class="sr-only">Eliminar</span> </button>
                                        </td>
    
                                    </tr>
                                </tbody>
                            </table>
                            <div class="alert alert-warning" role="alert" ng-show="exportacion.length == 0 || results.length == 0">No hay resultados disponibles</div>
                        </div>
                    </div>
                    <div class="row" ng-show="exportacion.length == 0">
                        <div class="col-xs-12">
                            <div class="alert alert-warning" role="alert">
                                No hay sectores ingresados para este destino
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12" style="text-align: center;">
                            <dir-pagination-controls max-size="8"
                                                     direction-links="true"
                                                     boundary-links="true">
                            </dir-pagination-controls>
                        </div>
                    </div>
                </fieldset>
                
            </div>
        </div>

<div class="modal fade" tabindex="-1" role="dialog" id="addSector">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nuevo sector</h4>
            </div>
            <form name="nuevoSector" novalidate>
                <div class="modal-body">
                    <div class="form-group" ng-class="{'has-error': (nuevoSector.$submitted || nuevoSector.nombre.$touched) && nuevoSector.nombre.$error.required}">
                        <label for="nombre">Nombre</label>
                        <div class="input-group">
                            <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                            <input ng-model="sector.nombre" required type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del sector (Máximo 150 caracteres)" aria-describedby="basic-addon1"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="es_urbano">¿Es urbano?</label>
                        <label class="radio-inline">
                            <input type="radio" ng-model="sector.es_urbano" name="es_urbano" id="inlineRadio1" ng-value="true"> Si
                        </label>
                        <label class="radio-inline">
                            <input type="radio" ng-model="sector.es_urbano" name="inlineRadioOptions" id="inlineRadio2" ng-value="false"> No
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" ng-click="crearSector()" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="editIdiomaSector">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar idioma</h4>
            </div>
            <form name="editarIdiomaSectorForm" novalidate>
                <div class="modal-body">
                    <div class="form-group" ng-class="{'has-error': (editarIdiomaSectorForm.$submitted || editarIdiomaSectorForm.nombre.$touched) && editarIdiomaSectorForm.nombre.$error.required}">
                        <label for="nombre">Nombre</label>
                        <div class="input-group">
                            <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                            <input ng-model="sectorIdioma.nombre" required type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del sector (Máximo 150 caracteres)" aria-describedby="basic-addon1"/>
                        </div>
                    </div>
                </div>
                <div ng-show="sectorIdioma.swIdioma" class="modal-body">
                    <div class="form-group">
                        <label for="idioma">Elija un idioma</label>
                        <select ng-required="sectorIdioma.swIdioma" ng-model="sectorIdioma.idioma_id" ng-options="idioma.id as idioma.nombre for idioma in idiomas|idiomaFilter:sectorIdioma.sectores_con_idiomas" class="form-control">
                            <option value="">Seleccione un idioma</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" ng-click="editarIdiomaSectorController()" class="btn btn-primary">Enviar</button>
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
<script src="https://maps.google.com/maps/api/js?key=AIzaSyC55uUNZFEafP0702kEyGLlSmGE29R9s5k&libraries=placeses,visualization,drawing,geometry,places"></script>
<script src="{{asset('/js/plugins/gmaps.js')}}"></script>
<script src="{{asset('/js/plugins/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('/js/plugins/ckeditor/ngCkeditor-v2.0.1.js')}}"></script>
@endsection

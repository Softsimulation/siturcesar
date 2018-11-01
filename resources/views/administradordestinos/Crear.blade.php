
@extends('layout._AdminLayout')

@section('title', 'Nuevo destino')

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

@section('TitleSection', 'Nuevo destino')

@section('app', 'ng-app="destinosApp"')

@section('controller','ng-controller="destinosCrearController"')
@section('titulo','Destinos')
@section('subtitulo','Formulario para el registro de destinos')
@section('content')


<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#info">Información básica</a></li>
    <li><a data-toggle="tab" href="#multimedia">Multimedia</a></li>
</ul>

<div class="tab-content">
    <!--Información básica-->
    <div id="info" class="tab-pane fade in active">
        
        <form novalidate role="form" name="crearDestinoForm">
            <fieldset>
                <legend>
                    Información básica
                </legend>
                <div class="alert alert-danger" ng-if="errores != null">
                    <label><b>Errores:</b></label>
                    <br />
                    <div ng-repeat="error in errores" ng-if="error.length>0">
                        -@{{error[0]}}
                    </div>
                </div>
                <div class="alert alert-info">
                    Todos los campos marcados con asterisco (*) son obligatorios.
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group" ng-class="{'has-error': (crearDestinoForm.$submitted || crearDestinoForm.nombre.$touched) && crearDestinoForm.nombre.$error.required}">
                            <label for="nombre"><span class="asterisk">*</span> Nombre</label>
                            <input ng-model="destino.datosGenerales.nombre" required type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del destino. Máx. 150 caracteres"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
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
                    <div class="col-xs-12">
                        <div class="form-group" ng-class="{'has-error': (crearDestinoForm.$submitted || crearDestinoForm.descripcion.$touched) && crearDestinoForm.descripcion.$error.required}">
                            <label for="descripcion"><span class="asterisk">*</span> Descripción</label>
                            <textarea style="resize: none;" ng-model="destino.datosGenerales.descripcion" rows="5" required name="descripcion" id="descripcion" class="form-control" placeholder="Descripción del destino (De 100 a 1,000 caracteres)"></textarea>
                                
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-inline text-center">
                            <div class="form-group">
                                <label for="adress">Dirección</label>
                                <input required type="text" class="form-control" id="address" name="address" placeholder="Ingrese una dirección">
                            </div>
                            <button type="button" ng-click="searchAdress()" class="btn btn-default">Buscar</button>
                        </div>
                            
                    </div>
                    <div class="col-xs-12">
                        <div id="direccion_map" style="height: 400px; margin: 1rem 0;">
                            
                        </div>
                    </div>
                    <div class="col-xs-12 text-center">
                        <hr/>
                        <button type="submit" ng-click="guardarDatosGenerales()" ng-class="{'disabled': (destino.id != -1)}" class="btn btn-lg btn-success">Guardar</button>
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
                <li>Si alguna de sus imágenes sobrepasa el tamaño permitido se le sugiere comprimir la imagen en <a href="https://tinyjpg.com/" target="_blank">tinyjgp.com <span class="glyphicon glyphicon-share"></span></n></a>, <a href="http://optimizilla.com" target="_blank">optimizilla.com <span class="glyphicon glyphicon-share"></span></a>, o cualquier otro compresor de imágenes.</li>
                <li>Para seleccionar varias imágenes debe mantener presionada la tecla ctrl o arrastre el ratón sobre las imágenes que desea seleccionar.</li>
            </ul>
        </div>
        <form novalidate role="form" name="multimediaForm">
            <div class="row">
                <h4><span class="text-danger"><span class="glyphicon glyphicon-asterisk"></span></span> Imagen de portada</h4>
                <div class="col-sm-12">
                    <file-input ng-model="portadaIMG" accept="image/*" icon-class="glyphicon glyphicon-plus" id-input="portadaIMG" label="Seleccione la imagen de portada."></file-input>
                </div>
            </div>
            <div>
                <h4>Galería de imágenes (Max. 5 imágenes)</h4> 
                <div class="col-sm-12">
                    <file-input ng-model="imagenes" accept="image/*" icon-class="glyphicon glyphicon-plus" id-input="imagenes" label="Seleccione las imágenes de la atracción." multiple max-files="5"></file-input>
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
                    <hr/>
                    <button ng-click="guardarMultimedia()" type="submit" ng-class="{'disabled': (destino.id == -1)}" class="btn btn-lg btn-success" >Guardar</button>
                    <a href="{{asset('/administradordestinos')}}" class="btn btn-lg btn-default">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>
    
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
@endsection

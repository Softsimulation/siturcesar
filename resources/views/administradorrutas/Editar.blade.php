
@extends('layout._AdminLayout')

@section('title', 'Editar ruta')

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

        
        .ui-select-container{
            width: 100%;
        }
        .ui-select-container span{
            margin-top: 0;
        }
    </style>
@endsection

@section('TitleSection', 'Editar ruta')

@section('Progreso', '0%')

@section('NumSeccion', '0%')

@section('app', 'ng-app="rutasApp"')

@section('controller','ng-controller="rutasEditarController"')

@section('titulo','Rutas turísticas')
@section('subtitulo','Formulario para la modificación de rutas turísticas')

@section('content')
<div class="text-center">
    <div class="alert alert-info">
        <p>Atracción a modificar:</p>
        <h3 style="margin: 0">@{{rutaNombre}}</h3>
    </div>
    
</div>
<input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    
<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#multimedia">Multimedia</a></li>
    <li><a data-toggle="tab" href="#adicional">Información adicional</a></li>
</ul>
        <div class="tab-content">
            
            <!--Multimedia-->
            <div id="multimedia" class="tab-pane fade in active">
                <fieldset>
                    <legend>Multimedia</legend>
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <strong>Tenga en cuenta que para subir imágenes.</strong>
                        <ul>
                            <li>Se recomienda que las imágenes presenten buena calidad (mínimo recomendado 850px × 480px).</li>
                            <li>Puede subir máximo 5 imágenes. El peso de cada imagen debe ser menor o igual a 2MB.</li>
                            <li>Si alguna de sus imágenes sobrepasa el tamaño permitido se le sugiere comprimir la imagen en <a href="https://compressor.io" target="_blank">compressor.io <span class="glyphicon glyphicon-share"></span></n></a>, <a href="http://optimizilla.com" target="_blank">optimizilla.com <span class="glyphicon glyphicon-share"></span></a>, o cualquier otro compresor de imágenes.</li>
                            <li>Para seleccionar varias imágenes debe mantener presionada la tecla ctrl o arrastre el ratón sobre las imágenes que desea seleccionar.</li>
                        </ul>
                    </div>
                    <form novalidate role="form" name="multimediaForm">
                        <div class="row">
                            <h4><span class="asterisk">*</span> Imagen de portada</h4>
                            <div class="col-sm-12">
                                <file-input ng-model="portadaIMG" preview="previewportadaIMG" accept="image/*" icon-class="glyphicon glyphicon-plus" id-input="portadaIMG" label="Seleccione la imagen de portada."></file-input>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <hr/>
                                <button ng-click="guardarMultimedia()" type="submit" class="btn btn-lg btn-success" >Guardar</button>
                                <a href="{{asset('/administradorrutas')}}" class="btn btn-lg btn-default">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </fieldset>
                
            </div>
            
            <!--Información adicional-->
            <div id="adicional" class="tab-pane fade">
                <form novalidate role="form" name="informacionAdicionalForm">
                    <fieldset>
                        <legend>Información adicional</legend>
                        <div class="alert alert-info">
                            <p>Los campos marcados con asterisco (*) son obligatorios.</p>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group" ng-class="{'has-error': (informacionAdicionalForm.$submitted || informacionAdicionalForm.atracciones.$touched) && informacionAdicionalForm.atracciones.$error.required}">
                                    <label for="atracciones"><span class="asterisk">*</span> Atracciones de la ruta <span class="text-error text-msg">(Seleccione al menos una atracción)</span></label>
                                    <ui-select name="atracciones" id="atracciones" multiple ng-required="true" ng-model="ruta.adicional.atracciones" theme="bootstrap" close-on-select="false" >
                                        <ui-select-match placeholder="Seleccione uno o varios perfiles de usuario.">
                                            <span ng-bind="$item.sitio.sitios_con_idiomas[0].nombre"></span>
                                        </ui-select-match>
                                        <ui-select-choices repeat="atraccion.id as atraccion in (atracciones| filter: $select.search)">
                                            <span ng-bind="atraccion.sitio.sitios_con_idiomas[0].nombre" title="@{{atraccion.sitio.sitios_con_idiomas[0].nombre}}"></span>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                            </div>
                            <div class="col-xs-12 text-center">
                                <hr/>
                                <button type="submit"  class="btn btn-lg btn-success" ng-click="guardarAdicional()">Guardar</button>
                                 <a href="{{asset('/administradorrutas')}}" class="btn btn-lg btn-default">Cancelar</a>
                            </div>
                        </div>
                    </fieldset>
                    
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
<script src="{{asset('/js/plugins/directiva-tigre.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/crearController.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/indexController.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/idiomaController.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/editarController.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/services.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/app.js')}}"></script>
@endsection

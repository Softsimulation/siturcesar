angular.module('importarRntApp', ["checklist-model","proveedorService",'angularUtils.directives.dirPagination','ngMap'])

.directive('fileInput', ['$parse', function ($parse) {

    return {
        restrict: 'A',
        link: function (scope, elm, attrs) {
            elm.bind('change', function () {
                $parse(attrs.fileInput).assign(scope, elm[0].files);
                scope.$apply();
            })

        }

    }

}])

.controller('importarRnt', ['$scope', 'proveedorServi',function ($scope, proveedorServi) {
   
   $scope.nuevos =  [];
   $scope.antiguos =  [];
   $scope.swAgregarSinRnt = true;
   
   $scope.cargarDocumento = function(){
       
       if($scope.soporte == null){
            swal("Error", "Debe cargar un soporte.", "error");
            return;
       }
       
       var input = $('#soporte');
        if (input[0] != undefined) {
            // check for browser support (may need to be modified)
            if (input[0].files && input[0].files.length == 1) {
                if (input[0].files[0].size > 20971520) {
                    swal("Error", "Por favor el soporte debe tener un peso menor de " + (20971520 / 1024 / 1024) + " MB", "error");
                    // alert("The file must be less than " + (1572864/ 1024 / 1024) + "MB");
                    return;
                }
            }
        }
        
        var fd = new FormData();
        if ($scope.soporte != null) {
            fd.append("soporte", $scope.soporte[0]);
        }
        
        $("body").attr("class", "cbp-spmenu-push charging");
        
        proveedorServi.CargarSoporte(fd).then(function (data) {
            if (data.success) {
                $scope.errores = null;
                $("body").attr("class", "cbp-spmenu-push");
                $scope.nuevos = data.nuevos;
                $scope.antiguos = data.antiguos;
                $scope.sinRnt = data.sinRnt;
            } else {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Por favor corrija los errores", "error");
                $scope.errores = data.errores;
            }
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "No se realizo la solicitud, reinicie la página","error");
        })
       
   }
   
   $scope.abrirModalEditar = function(registro){
        $scope.registro = angular.copy(registro);
        $scope.indexEditar = $scope.antiguos.indexOf(registro);
        $scope.editarForm.$setPristine();
        $scope.editarForm.$setUntouched();
        $scope.editarForm.$submitted = false;
        $('#modalEditar').modal('show');
   }
   
   $scope.editarRegistro = function(){
        if(!$scope.editarForm.$valid){
            swal("Info", "Verifique que todos los campos estén ingresados.","info");
            return;
        }                 
       
        $("body").attr("class", "cbp-spmenu-push charging");
        
        proveedorServi.EditarProveedor($scope.registro).then(function (data) {
            if (data.success) {
                $("body").attr("class", "cbp-spmenu-push");
                $scope.antiguos[$scope.indexEditar] = data.proveedor;
                $scope.errores = null;
                swal({
                    title: "Realizado",
                    text: "Se ha editado satisfactoriamente el registro.",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
                
                setTimeout(function () {
                    $('#modalEditar').modal('hide');
                }, 2000);
                
            } else {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Por favor corrija los errores", "error");
                $scope.errores = data.errores;
            }
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "No se realizo la solicitud, reinicie la página","error");
        })
       
   }
   
   $scope.abrirModalCrear = function(registro){
        $scope.registro = angular.copy(registro);
        $scope.indexCrear = $scope.nuevos.indexOf(registro);
        $scope.addForm.$setPristine();
        $scope.addForm.$setUntouched();
        $scope.addForm.$submitted = false;
        $('#modalAgregar').modal('show');
   }
   
   $scope.abrirModalCrearSinRnt = function(registro){
        $scope.registro = angular.copy(registro);
        $scope.indexCrear = $scope.nuevos.indexOf(registro);
        $scope.addFormSinRnt.$setPristine();
        $scope.addFormSinRnt.$setUntouched();
        $scope.addFormSinRnt.$submitted = false;
        $('#modalAgregarSinRnt').modal('show');
   }
   
   $scope.guardarRegistro = function(sw){
       if( (!$scope.addForm.$valid && $scope.sw == 0) || (!$scope.addFormSinRnt.$valid && $scope.sw == 1) ){
            swal("Info", "Verifique que todos los campos estén ingresados.","info");
            return;
        }                 
       
        $("body").attr("class", "cbp-spmenu-push charging");
        
        proveedorServi.CrearProveedor($scope.registro).then(function (data) {
            if (data.success) {
                $scope.errores = null;
                $("body").attr("class", "cbp-spmenu-push");
                $scope.nuevos[$scope.indexCrear] = data.proveedor;
                swal({
                    title: "Realizado",
                    text: "Se ha creado satisfactoriamente el registro.",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
                
                setTimeout(function () {
                    $('#modalAgregar').modal('hide');
                    $('#modalAgregarSinRnt').modal('hide');
                }, 2000);
                
            } else {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Por favor corrija los errores", "error");
                $scope.errores = data.errores;
            }
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "No se realizo la solicitud, reinicie la página","error");
        })
   }
   
   $scope.abrirModalVer = function(item){
       $scope.registro = angular.copy(item);
       $('#modalVer').modal('show');
   }
   
   $scope.getCurrentLocation = function(event,registro){
        registro.latitud = event.latLng.lat();
        registro.longitud = event.latLng.lng();
    }
    
    $scope.drawFinish = function(event, registro){
        registro.latitud = event.overlay.position.lat();
        registro.longitud = event.overlay.position.lng();
        event.overlay.setMap(null);
    }
    
    $scope.sobreescribirRegistro = function(sw){
        if( (!$scope.addForm.$valid && $scope.sw == 0) || (!$scope.addFormSinRnt.$valid && $scope.sw == 1) ){
            swal("Info", "Verifique que todos los campos estén ingresados.","info");
            return;
        }                  
       
        $("body").attr("class", "cbp-spmenu-push charging");
        proveedorServi.EditarProveedor($scope.registro).then(function (data) {
            if (data.success) {
                $("body").attr("class", "cbp-spmenu-push");
                $scope.nuevos[$scope.indexCrear] = data.proveedor;
                $scope.errores = null;
                swal({
                    title: "Realizado",
                    text: "Se ha editado satisfactoriamente el registro.",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
                
                setTimeout(function () {
                    $('#modalAgregar').modal('hide');
                    $('#modalAgregarSinRnt').modal('hide');
                }, 2000);
                
            } else {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Por favor corrija los errores", "error");
                $scope.errores = data.errores;
            }
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "No se realizo la solicitud, reinicie la página","error");
        })
        
        
    }
    
    $scope.guardarRegistroHavilitar = function(sw){
        if( (!$scope.addForm.$valid && $scope.sw == 0) || (!$scope.addFormSinRnt.$valid && $scope.sw == 1) ){
            swal("Info", "Verifique que todos los campos estén ingresados.","info");
            return;
        } 
        $("body").attr("class", "cbp-spmenu-push charging");
        proveedorServi.CrearHabilitarProveedor($scope.registro).then(function (data) {
            if (data.success) {
                $("body").attr("class", "cbp-spmenu-push");
                $scope.nuevos[$scope.indexCrear] = data.proveedor;
                $scope.errores = null;
                swal({
                    title: "Realizado",
                    text: "Se ha editado satisfactoriamente el registro.",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
                
                setTimeout(function () {
                    $('#modalAgregar').modal('hide');
                    $('#modalAgregarSinRnt').modal('hide');
                }, 2000);
                
            } else {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Por favor corrija los errores", "error");
                $scope.errores = data.errores;
            }
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "No se realizo la solicitud, reinicie la página","error");
        })
    }
    
    
    $scope.agregarTodosSinRnt = function(){
        swal({
            title: "Agregar registros",
            text: "¿Está seguro? Se agregaran todos los registros correctos mostrados en este panel",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        },
        function () {
            setTimeout(function () {
                $("body").attr("class", "charging");
                proveedorServi.AgregarLoteSinRnt( { 'proveedores' : $scope.sinRnt } ).then(function(data){
                    if(data.success){
                        swal({
                            title: "Agregadis",
                            text: data.mensaje,
                            type: "success",
                            timer: 1000,
                            showConfirmButton: false
                        });
                        if(data.contador != 0){
                            $scope.swAgregarSinRnt = false;    
                        }
                        $scope.errores = null;
                    }else{
                        swal("Error", "Verifique la información y vuelva a intentarlo.", "error");
                        $scope.errores = data.errores; 
                    }
                     $("body").attr("class", "cbp-spmenu-push");
                }).catch(function(){
                    $("body").attr("class", "cbp-spmenu-push");
                    swal("Error","Error en la petición, recargue la pagina","error");
                })
            }, 2000);
        });
    }
    
    $scope.quitarRegistroSinRnt = function(index){
        swal({
            title: "Eliminar registro",
            text: "¿Está seguro? Para volver a acceder al registro tendrá que cargar nuevamente el archivo.",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            cancelButtonText: "Cancelar"
            // showLoaderOnConfirm: true,
        },
        function () {
            $scope.$apply(function () {
                $scope.sinRnt.splice(index,1);
            });
            // setTimeout(function () {
            //     $("body").attr("class", "charging");
            //     $scope.sinRnt.splice(index,1);
            //     $("body").attr("class", "cbp-spmenu-push");
            // }, 500);
        });
    }
    
   
}])
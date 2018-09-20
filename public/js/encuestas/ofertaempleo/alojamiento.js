var app = angular.module('appEncuestaAlojamiento', ["OfertaEmpleoServices"] );



app.controller("AlojamientoTrimestralCtrl", function($scope, OfertaEmpleoServi){
    
    $scope.alojamiento = { habitaciones:{}, apartamentos:{}, casas:{}, cabanas:{}, campins:{} };
    $scope.numero_dias = 0;
    
    $("body").attr("class", "cbp-spmenu-push charging");
    
    OfertaEmpleoServi.getDataAlojamiento( $("#id").val() ).then(function(data){
            
            if(data.alojamiento){
                $scope.alojamiento = data.alojamiento;
            }
            
            $scope.servicios = data.servicios;
            $scope.numero_dias = data.numeroDias;
            $("body").attr("class", "cbp-spmenu-push");
        }).catch(function(){
           $("body").attr("class", "cbp-spmenu-push");
           swal("Error","Error en la carga de pagina","error"); 
        });
    
    
    $scope.guardar = function(){
        
        if(!$scope.carForm.$valid){
            swal("Error","Corrija los errores","error");  return;
        }
        
        
        $scope.ErrorServicio = false;
        var sw = true;
        for ( var name in $scope.servicios ) {
          if($scope.servicios[name]==true){ sw = false; }
        }
        if(sw){
            $scope.ErrorServicio = true;
            swal("Error","Corrija los errores","error");  return;
        }
        
        $("body").attr("class", "cbp-spmenu-push charging");
        
        var data = angular.copy($scope.alojamiento);
        data.encuesta = $("#id").val();
        data.servicios = angular.copy($scope.servicios);
        
        OfertaEmpleoServi.GuardaralojamientoTrimestral( data ).then(function(data){
            
            if(data.success){
                
                swal({
                  title: "Realizado",
                  text: "Se ha guardado satisfactoriamente la sección.",
                  type: "success",
                  showCancelButton: true,
                  confirmButtonClass: "btn-info",
                  cancelButtonClass: "btn-info",
                  confirmButtonText: "Empleo",
                  cancelButtonText: "Listado de encuestas",
                  closeOnConfirm: false,
                  closeOnCancel: false
                },
                function(isConfirm) {
                  if (isConfirm) {
                    window.location.href = '/ofertaempleo/empleomensual/'+ $("#id").val() ;
                  } else {
                    window.location.href = data.ruta;
                  }
                });
                
            }
            else{
                $scope.errores = data.errores;
                swal("Error","Corrija los errores","error");
            }
            
            $("body").attr("class", "cbp-spmenu-push");
        }).catch(function(){
           $("body").attr("class", "cbp-spmenu-push");
           swal("Error","Error en la carga de pagina","error"); 
        });
        
    }
    
    
    $scope.resetDatos = function(servicio, estadoServi){
        
        switch (servicio) {
            case 1: /* habitaciones*/
                $scope.alojamiento.habitaciones[0] = estadoServi ? $scope.alojamiento.habitaciones[0] : {};
                break;
            
            case 2: /* Apartamentos*/
                $scope.alojamiento.apartamentos[0] = estadoServi ? $scope.alojamiento.apartamentos[0] : {};
                break;
                
            case 3: /* Casas*/
                $scope.alojamiento.casas[0] = estadoServi ? $scope.alojamiento.casas[0] : {};
                break;
            
            case 4: /* Cabañas*/
                $scope.alojamiento.cabanas[0] = estadoServi ? $scope.alojamiento.cabanas[0] : {};
                break;
            
            case 5: /* Campings*/
                $scope.alojamiento.campings[0] = estadoServi ? $scope.alojamiento.campings[0] : {};
                break;
            
            default: return ;
                // code
        }
        
    }
    
    
});

app.controller("AlojamientoMensualCtrl", function($scope, OfertaEmpleoServi){
    
    $scope.alojamiento = { habitaciones:{}, apartamentos:{}, casas:{}, cabanas:{}, campins:{} };
     $scope.numero_dias = 0;
     
    $("body").attr("class", "cbp-spmenu-push charging");
    
    OfertaEmpleoServi.getDataAlojamiento( $("#id").val() ).then(function(data){
            
            if(data.alojamiento){
                $scope.alojamiento = data.alojamiento;
            }
            
            $scope.servicios = data.servicios;
            $scope.numero_dias = data.numeroDias;
            $("body").attr("class", "cbp-spmenu-push");
        }).catch(function(){
           $("body").attr("class", "cbp-spmenu-push");
           swal("Error","Error en la carga de pagina","error"); 
        });
    
    
    $scope.guardar = function(){
        
        if(!$scope.carForm.$valid){
            swal("Error","Corrija los errores","error");  return;
        }
        
        
        $scope.ErrorServicio = false;
        var sw = true;
        for ( var name in $scope.servicios ) {
          if($scope.servicios[name]==true){ sw = false; }
        }
        if(sw){
            $scope.ErrorServicio = true;
            swal("Error","Corrija los errores","error");  return;
        }
        
        $("body").attr("class", "cbp-spmenu-push charging");
        
        var data = angular.copy($scope.alojamiento);
        data.encuesta = $("#id").val();
        data.servicios = angular.copy($scope.servicios);
        
        OfertaEmpleoServi.GuardaralojamientoMensual( data ).then(function(data){
            
            if(data.success){
                
                swal({
                  title: "Realizado",
                  text: "Se ha guardado satisfactoriamente la sección.",
                  type: "success",
                  showCancelButton: true,
                  confirmButtonClass: "btn-info",
                  cancelButtonClass: "btn-info",
                  confirmButtonText: "Empleo",
                  cancelButtonText: "Listado de encuestas",
                  closeOnConfirm: false,
                  closeOnCancel: false
                },
                function(isConfirm) {
                  if (isConfirm) {
                    window.location.href = '/ofertaempleo/empleomensual/'+ $("#id").val() ;
                  } else {
                    window.location.href = data.ruta;
                  }
                });
                
            }
            else{
                $scope.errores = data.errores;
                swal("Error","Corrija los errores","error");
            }
            
            $("body").attr("class", "cbp-spmenu-push");
        }).catch(function(){
           $("body").attr("class", "cbp-spmenu-push");
           swal("Error","Error en la carga de pagina","error"); 
        });
        
    }
    
    
    $scope.resetDatos = function(servicio, estadoServi){
        
        switch (servicio) {
            case 1: /* habitaciones*/
                $scope.alojamiento.habitaciones[0] = estadoServi ? $scope.alojamiento.habitaciones[0] : {};
                break;
            
            case 2: /* Apartamentos*/
                $scope.alojamiento.apartamentos[0] = estadoServi ? $scope.alojamiento.apartamentos[0] : {};
                break;
                
            case 3: /* Casas*/
                $scope.alojamiento.casas[0] = estadoServi ? $scope.alojamiento.casas[0] : {};
                break;
            
            case 4: /* Cabañas*/
                $scope.alojamiento.cabanas[0] = estadoServi ? $scope.alojamiento.cabanas[0] : {};
                break;
            
            case 5: /* Campings*/
                $scope.alojamiento.campings[0] = estadoServi ? $scope.alojamiento.campings[0] : {};
                break;
            
            default: return ;
                // code
        }
        
    }
    
    
});


angular.module('interno.transporte', ["checklist-model"])

.controller('transporte', function ($scope, $http) {
    $scope.transporte = {}

    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging")
        $http.get('/turismointerno/cargartransporte/'+$scope.id)
            .success(function (data) {
                $("body").attr("class", "cbp-spmenu-push")
                $scope.transportes = data.transportes
                $scope.medios=data.medios
                $scope.transporte.id = $scope.id
                $scope.transporte.Mover = data.tipo_transporte
                $scope.transporte.Medio = data.medio_transporte
                $scope.transporte.Tipo_otro=data.otrotipo
                $scope.transporte.Medio_otro=data.otromedio
                
            }).error(function () {
                $("body").attr("class", "cbp-spmenu-push")
                swal("Error", "Error en la carga, por favor recarga la pagina", "error")
            })
    })
    
    $scope.cambio=function(){
        
        if($scope.transporte.Mover!=10){
            
            $scope.transporte.Tipo_otro="";
            
        }
        
    }
    
    $scope.cambio2=function(){
        
         if($scope.transporte.Medio!=8){
            
            $scope.transporte.Medio_otro="";
            
        }
        
    }
   

    

    $scope.guardar = function () {
        if (!$scope.transForm.$valid) {
            return
        }

        $("body").attr("class", "cbp-spmenu-push charging")
        $http.post('/turismointerno/guardartransporte', $scope.transporte)
            .success(function (data) {
                $("body").attr("class", "cbp-spmenu-push")
                if (data.success) {
                    var msj
                    if (data.sw == 0) {
                        msj = "guardado"
                    } else {
                        msj = "editado"
                    }
                    swal({
                        title: "Realizado",
                        text: "Se ha " + msj + " satisfactoriamente la sección.",
                        type: "success",
                        timer: 1000,
                        showConfirmButton: false
                    });
                    setTimeout(function () {
                        window.location.href = "/turismointerno/gastos/"+$scope.id;
                    }, 1000);
                } else {
                    $scope.errores = data.errores
                    swal("Error", "Verifique la información y vuelva a intentarlo.", "error")
                }
            }).error(function () {
                $("body").attr("class", "cbp-spmenu-push")
                swal("Error", "Error en la carga, por favor recarga la página.", "error")
            })
    }
})

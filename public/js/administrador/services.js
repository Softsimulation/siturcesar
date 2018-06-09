var app = angular.module("adminservice", []);

app.factory("adminService", ["$http", "$q", function ($http, $q) {

    return {
       

        getEncuestas: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/turismoreceptor/encuestas').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
        Exportar: function (data) {
            
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/exportacion/exportar',data).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
        GetTemporadas: function () {
            
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/temporada/gettemporadas').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            
            return promise;
        },
        
        Guardartemporada: function (data) {
            
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/temporada/guardartemporada',data).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        CambiarEstado: function (data) {
            
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/temporada/cambiarestado',data).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        DatosTemporada: function (data) {
            
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/temporada/cargardatos/'+data).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            
            return promise;
        },
        
        
        
        
    }
}]);
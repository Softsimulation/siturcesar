var app = angular.module("OfertaEmpleoServices", []);

app.factory("OfertaEmpleoServi", ["$http", "$q", function ($http, $q) {

    return {
  
        getDataAlojamiento: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleo/dataalojamiento/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
        GuardaralojamientoTrimestral: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleo/guardaralojamientotrimestral', data ).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
        GuardaralojamientoMensual: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleo/guardaralojamientomensual', data ).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
       
    }
}]);
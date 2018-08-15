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
        }
        
    }
}]);
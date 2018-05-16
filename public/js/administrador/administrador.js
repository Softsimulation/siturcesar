var situr = angular.module("situr_admin", ['']);


situr.directive('fileInput', ['$parse', function ($parse) {

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

situr.directive('finalizacion', function () {
    return function (scope, element, attrs) {

        if (scope.$last) {
            $(".select2 ").select2({

            });
        }
    };
})
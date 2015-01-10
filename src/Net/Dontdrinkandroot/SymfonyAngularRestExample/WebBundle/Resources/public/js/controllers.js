var controllers = angular.module('ExampleApp.controllers', []);

controllers.controller('IndexController', ['$scope', 'Restangular', function ($scope, Restangular) {

    $scope.loading = true;
    Restangular.all('newsentry').getList()
        .then(
        function (newsEntries) {
            $scope.loading = false;
            $scope.newsEntries = newsEntries;
        },
        function (error) {
            $scope.loading = false;
            console.error(error);
        }
    );
}]);

controllers.controller('NewsDetailController', ['$scope', '$routeParams', '$window', 'Restangular', function ($scope, $routeParams, $window, Restangular) {

    var id = $routeParams.id;

    $scope.loading = true;
    Restangular.one('newsentry', id).get().then(
        function (newsEntry) {
            $scope.loading = false;
            $scope.newsEntry = newsEntry;
        },
        function (error) {
            $scope.loading = false;
            console.error(error);
        }
    );

    $scope.remove = function (newsEntry) {
        newsEntry.remove().then(
            function () {
                $window.history.back();
            },
            function (error) {
                console.error(error);
            }
        );
    }
}]);

controllers.controller('NewsCreateController', ['$scope', '$location', 'Restangular', function ($scope, $location, Restangular) {

    $scope.submitting = false;
    $scope.newsEntry = {
    };

    $scope.submit = function () {
        $scope.submitting = true;
        Restangular.all('newsentry').post($scope.newsEntry).then(
            function (newsEntry) {
                $scope.submitting = false;
                $location.path('/news/' + newsEntry.id);
            },
            function (error) {
                $scope.submitting = false;
                console.error(error);
            }
        )
    }
}]);

controllers.controller('NewsEditController', ['$scope', '$routeParams', '$location', 'Restangular', function ($scope, $routeParams, $location, Restangular) {

    var id = $routeParams.id;

    $scope.loading = true;
    $scope.submitting = false;

    $scope.loading = true;
    Restangular.one('newsentry', id).get().then(
        function (newsEntry) {
            $scope.loading = false;
            $scope.newsEntry = newsEntry;
        },
        function (error) {
            $scope.loading = false;
            console.error(error);
        }
    );

    $scope.submit = function () {
        $scope.submitting = true;
        $scope.newsEntry.save().then(
            function (newsEntry) {
                $scope.submitting = false;
                $location.path('/news/' + id);
            },
            function (error) {
                $scope.submitting = false;
                console.error(error);
            }
        )
    }
}]);

var controllers = angular.module('ExampleApp.controllers', []);

controllers.controller('IndexController', ['$scope', 'Restangular', function ($scope, Restangular) {

    Restangular.all('newsentry').getList()
        .then(
        function (newsEntries) {
            $scope.newsEntries = newsEntries;
        },
        function (error) {
            console.log(error);
        }
    );
}]);

controllers.controller('NewsDetailController', ['$scope', '$routeParams', '$window', 'Restangular', function ($scope, $routeParams, $window, Restangular) {

    var id = $routeParams.id;

    Restangular.one('newsentry', id).get().then(
        function (newsEntry) {
            $scope.newsEntry = newsEntry;
        },
        function (error) {
            console.log(error);
        }
    );

    $scope.remove = function (newsEntry) {
        newsEntry.remove();
        $window.history.back();
    }
}]);
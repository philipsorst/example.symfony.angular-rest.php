var app = angular.module('ExampleApp', ['ExampleApp.controllers', 'restangular', 'ngRoute'])
    .config(
        [ 'RestangularProvider', '$routeProvider', '$locationProvider', '$httpProvider', function (RestangularProvider, $routeProvider, $locationProvider, $httpProvider) {

            $routeProvider.when('/login', {
                templateUrl: partialsPath + '/login.html',
                controller: 'LoginController'
            });

            $routeProvider.when('/news/create', {
                templateUrl: partialsPath + '/news/edit.html',
                controller: 'NewsCreateController'
            });

            $routeProvider.when('/news/:id/edit', {
                templateUrl: partialsPath + '/news/edit.html',
                controller: 'NewsEditController'
            });

            $routeProvider.when('/news/:id', {
                templateUrl: partialsPath + '/news/detail.html',
                controller: 'NewsDetailController'
            });

            $routeProvider.otherwise({
                templateUrl: partialsPath + '/index.html',
                controller: 'IndexController'
            });

            $locationProvider.hashPrefix('!');

            RestangularProvider.setBaseUrl(restPath);
        } ]

    ).run(['$rootScope', '$location', 'Restangular', function ($rootScope, $location, Restangular) {
        $rootScope.originalPath = $location.path();
        $location.path('/login');
    }]);
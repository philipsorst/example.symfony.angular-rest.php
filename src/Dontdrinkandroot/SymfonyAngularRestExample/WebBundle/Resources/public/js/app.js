var app = angular.module('ExampleApp', ['ExampleApp.controllers', 'restangular', 'ngRoute', 'ngCookies'])
    .config(
        ['RestangularProvider',
        '$routeProvider',
        '$locationProvider',
        '$httpProvider',
        function (RestangularProvider, $routeProvider, $locationProvider, $httpProvider) {

            $routeProvider.when('/login', {
                templateUrl: partialsPath + '/login.html',
                controller: 'LoginController'
            });

            $routeProvider.when('/logout', {
                templateUrl: partialsPath + '/logout.html',
                controller: 'LogoutController'
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
        }]
    ).run(['$rootScope', '$location', function ($rootScope, $location) {
        $rootScope.originalPath = $location.path();
    }]);
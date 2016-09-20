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

            $routeProvider.when('/blogposts/create', {
                templateUrl: partialsPath + '/blogpost/edit.html',
                controller: 'BlogPostCreateController'
            });

            $routeProvider.when('/blogposts/:id/edit', {
                templateUrl: partialsPath + '/blogpost/edit.html',
                controller: 'BlogPostEditController'
            });

            $routeProvider.when('/blogposts/:id', {
                templateUrl: partialsPath + '/blogpost/detail.html',
                controller: 'BlogPostDetailController'
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
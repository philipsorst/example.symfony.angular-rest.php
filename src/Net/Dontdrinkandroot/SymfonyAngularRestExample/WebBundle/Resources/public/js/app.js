var app = angular.module('ExampleApp', ['ExampleApp.controllers', 'restangular', 'ngRoute'])
    .config(
        [ '$routeProvider', '$locationProvider', '$httpProvider', function ($routeProvider, $locationProvider, $httpProvider) {

//            $routeProvider.when('/news/create', {
//                templateUrl: 'partials/news/create.html',
//                controller: NewsCreateController
//            });

            $routeProvider.otherwise({
                templateUrl: partialsPath + '/index.html',
                controller: 'IndexController'
            });

            $locationProvider.hashPrefix('!');
        } ]

    ).run(['$rootScope', function ($rootScope) {
    }]);
var app = angular.module('ExampleApp', ['ExampleApp.controllers', 'restangular', 'ngRoute', 'ngCookies'])
    .config(
        [ 'RestangularProvider', '$routeProvider', '$locationProvider', '$httpProvider', function (RestangularProvider, $routeProvider, $locationProvider, $httpProvider) {

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
        } ]

    ).run(['$rootScope', '$location', '$cookieStore', '$http', 'Restangular', function ($rootScope, $location, $cookieStore, $http, Restangular) {

        $rootScope.originalPath = $location.path();
        $location.path('/login');

        var apiKey = $cookieStore.get('apiKey');
        if (apiKey !== undefined) {
            Restangular.setDefaultHeaders({
                'X-Api-Key': apiKey
            });
            Restangular.one('user', 'me').get().then(
                function (user) {
                    $rootScope.user = user;
                    $rootScope.user.admin = false;
                    if (user.roles.indexOf('ROLE_ADMIN') != -1) {
                        $rootScope.user.admin = true;
                    }
                    $location.path($rootScope.originalPath);
                },
                function (error) {
                    console.log(error);
                    if (error.status === 401 || error.status === 403) {
                        $cookieStore.remove('apiKey');
                        delete $http.defaults.headers.common['X-Auth-Token'];
                    }

                }
            );
        }
    }]);
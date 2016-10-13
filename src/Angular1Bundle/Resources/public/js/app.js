(function () {
    angular.module('ExampleApp', ['ExampleApp.controllers', 'restangular', 'ngRoute', 'ngCookies'])
        .config(config)
        .run(runBlock);
    angular.module('ExampleApp.controllers', []);

    config.$inject = ['RestangularProvider', '$routeProvider', '$locationProvider', '$httpProvider'];

    function config(RestangularProvider, $routeProvider, $locationProvider, $httpProvider) {

        $routeProvider.when('/login', {
            templateUrl: partialsPath + '/login.html',
            controller: 'ExampleApp.controller.login'
        });

        $routeProvider.when('/logout', {
            templateUrl: partialsPath + '/logout.html',
            controller: 'ExampleApp.controller.logout'
        });

        $routeProvider.when('/blogposts/create', {
            templateUrl: partialsPath + '/blogpost/edit.html',
            controller: 'ExampleApp.controller.blogpost.create'
        });

        $routeProvider.when('/blogposts/:id/edit', {
            templateUrl: partialsPath + '/blogpost/edit.html',
            controller: 'ExampleApp.controller.blogpost.edit'
        });

        $routeProvider.when('/blogposts/:id', {
            templateUrl: partialsPath + '/blogpost/detail.html',
            controller: 'ExampleApp.controller.blogpost.detail'
        });

        $routeProvider.otherwise({
            templateUrl: partialsPath + '/index.html',
            controller: 'ExampleApp.controller.index'
        });

        $locationProvider.html5Mode(true);
        $locationProvider.hashPrefix('!');

        RestangularProvider.setBaseUrl(restPath);
    }

    runBlock.$inject = ['$rootScope', '$location'];

    function runBlock($rootScope, $location) {
        $rootScope.originalPath = $location.path();
    }
})();

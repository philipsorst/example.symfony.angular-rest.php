(function () {
    'use strict';

    angular.module('ExampleApp.controllers').controller('ExampleApp.controller.logout', Controller);

    Controller.$inject = ['$scope', '$rootScope', '$http', '$location', '$cookieStore', 'Restangular'];

    function Controller($scope, $rootScope, $http, $location, $cookieStore, Restangular) {

        $cookieStore.remove('apiKey');
        delete $rootScope.user;
        $location.path('/login');
        delete $http.defaults.headers.common['X-Api-Key'];
    }
})();

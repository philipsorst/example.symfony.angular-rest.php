(function () {
    'use strict';

    angular.module('ExampleApp.controllers').controller('ExampleApp.controller.login', Controller);

    Controller.$inject = ['$scope', '$rootScope', '$http', '$routeParams', '$location', '$cookieStore', 'Restangular'];

    function Controller($scope, $rootScope, $http, $routeParams, $location, $cookieStore, Restangular) {

        $scope.submitting = false;
        $scope.credentials = {};

        function redirect() {
            if ($scope.originalPath !== '/login') {
                var redirectTo = $scope.originalPath;
                delete $scope.originalPath;
                $location.path(redirectTo);
            } else {
                $location.path('/');
            }
        }

        function verifyApiKey(apiKey) {
            $scope.submitting = true;
            $http.defaults.headers.common['X-Api-Key'] = apiKey;
            $cookieStore.put('apiKey', apiKey);
            Restangular.one('users', 'me').get().then(
                function (user) {
                    $scope.submitting = false;
                    $rootScope.user = user;
                    $rootScope.user.admin = user.roles.indexOf('ROLE_ADMIN') != -1;
                    redirect();
                },
                function (error) {
                    $scope.submitting = false;
                    console.error(error);
                }
            );
        }

        $scope.submit = function () {
            delete $http.defaults.headers.common['X-Api-Key'];
            $scope.submitting = true;
            Restangular.all('apikeys').post($scope.credentials).then(
                function (apiKeyResponse) {
                    verifyApiKey(apiKeyResponse.key);
                },
                function (error) {
                    $scope.submitting = false;
                    alert('Auth failed');
                    console.error(error);
                    if (error.status === 401 || error.status === 403) {
                        $cookieStore.remove('apiKey');
                        delete $http.defaults.headers.common['X-Api-Key'];
                    }
                }
            )
        };


        var apiKey = $cookieStore.get('apiKey');
        if (apiKey !== undefined) {
            verifyApiKey(apiKey);
        }
    }
})();

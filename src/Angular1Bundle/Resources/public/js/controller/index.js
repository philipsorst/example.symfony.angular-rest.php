(function () {
    'use strict';

    angular.module('ExampleApp.controllers').controller('ExampleApp.controller.index', Controller);

    Controller.$inject = ['$scope', 'Restangular'];

    function Controller($scope, Restangular) {

        $scope.loading = true;
        Restangular.all('blogposts').getList().then(
            function (blogPosts) {
                $scope.loading = false;
                $scope.blogPosts = blogPosts;
            },
            function (error) {
                $scope.loading = false;
                console.error(error);
            }
        );
    }
})();

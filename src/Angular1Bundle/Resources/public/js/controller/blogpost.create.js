(function () {
    'use strict';

    angular.module('ExampleApp.controllers').controller('ExampleApp.controller.blogpost.create', Controller);

    Controller.$inject = ['$scope', '$location', 'Restangular'];

    function Controller($scope, $location, Restangular) {

        $scope.submitting = false;
        $scope.blogPost = {};

        $scope.submit = function () {
            $scope.submitting = true;
            Restangular.all('blogposts').post($scope.blogPost).then(
                function (blogPost) {
                    $scope.submitting = false;
                    $location.path('/blogposts/' + blogPost.id);
                },
                function (error) {
                    $scope.submitting = false;
                    console.error(error);
                }
            )
        }
    }
})();

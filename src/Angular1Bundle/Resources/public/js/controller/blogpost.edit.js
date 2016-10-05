(function () {
    'use strict';

    angular.module('ExampleApp.controllers').controller('ExampleApp.controller.blogpost.edit', Controller);

    Controller.$inject = ['$scope', '$routeParams', '$location', 'Restangular'];

    function Controller($scope, $routeParams, $location, Restangular) {

        var id = $routeParams.id;

        $scope.loading = true;
        $scope.submitting = false;

        $scope.loading = true;
        Restangular.one('blogposts', id).get().then(
            function (blogPost) {
                $scope.loading = false;
                $scope.blogPost = blogPost;
            },
            function (error) {
                $scope.loading = false;
                console.error(error);
            }
        );

        $scope.submit = function () {
            $scope.submitting = true;
            $scope.blogPost.save().then(
                function (blogPost) {
                    $scope.submitting = false;
                    $location.path('/blogposts/' + id);
                },
                function (error) {
                    $scope.submitting = false;
                    console.error(error);
                }
            )
        }
    }
})();

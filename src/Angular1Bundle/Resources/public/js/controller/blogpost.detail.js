(function () {
    'use strict';

    angular.module('ExampleApp.controllers').controller('ExampleApp.controller.blogpost.detail', Controller);

    Controller.$inject = ['$scope', '$routeParams', '$window', 'Restangular'];

    function Controller($scope, $routeParams, $window, Restangular) {

        var id = $routeParams.id;
        $scope.comment = {};

        $scope.loadComments = function () {
            $scope.commentsLoading = true;
            $scope.blogPost.all('comments').getList().then(
                function (comments) {
                    $scope.commentsLoading = false;
                    $scope.comments = comments;
                },
                function (error) {
                    $scope.commentsLoading = false;
                    console.error(error);
                }
            )
        };

        $scope.loading = true;
        Restangular.one('blogposts', id).get().then(
            function (blogPost) {
                $scope.loading = false;
                $scope.blogPost = blogPost;

                $scope.loadComments();
            },
            function (error) {
                $scope.loading = false;
                console.error(error);
            }
        );

        $scope.remove = function (blogPost) {
            blogPost.remove().then(
                function () {
                    $window.history.back();
                },
                function (error) {
                    console.error(error);
                }
            );
        };

        $scope.removeComment = function (comment) {
            comment.remove().then(
                function () {
                    $scope.loadComments();
                },
                function (error) {
                    console.error(error);
                }
            )
        };

        $scope.submitComment = function () {
            $scope.submitting = true;
            $scope.blogPost.all('comments').post($scope.comment).then(
                function (blogPost) {
                    $scope.submitting = false;
                    $scope.comment = '';
                    $scope.loadComments();
                },
                function (error) {
                    $scope.submitting = false;
                    console.error(error);
                }
            )
        };
    }
})();

var controllers = angular.module('ExampleApp.controllers', []);

controllers.controller('IndexController', ['$scope', 'Restangular', function ($scope, Restangular) {

    $scope.loading = true;
    Restangular.all('newsentry').getList()
        .then(
        function (newsEntries) {
            $scope.loading = false;
            $scope.newsEntries = newsEntries;
        },
        function (error) {
            $scope.loading = false;
            console.error(error);
        }
    );
}]);

controllers.controller('NewsDetailController', ['$scope', '$routeParams', '$window', 'Restangular', function ($scope, $routeParams, $window, Restangular) {

    var id = $routeParams.id;
    $scope.comment = {};

    $scope.loadComments = function () {
        $scope.commentsLoading = true;
        $scope.newsEntry.all('comments').getList().then(
            function (comments) {
                $scope.commentsLoading = false;
                $scope.comments = comments;
            },
            function (error) {
                $scope.commentsLoading = false;
                console.error(error);
            }
        )
    }

    $scope.loading = true;
    Restangular.one('newsentry', id).get().then(
        function (newsEntry) {
            $scope.loading = false;
            $scope.newsEntry = newsEntry;

            $scope.loadComments();
        },
        function (error) {
            $scope.loading = false;
            console.error(error);
        }
    );

    $scope.remove = function (newsEntry) {
        newsEntry.remove().then(
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
        $scope.newsEntry.all('comments').post($scope.comment).then(
            function (newsEntry) {
                $scope.submitting = false;
                $scope.loadComments();
            },
            function (error) {
                $scope.submitting = false;
                console.error(error);
            }
        )
    };
}]);

controllers.controller('NewsCreateController', ['$scope', '$location', 'Restangular', function ($scope, $location, Restangular) {

    $scope.submitting = false;
    $scope.newsEntry = {
    };

    $scope.submit = function () {
        $scope.submitting = true;
        Restangular.all('newsentry').post($scope.newsEntry).then(
            function (newsEntry) {
                $scope.submitting = false;
                $location.path('/news/' + newsEntry.id);
            },
            function (error) {
                $scope.submitting = false;
                console.error(error);
            }
        )
    }
}]);

controllers.controller('NewsEditController', ['$scope', '$routeParams', '$location', 'Restangular', function ($scope, $routeParams, $location, Restangular) {

    var id = $routeParams.id;

    $scope.loading = true;
    $scope.submitting = false;

    $scope.loading = true;
    Restangular.one('newsentry', id).get().then(
        function (newsEntry) {
            $scope.loading = false;
            $scope.newsEntry = newsEntry;
        },
        function (error) {
            $scope.loading = false;
            console.error(error);
        }
    );

    $scope.submit = function () {
        $scope.submitting = true;
        $scope.newsEntry.save().then(
            function (newsEntry) {
                $scope.submitting = false;
                $location.path('/news/' + id);
            },
            function (error) {
                $scope.submitting = false;
                console.error(error);
            }
        )
    }
}]);

controllers.controller('LoginController', ['$scope', '$rootScope', '$routeParams', '$location', '$cookieStore', 'Restangular', function ($scope, $rootScope, $routeParams, $location, $cookieStore, Restangular) {

    $scope.submitting = false;
    $scope.credentials = { };

    $scope.submit = function () {
        $scope.submitting = true;
        Restangular.all('user').all('createapikey').post($scope.credentials).then(
            function (apiKeyResponse) {
                Restangular.setDefaultHeaders({
                    'X-Api-Key': apiKeyResponse.key
                });
                $cookieStore.put('apiKey', apiKeyResponse.key);
                Restangular.one('user', 'me').get().then(
                    function (user) {
                        $scope.submitting = false;
                        $rootScope.user = user;
                        $rootScope.user.admin = false;
                        if (user.roles.indexOf('ROLE_ADMIN') != -1) {
                            $rootScope.user.admin = true;
                        }
                        if ($scope.originalPath !== '/login') {
                            var redirectTo = $scope.originalPath;
                            delete $scope.originalPath;
                            $location.path(redirectTo);
                        } else {
                            $location.path('/');
                        }
                    },
                    function (error) {
                        $scope.submitting = false;
                        console.log(error);
                    }
                );
            },
            function (error) {
                $scope.submitting = false;
                alert('Auth failed');
                console.error(error);
                if (error.status === 401 || error.status === 403) {
                    $cookieStore.remove('apiKey');
                    Restangular.setDefaultHeaders({
                        'X-Api-Key': null
                    });
                }
            }
        )
    }
}]);

controllers.controller('LogoutController', ['$scope', '$rootScope', '$location', '$cookieStore', 'Restangular', function ($scope, $rootScope, $location, $cookieStore, Restangular) {

    $cookieStore.remove('apiKey');
    delete $rootScope.user;
    Restangular.setDefaultHeaders({
        'X-Api-Key': null
    });
    $location.path('/login');
}]);
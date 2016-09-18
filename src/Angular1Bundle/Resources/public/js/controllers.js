var controllers = angular.module('ExampleApp.controllers', []);

controllers.controller('IndexController', ['$scope', 'Restangular', function ($scope, Restangular) {

    $scope.loading = true;
    Restangular.all('newsentries').getList().then(
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
    };

    $scope.loading = true;
    Restangular.one('newsentries', id).get().then(
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
    $scope.newsEntry = {};

    $scope.submit = function () {
        $scope.submitting = true;
        Restangular.all('newsentries').post($scope.newsEntry).then(
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
    Restangular.one('newsentries', id).get().then(
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

controllers.controller('LoginController', ['$scope', '$rootScope', '$http', '$routeParams', '$location', '$cookieStore', 'Restangular', function ($scope, $rootScope, $http, $routeParams, $location, $cookieStore, Restangular) {

    $scope.submitting = false;
    $scope.credentials = {};

    function redirect()
    {
        if ($scope.originalPath !== '/login') {
            var redirectTo = $scope.originalPath;
            delete $scope.originalPath;
            $location.path(redirectTo);
        } else {
            $location.path('/');
        }
    }

    function verifyApiKey(apiKey)
    {
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
        Restangular.all('users').all('createapikey').post($scope.credentials).then(
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
}]);

controllers.controller('LogoutController', ['$scope', '$rootScope', '$http', '$location', '$cookieStore', 'Restangular', function ($scope, $rootScope, $http, $location, $cookieStore, Restangular) {

    $cookieStore.remove('apiKey');
    delete $rootScope.user;
    $location.path('/login');
    delete $http.defaults.headers.common['X-Api-Key'];
}]);
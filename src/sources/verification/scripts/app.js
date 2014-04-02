(function() {
  "use strict";
  angular.module("verificationApp", ["ngCookies", "ngResource", "ngSanitize", "ngRoute", "ui.bootstrap"]).config(function($routeProvider, $locationProvider, $httpProvider, $localeProvider) {
    $routeProvider.when("/", {
      templateUrl: "sources/verification/views/_main",
      controller: "MainCtrl"
    }).otherwise({
      redirectTo: "/"
    });
    $locationProvider.html5Mode(true);
    $localeProvider.id = "ru-ru";
    return $httpProvider.interceptors.push([
      "$q", "$location", function($q, $location) {
        return {
          responseError: function(response) {
            if (response.status === 401 || response.status === 403) {
              $location.path("/");
              return $q.reject(response);
            } else {
              return $q.reject(response);
            }
          }
        };
      }
    ]);
  }).run(function($rootScope, $location, Auth) {
    return $rootScope.$on("$routeChangeStart", function(event, next) {
      if (next.authenticate && !Auth.isLoggedIn()) {
        return $location.path("/");
      }
    });
  });

}).call(this);

//# sourceMappingURL=../scripts/app.js.map

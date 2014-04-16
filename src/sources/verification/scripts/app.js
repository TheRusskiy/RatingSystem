(function() {
  "use strict";
  angular.module("verificationApp", ["ngCookies", "ngResource", "ngSanitize", "ngRoute", "ui.bootstrap", "ui.utils"]).config(function($routeProvider, $locationProvider, $httpProvider, $localeProvider) {
    $routeProvider.when("/", {
      templateUrl: "sources/verification/views/_welcome",
      controller: "GuideCtrl"
    }).when("/records", {
      templateUrl: "sources/verification/views/_records",
      controller: "RecordsCtrl"
    }).when("/guide", {
      templateUrl: "sources/verification/views/_user_guide",
      controller: "GuideCtrl"
    }).when("/permissions", {
      templateUrl: "sources/verification/views/_permissions",
      controller: "PermissionsCtrl"
    }).when("/criteria", {
      templateUrl: "sources/verification/views/_criteria",
      controller: "CriteriaCtrl"
    }).when("/criteria/:id", {
      templateUrl: "sources/verification/views/_criteria_edit",
      controller: "CriteriaEditCtrl"
    }).when("/external_records", {
      templateUrl: "sources/verification/views/_external_records",
      controller: "ExternalRecordsCtrl"
    }).otherwise({
      redirectTo: "/"
    });
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

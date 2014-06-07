(function() {
  "use strict";
  angular.module("verificationApp", ["ngCookies", "ngResource", "ngSanitize", "ngRoute", "ui.bootstrap", "ui.utils"]).config(function($routeProvider, $locationProvider, $httpProvider, $localeProvider) {
    $routeProvider.when("/", {
      templateUrl: "sources/verification/views/_welcome.html",
      controller: "GuideCtrl"
    }).when("/records", {
      templateUrl: "sources/verification/views/_records.html",
      controller: "RecordsCtrl"
    }).when("/guide", {
      templateUrl: "sources/verification/views/_user_guide.html",
      controller: "GuideCtrl"
    }).when("/seasons", {
      templateUrl: "sources/verification/views/_seasons.html",
      controller: "SeasonsCtrl"
    }).when("/permissions", {
      templateUrl: "sources/verification/views/_permissions.html",
      controller: "PermissionsCtrl"
    }).when("/criteria", {
      templateUrl: "sources/verification/views/_criteria.html",
      controller: "CriteriaCtrl"
    }).when("/criteria/:id", {
      templateUrl: "sources/verification/views/_criteria_edit.html",
      controller: "CriteriaEditCtrl"
    }).when("/external_records", {
      templateUrl: "sources/verification/views/_external_records.html",
      controller: "ExternalRecordsCtrl"
    }).otherwise({
      redirectTo: "/"
    });
    $localeProvider.id = "ru-ru";
    return $httpProvider.interceptors.push([
      "$q", "$location", "$window", function($q, $location, $window) {
        return {
          responseError: function(response) {
            var new_path;
            if (response.status === 401) {
              alert('Пользователь в текущей сессии не найден, перенаправляем..');
              new_path = $location.protocol() + "://" + $location.host() + ":" + $location.port();
              return $window.location.href = new_path;
            } else if (response.status === 403) {
              $location.path("/");
              $q.reject(response);
              return alert('Отказано в доступе');
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

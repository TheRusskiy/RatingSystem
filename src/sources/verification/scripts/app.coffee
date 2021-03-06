"use strict"

# Intercept 401s and 403s and redirect you to login
angular.module("verificationApp", ["ngCookies", "ngResource", "ngSanitize", "ngRoute", "ui.bootstrap", "ui.utils"]).config(($routeProvider, $locationProvider, $httpProvider, $localeProvider) ->
  $routeProvider.when("/",
    templateUrl: "sources/verification/views/_welcome.html"
    controller: "GuideCtrl"
  ).when("/records",
    templateUrl: "sources/verification/views/_records.html"
    controller: "RecordsCtrl"
  ).when("/guide",
    templateUrl: "sources/verification/views/_user_guide.html"
    controller: "GuideCtrl"
  ).when("/permissions",
    templateUrl: "sources/verification/views/_permissions.html"
    controller: "PermissionsCtrl"
  ).when("/season_criteria/:id",
    templateUrl: "sources/verification/views/_season_criteria.html"
    controller: "SeasonCriteriaCtrl"
  ).when("/criteria",
    templateUrl: "sources/verification/views/_criteria.html"
    controller: "CriteriaCtrl"
  ).when("/criteria/:id",
    templateUrl: "sources/verification/views/_criteria_edit.html"
    controller: "CriteriaEditCtrl"
  ).when("/external_records",
    templateUrl: "sources/verification/views/_external_records.html"
    controller: "ExternalRecordsCtrl"
  ).otherwise redirectTo: "/"
#  $locationProvider.html5Mode true
  $localeProvider.id="ru-ru"
  $httpProvider.interceptors.push ["$q", "$location", "$window", ($q, $location, $window) ->
    responseError: (response) ->
      if response.status is 401
        alert('Пользователь в текущей сессии не найден, перенаправляем..')
        new_path = $location.protocol()+"://"+$location.host()+":"+$location.port()
        $window.location.href = new_path
      else if response.status is 403
        $location.path "/"
        $q.reject response
        alert('Отказано в доступе')
      else
        $q.reject response
  ]
).run ($rootScope, $location, Auth) ->

  # Redirect to login if route requires auth and you're not logged in
  $rootScope.$on "$routeChangeStart", (event, next) ->
    $location.path "/"  if next.authenticate and not Auth.isLoggedIn()


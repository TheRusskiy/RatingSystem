"use strict"

# Intercept 401s and 403s and redirect you to login
angular.module("verificationApp", ["ngCookies", "ngResource", "ngSanitize", "ngRoute", "ui.bootstrap"]).config(($routeProvider, $locationProvider, $httpProvider, $localeProvider) ->
  $routeProvider.when("/",
    templateUrl: "sources/verification/views/_main"
    controller: "RecordsCtrl"
  ).when("/guide",
    templateUrl: "sources/verification/views/_user_guide"
    controller: "GuideCtrl"
  ).when("/permissions",
    templateUrl: "sources/verification/views/_permissions"
    controller: "PermissionsCtrl"
  ).otherwise redirectTo: "/"
#  $locationProvider.html5Mode true
  $localeProvider.id="ru-ru"
  $httpProvider.interceptors.push ["$q", "$location", ($q, $location) ->
    responseError: (response) ->
      if response.status is 401 or response.status is 403
        $location.path "/"
        $q.reject response
      else
        $q.reject response
  ]
).run ($rootScope, $location, Auth) ->

  # Redirect to login if route requires auth and you're not logged in
  $rootScope.$on "$routeChangeStart", (event, next) ->
    $location.path "/"  if next.authenticate and not Auth.isLoggedIn()


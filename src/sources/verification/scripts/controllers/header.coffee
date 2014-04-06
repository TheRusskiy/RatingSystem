"use strict"
angular.module("verificationApp").controller "HeaderCtrl", ($scope, $location) ->
  $scope.goto = (path)->
    $location.path(path)

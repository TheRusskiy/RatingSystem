"use strict"
angular.module("verificationApp").controller "SeasonCriteriaCtrl", (User, $scope, Criteria, Season, $routeParams) ->
  $scope.id = $routeParams.id
  $scope.season = Season.find($scope.id)
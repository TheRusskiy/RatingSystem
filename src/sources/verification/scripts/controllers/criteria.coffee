"use strict"
angular.module("verificationApp").controller "CriteriaCtrl", ($scope, Criteria) ->
  $scope.criteria = Criteria.index()
  $scope.fetch_types = Criteria.fetch_types()
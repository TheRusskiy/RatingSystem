"use strict"
angular.module("verificationApp").controller "PermissionsCtrl", (User, $scope, Criteria) ->
  $scope.users = User.index()
  $scope.criterias = Criteria.index()
  $scope.savePermissions = (user, form)->
    User.update_permissions(user)
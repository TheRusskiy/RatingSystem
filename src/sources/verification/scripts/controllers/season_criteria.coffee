"use strict"
angular.module("verificationApp").controller "SeasonCriteriaCtrl", (User, $scope, Criteria, Season, $routeParams, Version) ->
  $scope.isCollapsed = {}
  $scope.id = $routeParams.id
  $scope.season = Season.find($scope.id)
  $scope.criteria = Criteria.index()
  for c in $scope.criteria
    c.versions()
  $scope.chosen = []
  initial = angular.copy $scope.chosen
  $scope.reset = ()->
    $scope.chosen = []
  $scope.isChanged = ()->
    chosen = $scope.chosen
    if initial.length != chosen.length
      return true
    for v, i in chosen
      if v.id != initial[i].id
        return true
    false

  $scope.save = ()->
    null

  $scope.displayVersion = (version)->
    for c in $scope.chosen
      if c.criteria_id == version.criteria_id
        return false
    true

  $scope.addVersion = (version)->
    $scope.chosen.push version

  $scope.removeVersion = (version)->
    for v, i in $scope.chosen
      if v==version
        $scope.chosen.splice(i, 1)
        break

  $scope.moveUp = (version)->
    for v, i in $scope.chosen
      if v==version and i!=0
        temp = $scope.chosen[i-1]
        $scope.chosen[i-1] = $scope.chosen[i]
        $scope.chosen[i] = temp
        break


  $scope.moveDown = (version)->
    for v, i in $scope.chosen
      if v==version and i!=$scope.chosen.length-1
        temp = $scope.chosen[i+1]
        $scope.chosen[i+1] = $scope.chosen[i]
        $scope.chosen[i] = temp
        break
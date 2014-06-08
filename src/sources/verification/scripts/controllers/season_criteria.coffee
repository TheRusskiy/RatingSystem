"use strict"
angular.module("verificationApp").controller "SeasonCriteriaCtrl", (User, $scope, Criteria, Season, $routeParams, Version) ->
  $scope.isCollapsed = {}
  $scope.id = $routeParams.id
  $scope.season = Season.find($scope.id)
  $scope.criteria = Criteria.index()
  for c in $scope.criteria
    c.versions()
  versions_promise = Season.season_criteria($scope.id)
  initial = []
  $scope.chosen = []
  versions_promise.then (vs)->
    $scope.chosen = vs
    initial = angular.copy vs

  $scope.reset = ()->
    $scope.chosen = angular.copy initial

  $scope.isChanged = ()->
    chosen = $scope.chosen
    if initial.length != chosen.length
      return true
    for v, i in chosen
      if v.id != initial[i].id
        return true
    false

  $scope.save = ()->
    from_server = Season.replace_season_criteria($scope.id, $scope.chosen)
    from_server.then (vs)->
      $scope.chosen = vs
      initial = angular.copy vs

  $scope.displayVersion = (version)->
    for c in $scope.chosen
      if c.criteria_id == version.criteria_id
        return false
    true

  $scope.isChosen = (version)->
    for c in $scope.chosen
      if c.id == version.id
        return true
    false

  $scope.addVersion = (version)->
    $scope.chosen.push version

  $scope.removeVersion = (version)->
    for v, i in $scope.chosen
      if v.id==version.id
        $scope.chosen.splice(i, 1)
        break

  $scope.moveUp = (version)->
    for v, i in $scope.chosen
      if v.id==version.id and i!=0
        temp = $scope.chosen[i-1]
        $scope.chosen[i-1] = $scope.chosen[i]
        $scope.chosen[i] = temp
        break


  $scope.moveDown = (version)->
    for v, i in $scope.chosen
      if v.id==version.id and i!=$scope.chosen.length-1
        temp = $scope.chosen[i+1]
        $scope.chosen[i+1] = $scope.chosen[i]
        $scope.chosen[i] = temp
        break
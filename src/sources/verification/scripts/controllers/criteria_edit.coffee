"use strict"
angular.module("verificationApp").controller "CriteriaEditCtrl", ($scope, Criteria, $routeParams) ->
  $scope.fetch_types = Criteria.fetch_types()
  $scope.calculation_types = Criteria.calculation_types()
  $scope.id = $routeParams.id
  $scope.criteria = if $scope.id is 'new' then new Criteria else Criteria.find($routeParams.id)
  # date
  $scope.dateOptions = {
    'starting-day': 1
  };
  $scope.openDatepicker = ($event, form)->
    $event.preventDefault();
    $event.stopPropagation();
    form.datepickerOpened = true
  $scope.createCriteria = (c)->
    $scope.criteria=Criteria.upsert(c)
    null
  $scope.saveCriteria = (c)->
    $scope.criteria=Criteria.upsert(c)
    null
  $scope.deleteCriteria = (c)->
    return unless confirm("Вы уверены? Удалённый показатель восстановлению не подлежит!")
    null

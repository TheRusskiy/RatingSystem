"use strict"
angular.module("verificationApp").controller "CriteriaEditCtrl", ($scope, Criteria, $routeParams, $rootScope) ->
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
    Criteria.delete(c)
    $rootScope.goto('/criteria')
  $scope.revalidateFetchValue = (form)->
    # required to force validation on fetch value
    form.fetch_value.$setViewValue(form.fetch_value.$viewValue)
    null

  deleteEmptyElements = (arr)->
    i = 0
    len = arr.length
    while i < len
      arr[i] and arr.push(arr[i])
      i++
    arr.splice(0 , len);
    arr
  isInt = (n)->
    return parseFloat(n) is parseInt(n, 10) and not isNaN(n)
  $scope.fetchValueErrors = []
  $scope.validateFetchValue = ($value = "")->
    $scope.fetchValueErrors = []
    if $scope.criteria.fetch_type == 'manual_options'
      value = $value
      multi = ($scope.criteria.multiplier||"").toString()
      console.log 'validating:'
      console.log value
      console.log multi
      values = value.split('|')
      multis = multi.split('|')
      oldLength = values.length
      no_empty_elements = deleteEmptyElements(values).length == oldLength
      correctCount = values.length == multis.length
      formatMatches = value.match /(.+\|)*.+/
      unless correctCount
        $scope.fetchValueErrors.push("Число элементов во множителе и данных не совпадает")
      unless !!formatMatches
        $scope.fetchValueErrors.push("Некорректный формат данных. Данные должны следовать формату (.+\\|)*.+")
      unless no_empty_elements
        $scope.fetchValueErrors.push("Не должно быть пустых элементов")
      correctCount && !!formatMatches && no_empty_elements
    else
      true
  $scope.validateMultiplierValue = ($value = "")->
    $value = $value.toString()
    values = $value.split('|')
    valid = true
    for v in values
      unless isInt(v)
        valid = false
    if $scope.criteria.fetch_type != 'manual_options'
      valid = false unless values.length is 1
    valid

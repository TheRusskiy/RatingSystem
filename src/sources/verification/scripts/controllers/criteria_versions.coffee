"use strict"
angular.module("verificationApp").controller "CriteriaVersionsCtrl", (User, $scope, Criteria, Version) ->
  $scope.versions = Version.index($scope.criteria.id)
  $scope.current_version = {criteria_id: $scope.criteria.id}
#  $scope.users = User.index()
#  $scope.criterias = Criteria.with_records()
#  $scope.savePermissions = (user, form)->
#    User.update_permissions(user)
#
#  $scope.seasons = Season.index()

  $scope.edit_version = (version, form)->
    form.$setPristine()
    $scope.current_version = new Version(version)
#
  $scope.newVersion = ()->
    $scope.current_version = {criteria_id: $scope.criteria.id}

  # date
  $scope.dateOptions = {
    'starting-day': 1
  };
#  $scope.openDatepicker = ($event, form, datepickerOpenedVar = 'datepickerOpened')->
#    $event.preventDefault();
#    $event.stopPropagation();
#    form[datepickerOpenedVar] = true
#
  $scope.saveVersion = (version, form)->
    console.log version
    new_version = new Version(version)
    $scope.current_version = Version.upsert(new_version)
    form.$setPristine()

  $scope.deleteVersion = (version, form)->
    return unless confirm("Вы уверены что хотите удалить эту версию?")
    version = new Version(version)
    Version.delete(version)
    $scope.newVersion()
    form.$setPristine()

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

  $scope.fetchValueErrorsForMultiplier = []
  $scope.validateFetchValueForMultiplier = (form, $value = "")->
    $scope.fetchValueErrorsForMultiplier = []
    if $scope.criteria.fetch_type == 'manual_options' and not form.$pristine
      value = $value
      multi = ($scope.current_version.multiplier||"").toString()
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
        console.log "Число элементов во множителе и данных не совпадает"
        console.log values
        console.log multis
        $scope.fetchValueErrorsForMultiplier.push("Число элементов во множителе и данных не совпадает")
      unless !!formatMatches
        console.log "Некорректный формат данных. Данные должны следовать формату 'название{|название"
        $scope.fetchValueErrorsForMultiplier.push("Некорректный формат данных. Данные должны следовать формату 'название{|название}'")
      unless no_empty_elements
        console.log "Не должно быть пустых элементов"
        $scope.fetchValueErrorsForMultiplier.push("Не должно быть пустых элементов")
      result = correctCount && !!formatMatches && no_empty_elements
      console.log "result"
      console.log result
      result
    else
      true
  $scope.validateMultiplierValueForMutliplier = (form, $value = "")->
    $value = $value.toString()
    values = $value.split('|')
    valid = true
    for v in values
      unless isInt(v)
        valid = false
    if $scope.criteria.fetch_type != 'manual_options'
      valid = false unless values.length is 1
    console.log "valid"
    console.log valid
    valid
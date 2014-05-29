"use strict"
angular.module("verificationApp").controller "PermissionsCtrl", (User, $scope, Criteria, Season) ->
  $scope.users = User.index()
  $scope.criterias = Criteria.with_records()
  $scope.savePermissions = (user, form)->
    User.update_permissions(user)

  $scope.seasons = Season.index()

  $scope.edit_season = (season, form)->
    form.$setPristine()
    $scope.current_season = season
    season.new_id = season.id

  $scope.newSeason = ()->
    $scope.current_season = {}

  # date
  $scope.dateOptions = {
    'starting-day': 1
  };
  $scope.openDatepicker = ($event, form, datepickerOpenedVar = 'datepickerOpened')->
    $event.preventDefault();
    $event.stopPropagation();
    form[datepickerOpenedVar] = true

  $scope.saveSeason = (season, form)->
    console.log season
    new_season = new Season(season)
    $scope.current_season = Season.upsert(new_season)
    form.$setPristine()

  $scope.deleteSeason = (season, form)->
    return unless confirm("Вы уверены что хотите удалить этот интервал?")
    season = new Season(season)
    Season.delete(season)
    $scope.current_season = {}
    form.$setPristine()
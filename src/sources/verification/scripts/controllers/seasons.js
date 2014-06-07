(function() {
  "use strict";
  angular.module("verificationApp").controller("SeasonsCtrl", function(User, $scope, Criteria, Season) {
    $scope.seasons = Season.index();
    $scope.edit_season = function(season, form) {
      form.$setPristine();
      $scope.current_season = season;
      return season.new_id = season.id;
    };
    $scope.newSeason = function() {
      return $scope.current_season = {};
    };
    $scope.dateOptions = {
      'starting-day': 1
    };
    $scope.openDatepicker = function($event, form, datepickerOpenedVar) {
      if (datepickerOpenedVar == null) {
        datepickerOpenedVar = 'datepickerOpened';
      }
      $event.preventDefault();
      $event.stopPropagation();
      return form[datepickerOpenedVar] = true;
    };
    $scope.saveSeason = function(season, form) {
      var new_season;
      console.log(season);
      new_season = new Season(season);
      $scope.current_season = Season.upsert(new_season);
      return form.$setPristine();
    };
    return $scope.deleteSeason = function(season, form) {
      if (!confirm("Вы уверены что хотите удалить этот интервал?")) {
        return;
      }
      season = new Season(season);
      Season["delete"](season);
      $scope.current_season = {};
      return form.$setPristine();
    };
  });

}).call(this);

//# sourceMappingURL=../../scripts/controllers/seasons.js.map

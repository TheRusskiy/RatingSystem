(function() {
  "use strict";
  angular.module("verificationApp").controller("PermissionsCtrl", function(User, $scope, Criteria, Season) {
    $scope.users = User.index();
    $scope.criterias = Criteria.with_records();
    $scope.savePermissions = function(user, form) {
      return User.update_permissions(user);
    };
    $scope.seasons = Season.index();
    $scope.edit_season = function(season, form) {
      form.$setPristine();
      $scope.current_season = new Season(season);
      return $scope.current_season.new_id = season.id;
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
      new_season = new Season(season);
      $scope.current_season = Season.upsert(new_season);
      $scope.current_season.$promise.then(function(s) {
        return $scope.current_season.new_id = season.new_id;
      });
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

//# sourceMappingURL=../../scripts/controllers/permissions.js.map

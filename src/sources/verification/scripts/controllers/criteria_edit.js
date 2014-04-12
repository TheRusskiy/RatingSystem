(function() {
  "use strict";
  angular.module("verificationApp").controller("CriteriaEditCtrl", function($scope, Criteria, $routeParams) {
    $scope.fetch_types = Criteria.fetch_types();
    $scope.calculation_types = Criteria.calculation_types();
    $scope.id = $routeParams.id;
    $scope.criteria = $scope.id === 'new' ? new Criteria : Criteria.find($routeParams.id);
    $scope.dateOptions = {
      'starting-day': 1
    };
    $scope.openDatepicker = function($event, form) {
      $event.preventDefault();
      $event.stopPropagation();
      return form.datepickerOpened = true;
    };
    $scope.createCriteria = function(c) {
      $scope.criteria = Criteria.upsert(c);
      return null;
    };
    $scope.saveCriteria = function(c) {
      $scope.criteria = Criteria.upsert(c);
      return null;
    };
    return $scope.deleteCriteria = function(c) {
      if (!confirm("Вы уверены? Удалённый показатель восстановлению не подлежит!")) {
        return;
      }
      return null;
    };
  });

}).call(this);

//# sourceMappingURL=../../scripts/controllers/criteria_edit.js.map

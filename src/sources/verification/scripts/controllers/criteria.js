(function() {
  "use strict";
  angular.module("verificationApp").controller("CriteriaCtrl", function($scope, Criteria) {
    $scope.criteria = Criteria.index();
    $scope.fetch_types = Criteria.fetch_types();
    return $scope.calculation_types = Criteria.calculation_types();
  });

}).call(this);

//# sourceMappingURL=../../scripts/controllers/criteria.js.map

(function() {
  "use strict";
  angular.module("verificationApp").controller("CriteriaCtrl", function($scope, Criteria) {
    $scope.criteria = Criteria.index();
    return $scope.fetch_types = Criteria.fetch_types();
  });

}).call(this);

//# sourceMappingURL=../../scripts/controllers/criteria.js.map

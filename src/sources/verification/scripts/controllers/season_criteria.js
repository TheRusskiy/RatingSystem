(function() {
  "use strict";
  angular.module("verificationApp").controller("SeasonCriteriaCtrl", function(User, $scope, Criteria, Season, $routeParams) {
    $scope.id = $routeParams.id;
    return $scope.season = Season.find($scope.id);
  });

}).call(this);

//# sourceMappingURL=../../scripts/controllers/season_criteria.js.map

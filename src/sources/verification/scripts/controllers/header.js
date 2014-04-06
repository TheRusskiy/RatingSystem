(function() {
  "use strict";
  angular.module("verificationApp").controller("HeaderCtrl", function($scope, $location) {
    return $scope.goto = function(path) {
      return $location.path(path);
    };
  });

}).call(this);

//# sourceMappingURL=../../scripts/controllers/header.js.map

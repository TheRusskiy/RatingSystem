(function() {
  "use strict";
  angular.module("verificationApp").controller("PermissionsCtrl", function(User, $scope, Criteria) {
    $scope.users = User.index();
    $scope.criterias = Criteria.index();
    return $scope.savePermissions = function(user, form) {
      return User.update_permissions(user);
    };
  });

}).call(this);

//# sourceMappingURL=../../scripts/controllers/permissions.js.map

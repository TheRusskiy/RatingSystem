(function() {
  'use strict';
  angular.module('verificationApp').controller('AppCtrl', function($scope, $http, Auth, $rootScope) {
    if (!$rootScope.currentUser) {
      Auth.currentUser().$promise.then(function(user) {
        console.log(user);
        if (user.id != null) {
          return $rootScope.currentUser = user;
        } else {
          return $rootScope.currentUser = null;
        }
      })["catch"](function(err) {
        return console.log('Current user:' + err.data);
      });
    }
    return $rootScope.logout = function() {
      return Auth.logout();
    };
  });

}).call(this);

//# sourceMappingURL=../../scripts/controllers/app.js.map

(function() {
  'use strict';
  angular.module('verificationApp').controller('AppCtrl', function($scope, $http, Auth, $rootScope, $location, $window) {
    if (!$rootScope.currentUser) {
      Auth.currentUser().$promise.then(function(user) {
        var new_path;
        console.log(user);
        if (user.id != null) {
          return $rootScope.currentUser = user;
        } else {
          $rootScope.currentUser = null;
          alert('Пользователь в текущей сессии не найден, перенаправляем..');
          new_path = $location.protocol() + "://" + $location.host() + ":" + $location.port();
          return $window.location.href = new_path;
        }
      })["catch"](function(err) {
        return console.log('Current user:' + err.data);
      });
    }
    $rootScope.logout = function() {
      return Auth.logout();
    };
    return $scope.location = $location.path();
  });

}).call(this);

//# sourceMappingURL=../../scripts/controllers/app.js.map

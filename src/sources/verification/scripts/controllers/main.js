(function() {
  'use strict';
  angular.module('verificationApp').controller('MainCtrl', function($scope, $http, Auth, $rootScope, $location, $window) {
    if (!$rootScope.currentUser) {
      Auth.currentUser().$promise.then(function(user) {
        var new_path;
        if (user.id != null) {
          $rootScope.currentUser = user;
          return $rootScope.is_admin = user.role === "admin";
        } else {
          $rootScope.currentUser = null;
          alert('Пользователь в текущей сессии не найден, перенаправляем..');
          new_path = $location.protocol() + "://" + $location.host() + ":" + $location.port();
          return $window.location.href = new_path;
        }
      })["catch"](function(err) {
        if (err) {
          return console.log('Authentication error:' + err.data);
        } else {
          return console.log('Authentication error:' + err);
        }
      });
    }
    $rootScope.logout = function() {
      return Auth.logout();
    };
    $scope.location = $location.path();
    return $rootScope.goto = function(path) {
      console.log(path);
      $location.path(path);
      return $scope.location = $location.path();
    };
  });

}).call(this);

//# sourceMappingURL=../../scripts/controllers/main.js.map

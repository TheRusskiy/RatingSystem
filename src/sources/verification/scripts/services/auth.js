(function() {
  "use strict";
  angular.module("verificationApp").factory("Auth", function($location, $rootScope, Session, User, $window) {
    return {
      /*
      Authenticate user
      
      @param  {Object}   user     - login info
      @param  {Function} callback - optional
      @return {Promise}
      */

      login: function(user, callback) {
        var cb;
        cb = callback || angular.noop;
        return Session.save({
          nickname: user.nickname,
          password: user.password
        }, function(user) {
          $rootScope.currentUser = user;
          return cb();
        }, function(err) {
          return cb(err);
        }).$promise;
      },
      /*
      Unauthenticate user
      
      @param  {Function} callback - optional
      @return {Promise}
      */

      logout: function(callback) {
        var cb;
        cb = callback || angular.noop;
        return Session["delete"](function() {
          var new_path;
          $rootScope.currentUser = null;
          new_path = $location.protocol() + "://" + $location.host() + ":" + $location.port();
          $window.location.href = new_path;
          return cb();
        }, function(err) {
          return cb(err);
        }).$promise;
      },
      /*
      Gets all available info on authenticated user
      
      @return {Object} user
      */

      currentUser: function() {
        return User.current();
      },
      /*
      Simple check to see if a user is logged in
      
      @return {Boolean}
      */

      isLoggedIn: function() {
        var user;
        user = $rootScope.currentUser;
        return !!user;
      }
    };
  });

}).call(this);

//# sourceMappingURL=../../scripts/services/auth.js.map

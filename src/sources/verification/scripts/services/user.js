(function() {
  "use strict";
  angular.module("verificationApp").factory("User", function($resource) {
    var Users;
    Users = $resource("/sources/verification/index.php", {
      controller: "users"
    }, {
      current: {
        method: "GET",
        params: {
          id: "me",
          action: "current"
        }
      },
      update: {
        method: "POST",
        params: {
          action: "update"
        }
      },
      query: {
        method: "GET",
        isArray: true,
        params: {
          action: "index"
        }
      }
    });
    Users.index = function() {
      if (this.usersCache) {
        return this.usersCache;
      }
      this.usersCache = Users.query();
      return this.usersCache;
    };
    Users.update_permissions = function(user) {
      return Users.update({
        user_id: user.id
      }, user, function(u) {});
    };
    return Users;
  });

}).call(this);

//# sourceMappingURL=../../scripts/services/user.js.map

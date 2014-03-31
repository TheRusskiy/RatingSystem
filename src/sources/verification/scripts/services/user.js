(function() {
  "use strict";
  angular.module("verificationApp").factory("User", function($resource) {
    return $resource("/sources/verification", {
      controller: "user"
    }, {
      update: {
        method: "PUT",
        params: {}
      },
      get: {
        method: "GET",
        params: {
          id: "@id"
        }
      },
      current: {
        method: "GET",
        params: {
          id: "me",
          action: "current"
        }
      }
    });
  });

}).call(this);

//# sourceMappingURL=../../scripts/services/user.js.map

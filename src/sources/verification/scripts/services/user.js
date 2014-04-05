(function() {
  "use strict";
  angular.module("verificationApp").factory("User", function($resource) {
    return $resource("/sources/verification/index.php", {
      controller: "users"
    }, {
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

(function() {
  "use strict";
  angular.module("verificationApp").factory("Session", function($resource) {
    return $resource("/sources/verification/index.php", {
      controller: "sessions"
    }, {
      "delete": {
        method: "DELETE",
        params: {
          action: "logout"
        }
      }
    });
  });

}).call(this);

//# sourceMappingURL=../../scripts/services/session.js.map

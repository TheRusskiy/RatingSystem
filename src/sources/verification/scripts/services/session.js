(function() {
  "use strict";
  angular.module("verificationApp").factory("Session", function($resource) {
    return $resource("/api/session/");
  });

}).call(this);

//# sourceMappingURL=../../scripts/services/session.js.map

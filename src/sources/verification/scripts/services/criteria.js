(function() {
  "use strict";
  angular.module("verificationApp").factory("Criteria", function($resource) {
    var criteria;
    criteria = $resource("/sources/verification/index.php", {
      controller: "criteria"
    }, {
      query: {
        method: "GET",
        isArray: true,
        params: {
          action: "index"
        }
      }
    });
    return {
      index: function() {
        console.log('criteria index');
        if (this.criteriaCache) {
          return this.criteriaCache;
        }
        this.criteriaCache = criteria.query();
        return this.criteriaCache;
      }
    };
  });

}).call(this);

//# sourceMappingURL=../../scripts/services/criteria.js.map

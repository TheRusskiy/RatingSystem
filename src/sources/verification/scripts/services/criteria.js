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
          action: "with_records"
        }
      },
      fetch_types: {
        method: "GET",
        params: {
          action: "fetch_types"
        }
      },
      calculation_types: {
        method: "GET",
        params: {
          action: "calculation_types"
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
      },
      with_records: function() {
        console.log('criteria with records');
        if (this.withRecordsCache) {
          return this.withRecordsCache;
        }
        this.withRecordsCache = criteria.query();
        return this.withRecordsCache;
      },
      fetch_types: function() {
        console.log('fetch types');
        if (this.fetchTypesCache) {
          return this.fetchTypesCache;
        }
        this.fetchTypesCache = criteria.fetch_types();
        return this.fetchTypesCache;
      },
      calculation_types: function() {
        console.log('fetch types');
        if (this.calcTypesCache) {
          return this.calcTypesCache;
        }
        this.calcTypesCache = criteria.calculation_types();
        return this.calcTypesCache;
      }
    };
  });

}).call(this);

//# sourceMappingURL=../../scripts/services/criteria.js.map

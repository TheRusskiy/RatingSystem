(function() {
  "use strict";
  angular.module("verificationApp").factory("Criteria", function($resource) {
    var criteria, resetCache;
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
      get: {
        method: "GET",
        params: {
          action: "show"
        }
      },
      save: {
        method: "POST",
        params: {
          action: "create"
        }
      },
      update: {
        method: "POST",
        params: {
          action: "update"
        }
      },
      fetch_types_index: {
        method: "GET",
        params: {
          action: "fetch_types"
        }
      },
      calculation_types_index: {
        method: "GET",
        params: {
          action: "calculation_types"
        }
      }
    });
    resetCache = function() {
      criteria.criteriaCache = null;
      return criteria.withRecordsCache = null;
    };
    criteria.index = function() {
      console.log('criteria index');
      if (this.criteriaCache) {
        return this.criteriaCache;
      }
      this.criteriaCache = criteria.query();
      return this.criteriaCache;
    };
    criteria.with_records = function() {
      console.log('criteria with records');
      if (this.withRecordsCache) {
        return this.withRecordsCache;
      }
      this.withRecordsCache = criteria.query();
      return this.withRecordsCache;
    };
    criteria.fetch_types = function() {
      console.log('fetch types');
      if (this.fetchTypesCache) {
        return this.fetchTypesCache;
      }
      this.fetchTypesCache = criteria.fetch_types_index();
      return this.fetchTypesCache;
    };
    criteria.calculation_types = function() {
      console.log('fetch types');
      if (this.calcTypesCache) {
        return this.calcTypesCache;
      }
      this.calcTypesCache = criteria.calculation_types_index();
      return this.calcTypesCache;
    };
    criteria.find = function(id) {
      console.log('find criteria ' + id);
      return criteria.get({
        id: id
      });
    };
    criteria.upsert = function(c) {
      if (c.id) {
        return criteria.update({}, c, function(new_c) {
          console.log("Updated:");
          console.log(new_c);
          resetCache();
          return new_c;
        });
      } else {
        return criteria.$save({}, c, function(new_c) {
          console.log("Updated:");
          console.log(new_c);
          resetCache();
          return new_c;
        });
      }
    };
    return criteria;
  });

}).call(this);

//# sourceMappingURL=../../scripts/services/criteria.js.map

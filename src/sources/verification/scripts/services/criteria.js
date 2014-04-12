(function() {
  "use strict";
  angular.module("verificationApp").factory("Criteria", function($resource) {
    var Criteria, resetCache;
    Criteria = $resource("/sources/verification/index.php", {
      controller: "criteria"
    }, {
      query: {
        method: "GET",
        isArray: true,
        params: {
          action: "index"
        }
      },
      with_records_query: {
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
      delete_criteria: {
        method: "DELETE",
        params: {
          action: "delete"
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
      console.log("reset criteria cache");
      Criteria.criteriaCache = null;
      return Criteria.withRecordsCache = null;
    };
    Criteria.index = function() {
      console.log('criteria index');
      if (this.criteriaCache) {
        return this.criteriaCache;
      }
      this.criteriaCache = Criteria.query();
      return this.criteriaCache;
    };
    Criteria.with_records = function() {
      console.log('criteria with records');
      if (this.withRecordsCache) {
        return this.withRecordsCache;
      }
      this.withRecordsCache = Criteria.with_records_query();
      return this.withRecordsCache;
    };
    Criteria.fetch_types = function() {
      console.log('fetch types');
      if (this.fetchTypesCache) {
        return this.fetchTypesCache;
      }
      this.fetchTypesCache = Criteria.fetch_types_index();
      return this.fetchTypesCache;
    };
    Criteria.calculation_types = function() {
      console.log('fetch types');
      if (this.calcTypesCache) {
        return this.calcTypesCache;
      }
      this.calcTypesCache = Criteria.calculation_types_index();
      return this.calcTypesCache;
    };
    Criteria.find = function(id) {
      console.log('find criteria ' + id);
      return Criteria.get({
        id: id
      });
    };
    Criteria["delete"] = function(c) {
      console.log("deleting criteria");
      console.log(c);
      return Criteria.delete_criteria({
        criteria_id: c.id
      }, function(response) {
        console.log(response);
        return resetCache();
      });
    };
    Criteria.upsert = function(c) {
      if (c.id) {
        return Criteria.update({}, c, function(new_c) {
          console.log("Updated:");
          console.log(new_c);
          resetCache();
          return new_c;
        });
      } else {
        return Criteria.save({}, c, function(new_c) {
          console.log("Updated:");
          console.log(new_c);
          resetCache();
          return new_c;
        });
      }
    };
    return Criteria;
  });

}).call(this);

//# sourceMappingURL=../../scripts/services/criteria.js.map

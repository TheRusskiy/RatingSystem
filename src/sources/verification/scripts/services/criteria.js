(function() {
  "use strict";
  angular.module("verificationApp").factory("Criteria", function($resource, Version) {
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
      }
    });
    resetCache = function() {
      console.log("reset criteria cache");
      Criteria.criteriaCache = null;
      return Criteria.withRecordsCache = null;
    };
    Criteria.resetCache = resetCache;
    Criteria.prototype.versions = function() {
      var _this = this;
      if (this.versionsCache) {
        return this.versionsCache;
      }
      this.versionsCache = Version.index(this.id);
      this.versionsCache.$promise.then(function(vs) {
        var v, _i, _len, _results;
        _results = [];
        for (_i = 0, _len = vs.length; _i < _len; _i++) {
          v = vs[_i];
          _results.push(v.criteria = {
            id: _this.id,
            name: _this.name,
            fetch_type: _this.fetch_type,
            fetch_value: _this.fetch_value,
            external_records: _this.external_records,
            description: _this.description
          });
        }
        return _results;
      });
      return this.versionsCache;
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
    Criteria.find = function(id) {
      console.log('find criteria ' + id);
      return Criteria.get({
        id: id
      });
    };
    Criteria["delete"] = function(c) {
      console.log("deleting criteria");
      console.log(c);
      Criteria.delete_criteria({
        criteria_id: c.id
      }, function(response) {
        console.log(response);
        return resetCache();
      });
      return resetCache();
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

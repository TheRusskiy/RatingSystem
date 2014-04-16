(function() {
  "use strict";
  angular.module("verificationApp").factory("ExternalRecord", function($resource) {
    var External, externalCache;
    External = $resource("/sources/verification/index.php", {
      controller: "external_records"
    }, {
      query: {
        method: "GET",
        isArray: true,
        params: {
          action: "index"
        }
      },
      record_approve: {
        method: "GET",
        params: {
          action: "approve"
        }
      },
      record_reject: {
        method: "GET",
        params: {
          action: "reject"
        }
      },
      save: {
        method: "POST",
        params: {
          action: "create"
        }
      },
      delete_record: {
        method: "DELETE",
        params: {
          action: "delete"
        }
      }
    });
    externalCache = {};
    External.index = function(criteria_id) {
      console.log('external records index');
      if (externalCache[criteria_id]) {
        return externalCache[criteria_id];
      }
      externalCache[criteria_id] = External.query({
        criteria: criteria_id
      });
      return externalCache[criteria_id];
    };
    External.create = function(record) {
      return record.$save({}, function(r) {
        console.log("External created:");
        console.log(record);
        return r;
      });
    };
    External["delete"] = function(record) {
      return External.delete_record({
        record_id: record.id
      }, function(response) {
        return console.log(response);
      });
    };
    External.approve = function(record) {
      if (!confirm("Вы уверены?")) {
        return;
      }
      return External.record_approve(record, {}, function(r) {
        var i, rec, _i, _len, _ref;
        console.log("approved:");
        console.log(r);
        _ref = externalCache[record.criteria_id];
        for (i = _i = 0, _len = _ref.length; _i < _len; i = ++_i) {
          rec = _ref[i];
          if (rec.id.toString() === record.id.toString()) {
            externalCache[record.criteria_id].splice(i, 1);
            break;
          }
        }
        return r;
      });
    };
    External.reject = function(record) {
      if (!confirm("Вы уверены?")) {
        return;
      }
      return External.record_reject(record, {}, function(r) {
        var i, rec, _i, _len, _ref;
        console.log("rejected:");
        console.log(r);
        _ref = externalCache[record.criteria_id];
        for (i = _i = 0, _len = _ref.length; _i < _len; i = ++_i) {
          rec = _ref[i];
          if (rec.id.toString() === record.id.toString()) {
            externalCache[record.criteria_id].splice(i, 1);
            break;
          }
        }
        return r;
      });
    };
    External.clearCache = function() {
      return externalCache = {};
    };
    return External;
  });

}).call(this);

//# sourceMappingURL=../../scripts/services/external_record.js.map

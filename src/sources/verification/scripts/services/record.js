(function() {
  "use strict";
  angular.module("verificationApp").factory("Record", function($resource) {
    var Record, countPerPage, recordsCache, recordsCountCache;
    Record = $resource("/sources/verification/index.php", {
      controller: "records"
    }, {
      query: {
        method: "GET",
        isArray: true,
        params: {
          action: "index"
        }
      },
      record_count: {
        method: "GET",
        params: {
          action: "count"
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
      }
    });
    recordsCache = {};
    recordsCountCache = {};
    countPerPage = 3;
    Record.upsert = function(record) {
      if (record.id) {
        return Record.update({}, record, function(r) {
          console.log("Updated:");
          return console.log(r);
        });
      } else {
        return record.$save(function(r) {
          console.log(recordsCache);
          recordsCache[r.criteria_id][1].push(r);
          console.log("Created:");
          console.log(r);
          return console.log(recordsCache[r.criteria_id][1]);
        });
      }
    };
    Record.prototype["delete"] = function() {
      var i, position, r, _i, _len;
      position = null;
      for (i = _i = 0, _len = Record.length; _i < _len; i = ++_i) {
        r = Record[i];
        if (r.id = this.id) {
          position = i;
          break;
        }
      }
      Record.splice(position, 1);
      console.log("Deleted");
      return console.log(Record);
    };
    Record.countPerPage = countPerPage;
    Record.index = function(criteria_id, pageNumber) {
      if (pageNumber == null) {
        pageNumber = 1;
      }
      console.log('record index');
      if (recordsCache[criteria_id] == null) {
        recordsCache[criteria_id] = {};
      }
      if (recordsCache[criteria_id][pageNumber]) {
        return recordsCache[criteria_id][pageNumber];
      }
      recordsCache[criteria_id][pageNumber] = Record.query({
        criteria: criteria_id,
        page: pageNumber,
        page_length: countPerPage
      });
      console.log("writing to page " + pageNumber);
      return recordsCache[criteria_id][pageNumber];
    };
    Record.count = function(criteria_id) {
      if (recordsCountCache[criteria_id]) {
        return recordsCountCache[criteria_id];
      }
      recordsCountCache[criteria_id] = 100;
      Record.record_count({
        criteria_id: criteria_id
      }, function(result) {
        console.log("count");
        console.log(result);
        return recordsCountCache[criteria_id] = result.count;
      });
      return recordsCountCache[criteria_id];
    };
    return Record;
  });

}).call(this);

//# sourceMappingURL=../../scripts/services/record.js.map

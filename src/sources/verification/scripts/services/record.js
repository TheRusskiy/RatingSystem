(function() {
  "use strict";
  angular.module("verificationApp").factory("Record", function($resource) {
    var Record, countPerPage, recordsCache, recordsCountCache, recordsSearchCache, recordsSearchCountCache;
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
      search_query: {
        method: "GET",
        isArray: true,
        params: {
          action: "search"
        }
      },
      record_count: {
        method: "GET",
        params: {
          action: "count"
        }
      },
      record_search_count: {
        method: "GET",
        params: {
          action: "search_count"
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
      delete_record: {
        method: "DELETE",
        params: {
          action: "delete"
        }
      }
    });
    recordsCache = {};
    recordsSearchCache = {};
    recordsCountCache = {};
    recordsSearchCountCache = {};
    countPerPage = 10;
    Record.upsert = function(record) {
      if (record.id) {
        return Record.update({}, record, function(r) {
          console.log("Updated:");
          console.log(r);
          return r;
        });
      } else {
        return record.$save({}, function(r) {
          console.log(recordsCache);
          recordsCache[r.criteria_id][1].unshift(r);
          console.log("Created:");
          console.log(r);
          console.log(recordsCache[r.criteria_id][1]);
          return r;
        });
      }
    };
    Record["delete"] = function(record) {
      var cachePage, i, key, position, r, _i, _j, _len, _len1, _ref, _ref1;
      console.log("cache pages");
      console.log(recordsCache[record.criteria_id]);
      _ref = recordsCache[record.criteria_id];
      for (key in _ref) {
        cachePage = _ref[key];
        console.log("cachePage");
        console.log(cachePage);
        position = null;
        for (i = _i = 0, _len = cachePage.length; _i < _len; i = ++_i) {
          r = cachePage[i];
          if (r.id === record.id) {
            position = i;
            cachePage.splice(position, 1);
            console.log("Deleted");
            break;
          }
        }
      }
      if (recordsSearchCache[record.criteria_id]) {
        _ref1 = recordsSearchCache[record.criteria_id];
        for (key in _ref1) {
          cachePage = _ref1[key];
          console.log("cachePage");
          console.log(cachePage);
          position = null;
          for (i = _j = 0, _len1 = cachePage.length; _j < _len1; i = ++_j) {
            r = cachePage[i];
            if (r.id === record.id) {
              position = i;
              cachePage.splice(position, 1);
              console.log("Deleted");
              break;
            }
          }
        }
      }
      return Record.delete_record({
        record_id: record.id
      }, function(response) {
        return console.log(response);
      });
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
    Record.searchCount = function(criteria_id, record_template) {
      if (recordsSearchCountCache[criteria_id]) {
        return recordsSearchCountCache[criteria_id];
      }
      recordsSearchCountCache[criteria_id] = 100;
      Record.record_search_count({
        criteria_id: criteria_id,
        search: record_template
      }, function(result) {
        console.log("search count");
        console.log(result);
        return recordsSearchCountCache[criteria_id] = result.count;
      });
      return recordsSearchCountCache[criteria_id];
    };
    Record.search = function(criteria_id, record_template, pageNumber) {
      if (pageNumber == null) {
        pageNumber = 1;
      }
      console.log('record search');
      if (recordsSearchCache[criteria_id] == null) {
        recordsSearchCache[criteria_id] = {};
      }
      if (recordsSearchCache[criteria_id][pageNumber]) {
        return recordsSearchCache[criteria_id][pageNumber];
      }
      recordsSearchCache[criteria_id][pageNumber] = Record.search_query({
        criteria: criteria_id,
        page: pageNumber,
        page_length: countPerPage,
        search: record_template
      });
      console.log("writing to search page " + pageNumber);
      return recordsSearchCache[criteria_id][pageNumber];
    };
    Record.newSearch = function(criteria_id) {
      recordsSearchCache[criteria_id] = {};
      return recordsSearchCountCache[criteria_id] = null;
    };
    return Record;
  });

}).call(this);

//# sourceMappingURL=../../scripts/services/record.js.map

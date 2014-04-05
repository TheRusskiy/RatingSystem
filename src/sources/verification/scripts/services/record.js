(function() {
  "use strict";
  angular.module("verificationApp").factory("Record", function($resource) {
    var MyRecord, countPerPage, curId, generateId, records;
    records = $resource("/sources/verification/index.php", {
      controller: "records"
    }, {
      query: {
        method: "GET",
        isArray: true,
        params: {
          action: "index"
        }
      }
    });
    curId = 5;
    generateId = function() {
      curId += 1;
      return curId;
    };
    countPerPage = 2;
    MyRecord = function(source) {
      var key, value;
      this.source = source;
      for (key in source) {
        value = source[key];
        this[key] = value;
      }
      return this;
    };
    MyRecord.prototype.save = function() {
      if (this.id) {
        return;
      }
      this.id = generateId();
      this.source.id = this.id;
      records.push(this);
      console.log("Saved");
      return console.log(records);
    };
    MyRecord.prototype["delete"] = function() {
      var i, position, r, _i, _len;
      position = null;
      for (i = _i = 0, _len = records.length; _i < _len; i = ++_i) {
        r = records[i];
        if (r.id = this.id) {
          position = i;
          break;
        }
      }
      records.splice(position, 1);
      console.log("Deleted");
      return console.log(records);
    };
    MyRecord.countPerPage = countPerPage;
    MyRecord.index = function(criteria_id, pageNumber) {
      if (pageNumber == null) {
        pageNumber = 1;
      }
      console.log('record index');
      if (this.recordsCache) {
        return this.recordsCache;
      }
      this.recordsCache = records.query({
        criteria: criteria_id
      });
      return this.recordsCache;
    };
    MyRecord.count = function(criteria_id) {
      return 4;
    };
    return MyRecord;
  });

}).call(this);

//# sourceMappingURL=../../scripts/services/record.js.map

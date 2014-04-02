(function() {
  "use strict";
  var __indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

  angular.module("verificationApp").factory("Record", function($resource) {
    var MyRecord, countPerPage, curId, generateId, r, records, _i, _len;
    records = [
      {
        id: 1,
        criteria_id: 1,
        date: "01.02.2013",
        name: "Победа в областной олимпиаде по математике",
        option: {
          value: 1,
          name: "1 место"
        },
        teacher: {
          id: 1,
          name: "Прохоров Сергей Антонович"
        },
        user: {
          id: 202,
          name: "Ишков Д.С."
        },
        notes: [1, 2, 3]
      }, {
        id: 2,
        criteria_id: 1,
        date: "01.02.2013",
        name: "Победа в областной олимпиаде по физике",
        option: {
          value: 2,
          name: "2 место"
        },
        teacher: {
          id: 1,
          name: "Прохоров Сергей Антонович"
        },
        user: {
          id: 202,
          name: "Ишков Д.С."
        },
        notes: [4, 5]
      }, {
        id: 3,
        criteria_id: 1,
        date: "01.01.2014",
        name: "Победа в областной олимпиаде по информатике",
        option: {
          value: 3,
          name: "3 место"
        },
        teacher: {
          id: 1,
          name: "Прохоров Сергей Антонович"
        },
        user: {
          id: 202,
          name: "Ишков Д.С."
        },
        notes: []
      }, {
        id: 4,
        criteria_id: 2,
        date: "01.01.2014",
        name: "Публикация в журнале 'Мурзилка'",
        teacher: {
          id: 2,
          name: "Востокин Сергей Владимирович"
        },
        user: {
          id: 202,
          name: "Ишков Д.С."
        },
        notes: []
      }, {
        id: 5,
        criteria_id: 3,
        date: "01.05.2014",
        name: "Ашот Каберханян Фываолдж",
        teacher: {
          id: 3,
          name: "Иващенко Антон Владимирович"
        },
        user: {
          id: 202,
          name: "Ишков Д.С."
        },
        notes: []
      }
    ];
    curId = 5;
    generateId = function() {
      curId += 1;
      return curId;
    };
    countPerPage = 2;
    MyRecord = function(attrs) {
      var key, value;
      for (key in attrs) {
        value = attrs[key];
        this[key] = value;
      }
      return this;
    };
    MyRecord.prototype.save = function() {
      this.id = generateId();
      records.push(this);
      return console.log(records);
    };
    MyRecord.countPerPage = countPerPage;
    MyRecord.index = function(criteria_id, pageNumber) {
      var i, r, result, subset, _i, _j, _len, _ref, _ref1, _results;
      if (pageNumber == null) {
        pageNumber = 1;
      }
      console.log('records');
      pageNumber = pageNumber - 1;
      subset = records.filter(function(e) {
        return e.criteria_id === criteria_id;
      });
      result = [];
      for (i = _i = 0, _len = subset.length; _i < _len; i = ++_i) {
        r = subset[i];
        if (__indexOf.call((function() {
          _results = [];
          for (var _j = _ref = pageNumber * countPerPage, _ref1 = (pageNumber + 1) * countPerPage; _ref <= _ref1 ? _j < _ref1 : _j > _ref1; _ref <= _ref1 ? _j++ : _j--){ _results.push(_j); }
          return _results;
        }).apply(this), i) >= 0) {
          result.push(r);
        }
      }
      return result;
    };
    MyRecord.count = function(criteria_id) {
      var length;
      console.log('count');
      length = (records.filter(function(e) {
        return e.criteria_id === criteria_id;
      })).length;
      return length;
    };
    for (_i = 0, _len = records.length; _i < _len; _i++) {
      r = records[_i];
      r.$remove = function() {
        return console.log("Removing record " + r.id.toString());
      };
      r.prototype = MyRecord;
    }
    return MyRecord;
  });

}).call(this);

//# sourceMappingURL=../../scripts/services/record.js.map

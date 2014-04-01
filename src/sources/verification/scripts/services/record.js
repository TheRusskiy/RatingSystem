(function() {
  "use strict";
  var __indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

  angular.module("verificationApp").factory("Record", function($resource) {
    var countPerPage, r, records, _i, _len;
    records = [
      {
        id: 1,
        criteria_id: 1,
        date: "01.02.2013",
        name: "Победа в областной олимпиаде по математике",
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
    countPerPage = 2;
    for (_i = 0, _len = records.length; _i < _len; _i++) {
      r = records[_i];
      r.$remove = function() {
        return console.log("Removing record " + r.id.toString());
      };
    }
    return {
      countPerPage: countPerPage,
      index: function(criteria_id, pageNumber) {
        var i, result, subset, _j, _k, _len1, _ref, _ref1, _results;
        if (pageNumber == null) {
          pageNumber = 1;
        }
        pageNumber = pageNumber - 1;
        subset = records.filter(function(e) {
          return e.criteria_id === criteria_id;
        });
        result = [];
        for (i = _j = 0, _len1 = subset.length; _j < _len1; i = ++_j) {
          r = subset[i];
          if (__indexOf.call((function() {
            _results = [];
            for (var _k = _ref = pageNumber * countPerPage, _ref1 = (pageNumber + 1) * countPerPage; _ref <= _ref1 ? _k < _ref1 : _k > _ref1; _ref <= _ref1 ? _k++ : _k--){ _results.push(_k); }
            return _results;
          }).apply(this), i) >= 0) {
            result.push(r);
          }
        }
        return result;
      },
      count: function(criteria_id) {
        var length;
        length = (records.filter(function(e) {
          return e.criteria_id === criteria_id;
        })).length;
        return length;
      }
    };
  });

}).call(this);

//# sourceMappingURL=../../scripts/services/record.js.map

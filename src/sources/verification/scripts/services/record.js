(function() {
  "use strict";
  angular.module("verificationApp").factory("Record", function($resource) {
    var r, records, _i, _len;
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
        name: "Победа в областной олимпиаде по математике",
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
        criteria_id: 2,
        date: "01.01.2014",
        name: "Публикация в журнале 'Мурзилка'",
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
        criteria_id: 3,
        date: "01.05.2014",
        name: "Ашот Каберханян Фываолдж",
        teacher: {
          id: 1,
          name: "Прохоров Сергей Антонович"
        },
        user: {
          id: 202,
          name: "Ишков Д.С."
        },
        notes: []
      }
    ];
    for (_i = 0, _len = records.length; _i < _len; _i++) {
      r = records[_i];
      r.$remove = function() {
        return console.log("Removing record " + r.id.toString());
      };
    }
    return {
      index: function(criteria_id) {
        return records.filter(function(e) {
          return e.criteria_id === criteria_id;
        });
      }
    };
  });

}).call(this);

//# sourceMappingURL=../../scripts/services/record.js.map

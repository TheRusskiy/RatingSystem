(function() {
  "use strict";
  angular.module("verificationApp").factory("Teacher", function($resource) {
    var teachers;
    teachers = [
      {
        id: 1,
        name: "Прохоров Сергей Антонович"
      }, {
        id: 2,
        name: "Востокин Сергей Владимирович"
      }, {
        id: 3,
        name: "Иващенко Антон Владимирович"
      }
    ];
    return {
      index: function() {
        return teachers;
      }
    };
  });

}).call(this);

//# sourceMappingURL=../../scripts/services/teacher.js.map

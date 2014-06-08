(function() {
  "use strict";
  angular.module("verificationApp").factory("Teacher", function($resource) {
    var teachers;
    teachers = $resource("/sources/verification/index.php", {
      controller: "teachers"
    }, {
      query: {
        method: "GET",
        isArray: true,
        params: {
          action: "index"
        }
      }
    });
    return {
      index: function() {
        if (this.teachersCache) {
          return this.teachersCache;
        }
        this.teachersCache = teachers.query();
        return this.teachersCache;
      }
    };
  });

}).call(this);

//# sourceMappingURL=../../scripts/services/teacher.js.map

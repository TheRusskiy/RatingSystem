(function() {
  "use strict";
  angular.module("verificationApp").filter("allowed_criteria", function() {
    return function(items, user) {
      var filtered;
      filtered = [];
      angular.forEach(items, function(item) {
        if (user.permissions[item.id.toString()]) {
          filtered.push(item);
        }
      });
      return filtered;
    };
  });

}).call(this);

//# sourceMappingURL=../../scripts/filters/allowed_criteria.js.map

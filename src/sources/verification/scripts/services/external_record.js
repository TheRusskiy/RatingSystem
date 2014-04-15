(function() {
  "use strict";
  angular.module("verificationApp").factory("ExternalRecord", function($resource) {
    var External, externalCache, records;
    External = $resource("/sources/verification/index.php", {
      controller: "external_record"
    }, {
      query: {
        method: "GET",
        isArray: true,
        params: {
          action: "index"
        }
      }
    });
    records = [
      {
        id: 1,
        criteria_id: 1,
        description: 'Some description',
        date: '2014-04-02',
        notes: [],
        teacher: {
          id: 1,
          name: 'Some Name'
        },
        status: 'new',
        created_by: {
          id: 1,
          name: "some dude"
        },
        reviewed_by: {
          id: 1,
          name: "verification"
        }
      }, {
        id: 2,
        criteria_id: 1,
        description: 'Some description sadsdasda    sdasdasda dassda',
        date: '2014-04-03',
        notes: [4, 5],
        teacher: {
          id: 2,
          name: 'Some other name'
        },
        status: 'new',
        created_by: {
          id: 1,
          name: "some dude"
        },
        reviewed_by: {
          id: 1,
          name: "verification"
        }
      }, {
        id: 3,
        criteria_id: 1,
        description: 'Some description adssdasda',
        date: '2014-04-04',
        notes: [1, 2, 3],
        teacher: {
          id: 1,
          name: 'Yet another name'
        },
        status: 'new',
        created_by: {
          id: 1,
          name: "some dude"
        },
        reviewed_by: {
          id: 1,
          name: "verification"
        }
      }
    ];
    externalCache = {};
    External.index = function(criteria_id) {
      console.log('external records index');
      if (externalCache[criteria_id]) {
        return externalCache[criteria_id];
      }
      externalCache[criteria_id] = records;
      return externalCache[criteria_id];
    };
    return External;
  });

}).call(this);

//# sourceMappingURL=../../scripts/services/external_record.js.map

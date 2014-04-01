(function() {
  "use strict";
  angular.module("verificationApp").factory("RecordNote", function($resource) {
    var note, notes, _i, _len;
    notes = [
      {
        id: 1,
        record_id: 1,
        user_id: 201,
        user_name: "Ишков Д.С.",
        text: "Lorem ipsum dolor sit amet"
      }, {
        id: 2,
        record_id: 1,
        user_id: 202,
        user_name: "Муравьева Е.В.",
        text: "Lorem ipsum dolor sit amet asdasdasda"
      }, {
        id: 3,
        record_id: 1,
        user_id: 201,
        user_name: "Ишков Д.С.",
        text: "Lorem ipsum dolor ssdasdasdait amet"
      }, {
        id: 4,
        record_id: 2,
        user_id: 201,
        user_name: "Ишков Д.С.",
        text: "Lorem ipsum dsdasdasdaolor sit amet"
      }, {
        id: 5,
        record_id: 2,
        user_id: 202,
        user_name: "Муравьева Е.В.",
        text: "Loremsdasdasdasda ipsum dolor sit amet"
      }
    ];
    for (_i = 0, _len = notes.length; _i < _len; _i++) {
      note = notes[_i];
      note.$remove = function() {
        return console.log("Removing note " + note.id.toString());
      };
    }
    return {
      index: function(record_id) {
        return notes.filter(function(e) {
          return e.record_id === record_id;
        });
      }
    };
  });

}).call(this);

//# sourceMappingURL=../../scripts/services/record_note.js.map

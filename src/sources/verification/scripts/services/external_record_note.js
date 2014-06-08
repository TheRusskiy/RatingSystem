(function() {
  "use strict";
  angular.module("verificationApp").factory("ExternalRecordNote", function($resource) {
    var ExternalRecordNote, externalNotesCache;
    ExternalRecordNote = $resource("/sources/verification/index.php", {
      controller: "external_record_notes"
    }, {
      query: {
        method: "GET",
        isArray: true,
        params: {
          action: "index"
        }
      },
      save: {
        method: "POST",
        params: {
          action: "create"
        }
      },
      delete_note: {
        method: "DELETE",
        params: {
          action: "delete"
        }
      }
    });
    externalNotesCache = {};
    ExternalRecordNote.insert = function(note) {
      return note.$save({}, function(n) {
        return externalNotesCache[n.record_id].push(n);
      });
    };
    ExternalRecordNote["delete"] = function(note) {
      var i, n, notesArray, position, _i, _len;
      position = null;
      notesArray = externalNotesCache[note.record_id];
      for (i = _i = 0, _len = notesArray.length; _i < _len; i = ++_i) {
        n = notesArray[i];
        if (n.id.toString() === note.id.toString()) {
          position = i;
          notesArray.splice(position, 1);
          break;
        }
      }
      return ExternalRecordNote.delete_note({
        note_id: note.id
      }, function(response) {});
    };
    ExternalRecordNote.index = function(record_id) {
      if (externalNotesCache[record_id]) {
        return externalNotesCache[record_id];
      }
      externalNotesCache[record_id] = ExternalRecordNote.query({
        record: record_id
      });
      return externalNotesCache[record_id];
    };
    return ExternalRecordNote;
  });

}).call(this);

//# sourceMappingURL=../../scripts/services/external_record_note.js.map

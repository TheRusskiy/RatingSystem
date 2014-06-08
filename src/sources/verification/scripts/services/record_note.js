(function() {
  "use strict";
  angular.module("verificationApp").factory("RecordNote", function($resource) {
    var RecordNote, notesCache;
    RecordNote = $resource("/sources/verification/index.php", {
      controller: "record_notes"
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
    notesCache = {};
    RecordNote.insert = function(note) {
      return note.$save({}, function(n) {
        return notesCache[n.record_id].push(n);
      });
    };
    RecordNote["delete"] = function(note) {
      var i, n, notesArray, position, _i, _len;
      position = null;
      notesArray = notesCache[note.record_id];
      for (i = _i = 0, _len = notesArray.length; _i < _len; i = ++_i) {
        n = notesArray[i];
        if (n.id.toString() === note.id.toString()) {
          position = i;
          notesArray.splice(position, 1);
          break;
        }
      }
      return RecordNote.delete_note({
        note_id: note.id
      }, function(response) {});
    };
    RecordNote.index = function(record_id) {
      if (notesCache[record_id]) {
        return notesCache[record_id];
      }
      notesCache[record_id] = RecordNote.query({
        record: record_id
      });
      return notesCache[record_id];
    };
    return RecordNote;
  });

}).call(this);

//# sourceMappingURL=../../scripts/services/record_note.js.map

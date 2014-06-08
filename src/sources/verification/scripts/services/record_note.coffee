"use strict"
angular.module("verificationApp").factory "RecordNote", ($resource) ->
  RecordNote = $resource "/sources/verification/index.php", {controller: "record_notes"},
    query:
      method: "GET"
      isArray:true
      params:
        action: "index"
    save:
      method: "POST"
      params:
        action: "create"
    delete_note:
      method: "DELETE"
      params:
        action: "delete"
  notesCache = {}

  RecordNote.insert = (note)->
    note.$save {}, (n)->
      notesCache[n.record_id].push(n)

  RecordNote.delete = (note)->
    position = null
    notesArray = notesCache[note.record_id]
    for n, i in notesArray
      if n.id.toString() is note.id.toString()
        position = i
        notesArray.splice(position, 1)
        break
    RecordNote.delete_note {note_id: note.id}, (response)->

  RecordNote.index = (record_id)->
    return notesCache[record_id] if notesCache[record_id]
    notesCache[record_id] = RecordNote.query(
      record: record_id
    )
    return notesCache[record_id]

  return RecordNote

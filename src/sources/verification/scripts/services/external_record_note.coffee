"use strict"
angular.module("verificationApp").factory "ExternalRecordNote", ($resource) ->
  ExternalRecordNote = $resource "/sources/verification/index.php", {controller: "external_record_notes"},
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
  externalNotesCache = {}

  ExternalRecordNote.insert = (note)->
    note.$save {}, (n)->
      externalNotesCache[n.record_id].push(n)

  ExternalRecordNote.delete = (note)->
    position = null
    notesArray = externalNotesCache[note.record_id]
    for n, i in notesArray
      if n.id.toString() is note.id.toString()
        position = i
        notesArray.splice(position, 1)
        break
    ExternalRecordNote.delete_note {note_id: note.id}, (response)->

  ExternalRecordNote.index = (record_id)->
    return externalNotesCache[record_id] if externalNotesCache[record_id]
    externalNotesCache[record_id] = ExternalRecordNote.query(
      record: record_id
    )
    return externalNotesCache[record_id]

  return ExternalRecordNote

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
      console.log notesCache
      notesCache[n.record_id].push(n)
      console.log("Created:")
      console.log(n)
      console.log(notesCache[n.record_id])

  RecordNote.delete = (note)->
    position = null
    notesArray = notesCache[note.record_id]
    for n, i in notesArray
      if n.id.toString() is note.id.toString()
        position = i
        notesArray.splice(position, 1)
        console.log("Deleted")
        break
    RecordNote.delete_note {note_id: note.id}, (response)->
      console.log(response)

  RecordNote.index = (record_id)->
    console.log 'notes index'
    return notesCache[record_id] if notesCache[record_id]
    notesCache[record_id] = RecordNote.query(
      record: record_id
    )
    console.log notesCache[record_id]
    return notesCache[record_id]

  return RecordNote

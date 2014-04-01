"use strict"
angular.module("verificationApp").factory "RecordNote", ($resource) ->
  notes = [
    {
      id: 1
      record_id: 1
      user_id: 201
      user_name: "Ишков Д.С."
      text: "Lorem ipsum dolor sit amet"
    }
    {
      id: 2
      record_id: 1
      user_id: 202
      user_name: "Муравьева Е.В."
      text: "Lorem ipsum dolor sit amet asdasdasda"
    }
    {
      id: 3
      record_id: 1
      user_id: 201
      user_name: "Ишков Д.С."
      text: "Lorem ipsum dolor ssdasdasdait amet"
    }
    {
      id: 4
      record_id: 2
      user_id: 201
      user_name: "Ишков Д.С."
      text: "Lorem ipsum dsdasdasdaolor sit amet"
    }
    {
      id: 5
      record_id: 2
      user_id: 202
      user_name: "Муравьева Е.В."
      text: "Loremsdasdasdasda ipsum dolor sit amet"
    }
  ]
  for note in notes
    note.$remove = ()-> console.log("Removing note "+note.id.toString())
  return {
      index: (record_id)->
        notes.filter (e)-> e.record_id == record_id
    }



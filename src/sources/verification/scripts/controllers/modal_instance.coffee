"use strict"
angular.module("verificationApp").controller "ModalInstanceCtrl", ($scope, $modalInstance, record, RecordNote)->
    $scope.record = record
    $scope.notes = RecordNote.index(record.id)
    record.notes = $scope.notes
    $scope.new_note = {}
    $scope.removeNote = (note)->
      RecordNote.delete(note)

    $scope.addNote = (form)->
      note = $scope.new_note
      note.record_id = record.id
      console.log note
      note = new RecordNote(note)
      RecordNote.insert(note)
      $scope.new_note = {}
      form.$setPristine()
    $scope.close = ()->
      $modalInstance.close()

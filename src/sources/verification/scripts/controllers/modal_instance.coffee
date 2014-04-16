"use strict"
angular.module("verificationApp").controller "ModalInstanceCtrl", ($scope, $modalInstance, record, Note)->
    $scope.record = record
    $scope.notes = Note.index(record.id)
    record.notes = $scope.notes
    $scope.new_note = {}
    $scope.removeNote = (note)->
      Note.delete(note)

    $scope.addNote = (form)->
      note = $scope.new_note
      note.record_id = record.id
      console.log note
      note = new Note(note)
      Note.insert(note)
      $scope.new_note = {}
      form.$setPristine()
    $scope.close = ()->
      $modalInstance.close()

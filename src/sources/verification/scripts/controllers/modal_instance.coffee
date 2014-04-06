"use strict"
angular.module("verificationApp").controller "ModalInstanceCtrl", ($scope, $modalInstance, record, RecordNote)->
    $scope.record = record
    $scope.notes = RecordNote.index(record.id)
    record.notes = $scope.notes
    $scope.removeNote = (note)->
      notes = $scope.notes
      position = notes.indexOf(note)
      note.$remove()
      notes.splice(position, 1)

    $scope.close = ()->
      $modalInstance.close()

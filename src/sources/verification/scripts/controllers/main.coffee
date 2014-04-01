"use strict"
angular.module("verificationApp").controller "MainCtrl", ($scope, $http, $modal, Record, Criteria) ->
  $scope.criterias = Criteria.index()
  $scope.teachers = [
    {
      id: 1
      name: "Прохоров Сергей Антонович"
    }
  ]

  ModalInstanceCtrl = ($scope, $modalInstance, record, RecordNote)->
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

  $scope.displayNotes = (record)->
    modalInstance = $modal.open({
      templateUrl: 'notesModal.html',
      controller: ModalInstanceCtrl
      resolve:
        record: ()-> record
    })
    $scope.cancel = ()->
      $modalInstance.dismiss('cancel')
  $scope.records = Record.index


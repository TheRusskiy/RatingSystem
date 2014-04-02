"use strict"
angular.module("verificationApp").controller "MainCtrl", ($scope, $http, $modal, Record, Criteria, Teacher) ->
  $scope.criterias = Criteria.index()
  $scope.teachers = Teacher.index()

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
  $scope.recordCount = Record.count
  $scope.countPerPage = Record.countPerPage

  # date
  $scope.dateOptions = {
    'starting-day': 1
  };
  $scope.openDatepicker = ($event, form)->
    $event.preventDefault();
    $event.stopPropagation();
    form.datepickerOpened = true
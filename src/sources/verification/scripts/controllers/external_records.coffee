"use strict"
angular.module("verificationApp").controller "ExternalRecordsCtrl", ($scope, $http, $modal, Record, Criteria, Teacher, ExternalRecord) ->
  $scope.criterias = Criteria.with_records()
  $scope.teachers = Teacher.index()

  $scope.displayNotes = (record)->
    modalInstance = $modal.open({
      templateUrl: 'sources/verification/views/_notes_modal',
      controller: "ModalInstanceCtrl"
#      windowClass: "notes-modal"
      resolve:
        record: ()-> record
    })

  # date
  $scope.dateOptions = {
    'starting-day': 1
  };
  $scope.openDatepicker = ($event, form, datepickerOpenedVar = 'datepickerOpened')->
    $event.preventDefault();
    $event.stopPropagation();
    form[datepickerOpenedVar] = true

  $scope.newRecord = (criteria)->
    criteria.current_record = new Record({criteria_id: criteria.id})
    criteria.form.$setPristine()

  $scope.deleteRecord = (criteria, form)->
    return unless confirm("Вы уверены что хотите удалить эту запись?")
    record = new Record(criteria.current_record)
    Record.delete(record)
    criteria.current_record = {criteria_id: criteria.id}
    form.$setPristine()
  $scope.externalRecords = (criteria_id)->
    ExternalRecord.all(criteria_id)

  $scope.createExternalRecord = (record)->
    record = new ExternalRecord(record)
    ExternalRecord.create(record)

  $scope.deleteExternalRecord = (record)->
    return unless confirm("Вы уверены, что хотите удалить эту запись?")
    ExternalRecord.delete(record)

  $scope.statusToClass = (status)->
    return "success" if status == 'approved'
    return "danger" if status == 'rejected'
    return "" if status == 'new'

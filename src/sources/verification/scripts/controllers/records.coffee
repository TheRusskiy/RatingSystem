"use strict"
angular.module("verificationApp").controller "RecordsCtrl", ($scope, $http, $modal, Record, Criteria, Teacher) ->
  $scope.criterias = Criteria.index()
  $scope.teachers = Teacher.index()

  $scope.displayNotes = (record)->
    modalInstance = $modal.open({
      templateUrl: 'sources/verification/views/_notes_modal',
      controller: "ModalInstanceCtrl"
#      windowClass: "notes-modal"
      resolve:
        record: ()-> record
    })
  $scope.records = Record.index
  $scope.recordCount = (criteria_id)->
    Record.count(criteria_id)
  $scope.countPerPage = Record.countPerPage

  # date
  $scope.dateOptions = {
    'starting-day': 1
  };
  $scope.openDatepicker = ($event, form)->
    $event.preventDefault();
    $event.stopPropagation();
    form.datepickerOpened = true

  restore_option = (criteria)->
    record = criteria.current_record
    for o in criteria.options # set to existing option object
      if o.value.toString() == record.option.value.toString()
        record.option = o
        break

  $scope.saveRecord = (criteria, form)->
    console.log criteria.current_record
    new_record = new Record(criteria.current_record)
    Record.upsert(new_record).then (resolved_record)->
      criteria.current_record=resolved_record
      restore_option(criteria)

  $scope.editRecord = (record, criteria)->
    criteria.current_record = record
    restore_option(criteria)

  $scope.newRecord = (criteria)->
    criteria.current_record = {criteria_id: criteria.id}
    criteria.form.$setPristine()

  $scope.deleteRecord = (criteria, form)->
    return unless confirm("Вы уверены что хотите удалить эту запись?")
    record = new Record(criteria.current_record)
    Record.delete(record)
    criteria.current_record = {criteria_id: criteria.id}
    form.$setPristine()
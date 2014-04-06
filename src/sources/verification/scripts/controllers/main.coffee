"use strict"
angular.module("verificationApp").controller "MainCtrl", ($scope, $http, $modal, Record, Criteria, Teacher) ->
  $scope.criterias = Criteria.index()
  $scope.teachers = Teacher.index()

  $scope.displayNotes = (record)->
    modalInstance = $modal.open({
      templateUrl: 'sources/verification/views/_notes_modal',
      controller: "ModalInstanceCtrl"
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
  $scope.saveRecord = (criteria, form)->
    console.log criteria.current_record
    record = new Record(criteria.current_record)
    Record.upsert(record)
    null
#    criteria.current_record = {criteria_id: criteria.id}
#    form.$setPristine()

  $scope.editRecord = (record, criteria)->
    criteria.current_record = record
    for o in criteria.options # set to existing option object
      if o.value.toString() == record.option.value.toString()
        record.option = o
        break

  $scope.newRecord = (criteria)->
    criteria.current_record = {criteria_id: criteria.id}
    criteria.form.$setPristine()

  $scope.deleteRecord = (criteria, form)->
    return unless confirm("Вы уверены что хотите удалить эту запись?")
    record = new Record(criteria.current_record)
    Record.delete(record)
    criteria.current_record = {criteria_id: criteria.id}
    form.$setPristine()
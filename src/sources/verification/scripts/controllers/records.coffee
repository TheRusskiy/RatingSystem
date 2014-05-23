"use strict"
angular.module("verificationApp").controller "RecordsCtrl", ($scope, $http, $modal, Record, Criteria, Teacher, ExternalRecord, RecordNote, ExternalRecordNote) ->
  $scope.criterias = Criteria.with_records()
  $scope.teachers = Teacher.index()

  $scope.displayNotes = (record)->
    modalInstance = $modal.open({
      templateUrl: 'sources/verification/views/_notes_modal.html',
      controller: "ModalInstanceCtrl"
      resolve:
        record: ()-> record
        Note: ()-> RecordNote
    })
  $scope.displayExternalNotes = (record)->
    modalInstance = $modal.open({
      templateUrl: 'sources/verification/views/_notes_modal.html',
      controller: "ModalInstanceCtrl"
      resolve:
        record: ()-> record
        Note: ()-> ExternalRecordNote
    })
  $scope.records = (criteria, page)->
    if criteria.search_mode
      Record.search(criteria.id, criteria.search_record, page)
    else
      Record.index(criteria.id, page)

  $scope.searchRecords = (criteria)->
    Record.newSearch(criteria.id)
    criteria.search_mode = true

  $scope.clearSearch = (criteria)->
    criteria.search_mode = false

  $scope.recordCount = (criteria)->
    if criteria.search_mode
      Record.searchCount(criteria.id, criteria.search_record)
    else
      Record.count(criteria.id)
  $scope.countPerPage = Record.countPerPage

  # date
  $scope.dateOptions = {
    'starting-day': 1
  };
  $scope.openDatepicker = ($event, form, datepickerOpenedVar = 'datepickerOpened')->
    $event.preventDefault();
    $event.stopPropagation();
    form[datepickerOpenedVar] = true

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
      console.log "Resolved record"
      console.log resolved_record
      criteria.original_record = new Record(resolved_record)
      criteria.current_record = new Record(resolved_record)
      restore_option(criteria)

  $scope.editRecord = (record, criteria)->
    criteria.original_record = new Record(record)
    criteria.current_record = new Record(record)
    restore_option(criteria)

  $scope.recordEdited = (criteria)->
    equal = true
    for key, value of criteria.current_record
      if key is 'option'
        if criteria.original_record.option.value.toString() != value.value.toString()
          console.log criteria.original_record.option.value
          console.log value.value
          equal = false
      else
        if JSON.stringify(value) != JSON.stringify(criteria.original_record[key])
          console.log JSON.stringify(value)
          console.log JSON.stringify(criteria.original_record[key])
          equal = false
          break
    console.log "EQUAL "+equal.toString()
    not equal

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
    ExternalRecord.index(criteria_id)

  $scope.approveExternalRecord = (record)->
    record = new ExternalRecord(record)
    ExternalRecord.approve(record)

  $scope.rejectExternalRecord = (record)->
    record = new ExternalRecord(record)
    ExternalRecord.reject(record)

  $scope.newRecordByTemplate = (criteria, template)->
    criteria.current_record = new Record({
      criteria_id: criteria.id
      name: template.description
      teacher: template.teacher
      date: template.date
    })
    criteria.form.$setPristine()
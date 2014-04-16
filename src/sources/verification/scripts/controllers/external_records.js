(function() {
  "use strict";
  angular.module("verificationApp").controller("ExternalRecordsCtrl", function($scope, $http, $modal, Record, Criteria, Teacher, ExternalRecord) {
    $scope.criterias = Criteria.with_records();
    $scope.teachers = Teacher.index();
    $scope.displayNotes = function(record) {
      var modalInstance;
      return modalInstance = $modal.open({
        templateUrl: 'sources/verification/views/_notes_modal',
        controller: "ModalInstanceCtrl",
        resolve: {
          record: function() {
            return record;
          }
        }
      });
    };
    $scope.dateOptions = {
      'starting-day': 1
    };
    $scope.openDatepicker = function($event, form, datepickerOpenedVar) {
      if (datepickerOpenedVar == null) {
        datepickerOpenedVar = 'datepickerOpened';
      }
      $event.preventDefault();
      $event.stopPropagation();
      return form[datepickerOpenedVar] = true;
    };
    $scope.newRecord = function(criteria) {
      criteria.current_record = new Record({
        criteria_id: criteria.id
      });
      return criteria.form.$setPristine();
    };
    $scope.deleteRecord = function(criteria, form) {
      var record;
      if (!confirm("Вы уверены что хотите удалить эту запись?")) {
        return;
      }
      record = new Record(criteria.current_record);
      Record["delete"](record);
      criteria.current_record = {
        criteria_id: criteria.id
      };
      return form.$setPristine();
    };
    $scope.externalRecords = function(criteria_id) {
      return ExternalRecord.all(criteria_id);
    };
    $scope.createExternalRecord = function(record) {
      record = new ExternalRecord(record);
      return ExternalRecord.create(record);
    };
    return $scope.deleteExternalRecord = function(record) {
      return ExternalRecord["delete"](record);
    };
  });

}).call(this);

//# sourceMappingURL=../../scripts/controllers/external_records.js.map

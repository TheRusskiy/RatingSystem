(function() {
  "use strict";
  angular.module("verificationApp").controller("RecordsCtrl", function($scope, $http, $modal, Record, Criteria, Teacher) {
    var restore_option;
    $scope.criterias = Criteria.index();
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
    $scope.records = Record.index;
    $scope.recordCount = function(criteria_id) {
      return Record.count(criteria_id);
    };
    $scope.countPerPage = Record.countPerPage;
    $scope.dateOptions = {
      'starting-day': 1
    };
    $scope.openDatepicker = function($event, form) {
      $event.preventDefault();
      $event.stopPropagation();
      return form.datepickerOpened = true;
    };
    restore_option = function(criteria) {
      var o, record, _i, _len, _ref, _results;
      record = criteria.current_record;
      _ref = criteria.options;
      _results = [];
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        o = _ref[_i];
        if (o.value.toString() === record.option.value.toString()) {
          record.option = o;
          break;
        } else {
          _results.push(void 0);
        }
      }
      return _results;
    };
    $scope.saveRecord = function(criteria, form) {
      var new_record;
      console.log(criteria.current_record);
      new_record = new Record(criteria.current_record);
      return Record.upsert(new_record).then(function(resolved_record) {
        criteria.current_record = resolved_record;
        return restore_option(criteria);
      });
    };
    $scope.editRecord = function(record, criteria) {
      criteria.current_record = record;
      return restore_option(criteria);
    };
    $scope.newRecord = function(criteria) {
      criteria.current_record = {
        criteria_id: criteria.id
      };
      return criteria.form.$setPristine();
    };
    return $scope.deleteRecord = function(criteria, form) {
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
  });

}).call(this);

//# sourceMappingURL=../../scripts/controllers/records.js.map

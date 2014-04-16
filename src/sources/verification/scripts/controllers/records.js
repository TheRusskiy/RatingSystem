(function() {
  "use strict";
  angular.module("verificationApp").controller("RecordsCtrl", function($scope, $http, $modal, Record, Criteria, Teacher, ExternalRecord) {
    var restore_option;
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
    $scope.records = function(criteria, page) {
      if (criteria.search_mode) {
        return Record.search(criteria.id, criteria.search_record, page);
      } else {
        return Record.index(criteria.id, page);
      }
    };
    $scope.searchRecords = function(criteria) {
      Record.newSearch(criteria.id);
      return criteria.search_mode = true;
    };
    $scope.clearSearch = function(criteria) {
      return criteria.search_mode = false;
    };
    $scope.recordCount = function(criteria) {
      if (criteria.search_mode) {
        return Record.searchCount(criteria.id, criteria.search_record);
      } else {
        return Record.count(criteria.id);
      }
    };
    $scope.countPerPage = Record.countPerPage;
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
        console.log("Resolved record");
        console.log(resolved_record);
        criteria.original_record = new Record(resolved_record);
        criteria.current_record = new Record(resolved_record);
        return restore_option(criteria);
      });
    };
    $scope.editRecord = function(record, criteria) {
      criteria.original_record = new Record(record);
      criteria.current_record = new Record(record);
      return restore_option(criteria);
    };
    $scope.recordEdited = function(criteria) {
      var equal, key, value, _ref;
      equal = true;
      _ref = criteria.current_record;
      for (key in _ref) {
        value = _ref[key];
        if (key === 'option') {
          if (criteria.original_record.option.value.toString() !== value.value.toString()) {
            console.log(criteria.original_record.option.value);
            console.log(value.value);
            equal = false;
          }
        } else {
          if (JSON.stringify(value) !== JSON.stringify(criteria.original_record[key])) {
            console.log(JSON.stringify(value));
            console.log(JSON.stringify(criteria.original_record[key]));
            equal = false;
            break;
          }
        }
      }
      console.log("EQUAL " + equal.toString());
      return !equal;
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
      return ExternalRecord.index(criteria_id);
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

//# sourceMappingURL=../../scripts/controllers/records.js.map

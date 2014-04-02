(function() {
  "use strict";
  angular.module("verificationApp").controller("MainCtrl", function($scope, $http, $modal, Record, Criteria, Teacher) {
    var ModalInstanceCtrl;
    $scope.criterias = Criteria.index();
    $scope.teachers = Teacher.index();
    ModalInstanceCtrl = function($scope, $modalInstance, record, RecordNote) {
      $scope.record = record;
      $scope.notes = RecordNote.index(record.id);
      record.notes = $scope.notes;
      $scope.removeNote = function(note) {
        var notes, position;
        notes = $scope.notes;
        position = notes.indexOf(note);
        note.$remove();
        return notes.splice(position, 1);
      };
      return $scope.close = function() {
        return $modalInstance.close();
      };
    };
    $scope.displayNotes = function(record) {
      var modalInstance;
      modalInstance = $modal.open({
        templateUrl: 'notesModal.html',
        controller: ModalInstanceCtrl,
        resolve: {
          record: function() {
            return record;
          }
        }
      });
      return $scope.cancel = function() {
        return $modalInstance.dismiss('cancel');
      };
    };
    $scope.records = Record.index;
    $scope.recordCount = Record.count;
    $scope.countPerPage = Record.countPerPage;
    $scope.dateOptions = {
      'starting-day': 1
    };
    $scope.openDatepicker = function($event, form) {
      $event.preventDefault();
      $event.stopPropagation();
      return form.datepickerOpened = true;
    };
    $scope.addRecord = function(criteria, form) {
      var record;
      record = new Record(criteria.current_record);
      record.save();
      criteria.current_record = {
        criteria_id: criteria.id
      };
      return form.$setPristine();
    };
    $scope.saveRecord = function(criteria, form) {
      var record;
      record = criteria.current_record;
      return record.save();
    };
    $scope.editRecord = function(record, criteria) {
      var o, _i, _len, _ref, _results;
      criteria.current_record = record;
      _ref = criteria.options;
      _results = [];
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        o = _ref[_i];
        if (o.value === record.option.value) {
          record.option = o;
          break;
        } else {
          _results.push(void 0);
        }
      }
      return _results;
    };
    return $scope.newRecord = function(criteria) {
      criteria.current_record = {
        criteria_id: criteria.id
      };
      return criteria.form.$setPristine();
    };
  });

}).call(this);

//# sourceMappingURL=../../scripts/controllers/main.js.map

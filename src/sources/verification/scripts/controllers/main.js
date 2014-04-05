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
    $scope.saveRecord = function(criteria, form) {
      var record;
      console.log(criteria.current_record);
      record = new Record(criteria.current_record);
      Record.upsert(record);
      return null;
    };
    $scope.editRecord = function(record, criteria) {
      var o, _i, _len, _ref, _results;
      criteria.current_record = record;
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
      record["delete"]();
      criteria.current_record = {
        criteria_id: criteria.id
      };
      return form.$setPristine();
    };
  });

}).call(this);

//# sourceMappingURL=../../scripts/controllers/main.js.map

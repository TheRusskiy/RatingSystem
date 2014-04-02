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
    return $scope.openDatepicker = function($event, form) {
      $event.preventDefault();
      $event.stopPropagation();
      return form.datepickerOpened = true;
    };
  });

}).call(this);

//# sourceMappingURL=../../scripts/controllers/main.js.map

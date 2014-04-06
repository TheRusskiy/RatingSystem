(function() {
  "use strict";
  angular.module("verificationApp").controller("ModalInstanceCtrl", function($scope, $modalInstance, record, RecordNote) {
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
  });

}).call(this);

//# sourceMappingURL=../../scripts/controllers/modal_instance.js.map

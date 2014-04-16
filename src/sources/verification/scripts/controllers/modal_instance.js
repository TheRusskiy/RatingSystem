(function() {
  "use strict";
  angular.module("verificationApp").controller("ModalInstanceCtrl", function($scope, $modalInstance, record, Note) {
    $scope.record = record;
    $scope.notes = Note.index(record.id);
    record.notes = $scope.notes;
    $scope.new_note = {};
    $scope.removeNote = function(note) {
      return Note["delete"](note);
    };
    $scope.addNote = function(form) {
      var note;
      note = $scope.new_note;
      note.record_id = record.id;
      console.log(note);
      note = new Note(note);
      Note.insert(note);
      $scope.new_note = {};
      return form.$setPristine();
    };
    return $scope.close = function() {
      return $modalInstance.close();
    };
  });

}).call(this);

//# sourceMappingURL=../../scripts/controllers/modal_instance.js.map

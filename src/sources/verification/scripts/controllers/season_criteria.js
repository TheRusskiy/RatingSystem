(function() {
  "use strict";
  angular.module("verificationApp").controller("SeasonCriteriaCtrl", function(User, $scope, Criteria, Season, $routeParams, Version) {
    var c, initial, _i, _len, _ref;
    $scope.isCollapsed = {};
    $scope.id = $routeParams.id;
    $scope.season = Season.find($scope.id);
    $scope.criteria = Criteria.index();
    _ref = $scope.criteria;
    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
      c = _ref[_i];
      c.versions();
    }
    $scope.chosen = [];
    initial = angular.copy($scope.chosen);
    $scope.reset = function() {
      return $scope.chosen = [];
    };
    $scope.isChanged = function() {
      var chosen, i, v, _j, _len1;
      chosen = $scope.chosen;
      if (initial.length !== chosen.length) {
        return true;
      }
      for (i = _j = 0, _len1 = chosen.length; _j < _len1; i = ++_j) {
        v = chosen[i];
        if (v.id !== initial[i].id) {
          return true;
        }
      }
      return false;
    };
    $scope.save = function() {
      return null;
    };
    $scope.displayVersion = function(version) {
      var _j, _len1, _ref1;
      _ref1 = $scope.chosen;
      for (_j = 0, _len1 = _ref1.length; _j < _len1; _j++) {
        c = _ref1[_j];
        if (c.criteria_id === version.criteria_id) {
          return false;
        }
      }
      return true;
    };
    $scope.addVersion = function(version) {
      return $scope.chosen.push(version);
    };
    $scope.removeVersion = function(version) {
      var i, v, _j, _len1, _ref1, _results;
      _ref1 = $scope.chosen;
      _results = [];
      for (i = _j = 0, _len1 = _ref1.length; _j < _len1; i = ++_j) {
        v = _ref1[i];
        if (v === version) {
          $scope.chosen.splice(i, 1);
          break;
        } else {
          _results.push(void 0);
        }
      }
      return _results;
    };
    $scope.moveUp = function(version) {
      var i, temp, v, _j, _len1, _ref1, _results;
      _ref1 = $scope.chosen;
      _results = [];
      for (i = _j = 0, _len1 = _ref1.length; _j < _len1; i = ++_j) {
        v = _ref1[i];
        if (v === version && i !== 0) {
          temp = $scope.chosen[i - 1];
          $scope.chosen[i - 1] = $scope.chosen[i];
          $scope.chosen[i] = temp;
          break;
        } else {
          _results.push(void 0);
        }
      }
      return _results;
    };
    return $scope.moveDown = function(version) {
      var i, temp, v, _j, _len1, _ref1, _results;
      _ref1 = $scope.chosen;
      _results = [];
      for (i = _j = 0, _len1 = _ref1.length; _j < _len1; i = ++_j) {
        v = _ref1[i];
        if (v === version && i !== $scope.chosen.length - 1) {
          temp = $scope.chosen[i + 1];
          $scope.chosen[i + 1] = $scope.chosen[i];
          $scope.chosen[i] = temp;
          break;
        } else {
          _results.push(void 0);
        }
      }
      return _results;
    };
  });

}).call(this);

//# sourceMappingURL=../../scripts/controllers/season_criteria.js.map

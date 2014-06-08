(function() {
  "use strict";
  angular.module("verificationApp").controller("SeasonCriteriaCtrl", function(User, $scope, Criteria, Season, $routeParams, Version) {
    var c, initial, versions_promise, _i, _len, _ref;
    $scope.isCollapsed = {};
    $scope.id = $routeParams.id;
    $scope.season = Season.find($scope.id);
    $scope.criteria = Criteria.index();
    _ref = $scope.criteria;
    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
      c = _ref[_i];
      c.versions();
    }
    versions_promise = Season.season_criteria($scope.id);
    initial = [];
    $scope.chosen = [];
    versions_promise.then(function(vs) {
      $scope.chosen = vs;
      return initial = angular.copy(vs);
    });
    $scope.reset = function() {
      return $scope.chosen = angular.copy(initial);
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
      var from_server;
      from_server = Season.replace_season_criteria($scope.id, $scope.chosen);
      return from_server.then(function(vs) {
        $scope.chosen = vs;
        return initial = angular.copy(vs);
      });
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
    $scope.isChosen = function(version) {
      var _j, _len1, _ref1;
      _ref1 = $scope.chosen;
      for (_j = 0, _len1 = _ref1.length; _j < _len1; _j++) {
        c = _ref1[_j];
        if (c.id === version.id) {
          return true;
        }
      }
      return false;
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
        if (v.id === version.id) {
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
        if (v.id === version.id && i !== 0) {
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
        if (v.id === version.id && i !== $scope.chosen.length - 1) {
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

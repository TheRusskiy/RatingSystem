(function() {
  "use strict";
  angular.module("verificationApp").controller("CriteriaVersionsCtrl", function(User, $scope, Criteria, Version) {
    $scope.versions = Version.index($scope.criteria.id);
    $scope.current_version = {
      criteria_id: $scope.criteria.id
    };
    $scope.edit_version = function(version, form) {
      form.$setPristine();
      return $scope.current_version = new Version(version);
    };
    $scope.newVersion = function() {
      $scope.current_version = {
        criteria_id: $scope.criteria.id
      };
      return form.$setPristine();
    };
    $scope.dateOptions = {
      'starting-day': 1
    };
    $scope.saveVersion = function(version, form) {
      var new_version;
      console.log(version);
      new_version = new Version(version);
      $scope.current_version = Version.upsert(new_version);
      return form.$setPristine();
    };
    $scope.deleteVersion = function(version, form) {
      if (!confirm("Вы уверены что хотите удалить эту версию?")) {
        return;
      }
      version = new Version(version);
      Version["delete"](version);
      return $scope.newVersion();
    };
    $scope.multiplierErrors = [];
    $scope.validateFetchValue = function($value) {
      var correctCount, formatMatches, multi, multis, no_empty_elements, oldLength, value, values;
      if ($value == null) {
        $value = "";
      }
      $scope.multiplierErrors = [];
      if ($scope.criteria.fetch_type === 'manual_options') {
        value = $value;
        multi = ($scope.criteria.multiplier || "").toString();
        console.log('validating:');
        console.log(value);
        console.log(multi);
        values = value.split('|');
        multis = multi.split('|');
        oldLength = values.length;
        no_empty_elements = deleteEmptyElements(values).length === oldLength;
        correctCount = values.length === multis.length;
        formatMatches = value.match(/(.+\|)*.+/);
        if (!correctCount) {
          $scope.multiplierErrors.push("Число элементов во множителе и данных не совпадает");
        }
        if (!formatMatches) {
          $scope.multiplierErrors.push("Некорректный формат данных. Данные должны следовать формату 'название{|название}'");
        }
        if (!no_empty_elements) {
          $scope.multiplierErrors.push("Не должно быть пустых элементов");
        }
        return correctCount && !!formatMatches && no_empty_elements;
      } else {
        return true;
      }
    };
    return $scope.validateMultiplierValue = function($value) {
      var v, valid, values, _i, _len;
      if ($value == null) {
        $value = "";
      }
      $value = $value.toString();
      values = $value.split('|');
      valid = true;
      for (_i = 0, _len = values.length; _i < _len; _i++) {
        v = values[_i];
        if (!isInt(v)) {
          valid = false;
        }
      }
      if ($scope.criteria.fetch_type !== 'manual_options') {
        if (values.length !== 1) {
          valid = false;
        }
      }
      return valid;
    };
  });

}).call(this);

//# sourceMappingURL=../../scripts/controllers/criteria_versions.js.map

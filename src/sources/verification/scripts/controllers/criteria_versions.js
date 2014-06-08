(function() {
  "use strict";
  angular.module("verificationApp").controller("CriteriaVersionsCtrl", function(User, $scope, Criteria, Version) {
    var deleteEmptyElements, isInt;
    $scope.versions = Version.index($scope.criteria.id);
    $scope.current_version = {
      criteria_id: $scope.criteria.id
    };
    $scope.edit_version = function(version, form) {
      form.$setPristine();
      return $scope.current_version = new Version(version);
    };
    $scope.newVersion = function() {
      return $scope.current_version = {
        criteria_id: $scope.criteria.id
      };
    };
    $scope.dateOptions = {
      'starting-day': 1
    };
    $scope.saveVersion = function(version, form) {
      var new_version;
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
      $scope.newVersion();
      return form.$setPristine();
    };
    deleteEmptyElements = function(arr) {
      var i, len;
      i = 0;
      len = arr.length;
      while (i < len) {
        arr[i] && arr.push(arr[i]);
        i++;
      }
      arr.splice(0, len);
      return arr;
    };
    isInt = function(n) {
      return parseFloat(n) === parseInt(n, 10) && !isNaN(n);
    };
    $scope.fetchValueErrorsForMultiplier = [];
    $scope.validateFetchValueForMultiplier = function(form, $value) {
      var correctCount, formatMatches, multi, multis, no_empty_elements, oldLength, result, value, values;
      if ($value == null) {
        $value = "";
      }
      $scope.fetchValueErrorsForMultiplier = [];
      if ($scope.criteria.fetch_type === 'manual_options' && !form.$pristine) {
        value = $value;
        multi = ($scope.current_version.multiplier || "").toString();
        values = value.split('|');
        multis = multi.split('|');
        oldLength = values.length;
        no_empty_elements = deleteEmptyElements(values).length === oldLength;
        correctCount = values.length === multis.length;
        formatMatches = value.match(/(.+\|)*.+/);
        if (!correctCount) {
          $scope.fetchValueErrorsForMultiplier.push("Число элементов во множителе и данных не совпадает");
        }
        if (!formatMatches) {
          $scope.fetchValueErrorsForMultiplier.push("Некорректный формат данных. Данные должны следовать формату 'название{|название}'");
        }
        if (!no_empty_elements) {
          $scope.fetchValueErrorsForMultiplier.push("Не должно быть пустых элементов");
        }
        result = correctCount && !!formatMatches && no_empty_elements;
        return result;
      } else {
        return true;
      }
    };
    return $scope.validateMultiplierValueForMutliplier = function(form, $value) {
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

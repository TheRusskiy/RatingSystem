(function() {
  "use strict";
  angular.module("verificationApp").controller("CriteriaEditCtrl", function($scope, Criteria, $routeParams, $rootScope, $location) {
    var deleteEmptyElements, isInt;
    $scope.fetch_types = Criteria.fetch_types();
    $scope.id = $routeParams.id;
    $scope.criteria = $scope.id === 'new' ? new Criteria : Criteria.find($routeParams.id);
    $scope.dateOptions = {
      'starting-day': 1
    };
    $scope.openDatepicker = function($event, form) {
      $event.preventDefault();
      $event.stopPropagation();
      return form.datepickerOpened = true;
    };
    $scope.createCriteria = function(c) {
      $scope.criteria = Criteria.upsert(c);
      $scope.criteria.$promise.then(function(new_c) {
        return $rootScope.goto('/criteria/' + new_c.id);
      });
      return null;
    };
    $scope.saveCriteria = function(c) {
      $scope.criteria = Criteria.upsert(c);
      return null;
    };
    $scope.deleteCriteria = function(c) {
      if (!confirm("Вы уверены? Удалённый показатель восстановлению не подлежит!")) {
        return;
      }
      Criteria["delete"](c);
      return $rootScope.goto('/criteria');
    };
    $scope.revalidateFetchValue = function(form) {
      form.fetch_value.$setViewValue(form.fetch_value.$viewValue);
      return null;
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
    $scope.fetchValueErrors = [];
    $scope.validateFetchValue = function(form, $value) {
      var correctCount, formatMatches, multi, multis, no_empty_elements, oldLength, value, values;
      if ($value == null) {
        $value = "";
      }
      $scope.fetchValueErrors = [];
      if ($scope.criteria.fetch_type === 'manual_options' && !form.$pristine) {
        value = $value;
        multi = ($scope.criteria.multiplier || "").toString();
        values = value.split('|');
        multis = multi.split('|');
        oldLength = values.length;
        no_empty_elements = deleteEmptyElements(values).length === oldLength;
        correctCount = values.length === multis.length;
        formatMatches = value.match(/(.+\|)*.+/);
        if (($scope.criteria.multiplier != null) && !correctCount) {
          $scope.fetchValueErrors.push("Число элементов во множителе и данных не совпадает");
        }
        if (!formatMatches) {
          $scope.fetchValueErrors.push("Некорректный формат данных. Данные должны следовать формату 'название{|название}'");
        }
        if (!no_empty_elements) {
          $scope.fetchValueErrors.push("Не должно быть пустых элементов");
        }
        return (correctCount || ($scope.criteria.multiplier == null)) && !!formatMatches && no_empty_elements;
      } else {
        return true;
      }
    };
    return $scope.validateMultiplierValue = function(form, $value) {
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

//# sourceMappingURL=../../scripts/controllers/criteria_edit.js.map

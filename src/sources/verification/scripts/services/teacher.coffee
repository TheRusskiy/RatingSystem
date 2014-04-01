"use strict"
angular.module("verificationApp").factory "Teacher", ($resource) ->
  teachers = [
    {
      id: 1
      name: "Прохоров Сергей Антонович"
    }
    {
      id: 2
      name: "Востокин Сергей Владимирович"
    }
    {
      id: 3
      name: "Иващенко Антон Владимирович"
    }
  ]
  return {
      index: ()->
        teachers
    }



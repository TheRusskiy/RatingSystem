"use strict"
angular.module("verificationApp").factory "Teacher", ($resource) ->
  teachers = $resource "/sources/verification/index.php", {controller: "teachers"},
    query:
      method: "GET"
      isArray:true
      params:
        action: "index"

  #    [
#    {
#      id: 1
#      name: "Прохоров Сергей Антонович"
#    }
#    {
#      id: 2
#      name: "Востокин Сергей Владимирович"
#    }
#    {
#      id: 3
#      name: "Иващенко Антон Владимирович"
#    }
#    {
#      id: 4
#      name: "Еленев Дмитрий Валерьевич"
#    }
#    {
#      id: 5
#      name: "Есипов Борис Алексеевич"
#    }
#    {
#      id: 6
#      name: "Гаврилов Андрей Вадимович"
#    }
#    {
#      id: 7
#      name: "Еленев Валерий Дмитриевич"
#    }
#  ]
  return {
      index: ()->
        console.log 'index'
        return @teachersCache if @teachersCache
        @teachersCache = teachers.query()
        return @teachersCache
    }



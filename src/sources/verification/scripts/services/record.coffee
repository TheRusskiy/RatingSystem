"use strict"
angular.module("verificationApp").factory "Record", ($resource) ->
  records = [
    {
      id: 1
      criteria_id: 1
      date: "01.02.2013"
      name: "Победа в областной олимпиаде по математике"
      option:
        value: 1
        name: "1 место"
      teacher:
        id: 1
        name: "Прохоров Сергей Антонович"
      user:
        id: 202
        name: "Ишков Д.С."
      notes: [1,2,3]
    }
    {
      id: 2
      criteria_id: 1
      date: "01.02.2013"
      name: "Победа в областной олимпиаде по физике"
      option:
        value: 2
        name: "2 место"
      teacher:
        id: 1
        name: "Прохоров Сергей Антонович"
      user:
        id: 202
        name: "Ишков Д.С."
      notes: [4,5]
    }
    {
      id: 3
      criteria_id: 1
      date: "01.01.2014"
      name: "Победа в областной олимпиаде по информатике"
      option:
        value: 3
        name: "3 место"
      teacher:
        id: 1
        name: "Прохоров Сергей Антонович"
      user:
        id: 202
        name: "Ишков Д.С."
      notes: []
    }
    {
      id: 4
      criteria_id: 2
      date: "01.01.2014"
      name: "Публикация в журнале 'Мурзилка'"
      teacher:
        id: 2
        name: "Востокин Сергей Владимирович"
      user:
        id: 202
        name: "Ишков Д.С."
      notes: []
    }
    {
      id: 5
      criteria_id: 3
      date: "01.05.2014"
      name: "Ашот Каберханян Фываолдж"
      teacher:
        id: 3
        name: "Иващенко Антон Владимирович"
      user:
        id: 202
        name: "Ишков Д.С."
      notes: []
    }
  ]
  countPerPage = 2
  for r in records
    r.$remove = ()-> console.log("Removing record "+r.id.toString())
  return {
      countPerPage: countPerPage
      index: (criteria_id, pageNumber=1)->
        pageNumber = pageNumber - 1 # start from 0
        subset = records.filter (e)-> e.criteria_id == criteria_id
        result = []
        for r, i in subset
          result.push(r) if i in [pageNumber*countPerPage...(pageNumber+1)*countPerPage]
        result

      count: (criteria_id)->
        length = (records.filter (e)-> e.criteria_id == criteria_id).length
        length
    }



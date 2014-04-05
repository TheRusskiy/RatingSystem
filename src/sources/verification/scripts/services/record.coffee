"use strict"
angular.module("verificationApp").factory "Record", ($resource) ->
  Record = $resource "/sources/verification/index.php", {controller: "records"},
    query:
      method: "GET"
      isArray:true
      params:
        action: "index"
    save:
      method: "POST"
      params:
        action: "create"
#  return {
#  index: ()->
#    console.log 'index'
#    return @teachersCache if @teachersCache
#    @teachersCache = teachers.query()
#    return @teachersCache
#  }


#records = [
#    {
#      id: 1
#      criteria_id: 1
#      date: "01.02.2013"
#      name: "Победа в областной олимпиаде по математике"
#      option:
#        value: 1
#        name: "1 место"
#      teacher:
#        id: 1
#        name: "Прохоров Сергей Антонович"
#      user:
#        id: 202
#        name: "Ишков Д.С."
#      notes: [1,2,3]
#    }
#    {
#      id: 2
#      criteria_id: 1
#      date: "01.02.2013"
#      name: "Победа в областной олимпиаде по физике"
#      option:
#        value: 2
#        name: "2 место"
#      teacher:
#        id: 1
#        name: "Прохоров Сергей Антонович"
#      user:
#        id: 202
#        name: "Ишков Д.С."
#      notes: [4,5]
#    }
#    {
#      id: 3
#      criteria_id: 1
#      date: "01.01.2014"
#      name: "Победа в областной олимпиаде по информатике"
#      option:
#        value: 3
#        name: "3 место"
#      teacher:
#        id: 1
#        name: "Прохоров Сергей Антонович"
#      user:
#        id: 202
#        name: "Ишков Д.С."
#      notes: []
#    }
#    {
#      id: 4
#      criteria_id: 2
#      date: "01.01.2014"
#      name: "Публикация в журнале 'Мурзилка'"
#      teacher:
#        id: 2
#        name: "Востокин Сергей Владимирович"
#      user:
#        id: 202
#        name: "Ишков Д.С."
#      notes: []
#    }
#    {
#      id: 5
#      criteria_id: 3
#      date: "01.05.2014"
#      name: "Ашот Каберханян Фываолдж"
#      teacher:
#        id: 3
#        name: "Иващенко Антон Владимирович"
#      user:
#        id: 202
#        name: "Ишков Д.С."
#      notes: []
#    }
#  ]
  curId=5
  generateId = ()-> curId+=1; curId
  countPerPage = 2
#  MyRecord = (source)->
#    @source = new Record(source)
#    @
  Record.prototype.save = ()->
    if @id # update
      console.log("Updated:")
      console.log(@)
    else # create
      @$save (r)->
        recordsCache[r.criteria_id][1].push(r)
        console.log("Created:")
        console.log(r)
        console.log(recordsCache[r.criteria_id][1])


#    return if (@.id)
#    @.id = generateId()
#    @.source.id = @.id
#    records.push(@)

#    console.log(Record)
  Record.prototype.delete = ()->
    position = null
    for r, i in Record
      if r.id = @.id
        position = i
        break
    Record.splice(position, 1)
    console.log("Deleted")
    console.log(Record)
  Record.countPerPage = countPerPage
  recordsCache = {}
  Record.index = (criteria_id, pageNumber=1)->
    console.log 'record index'
    unless recordsCache[criteria_id]?
      recordsCache[criteria_id] = {}
    return recordsCache[criteria_id][pageNumber] if recordsCache[criteria_id][pageNumber]
    recordsCache[criteria_id][pageNumber] = Record.query(criteria: criteria_id)
    return recordsCache[criteria_id][pageNumber]
#    pageNumber = pageNumber - 1 # start from 0
#    subset = records.filter (e)-> e.criteria_id == criteria_id
#    result = []
#    for r, i in subset
#      result.push(r) if i in [pageNumber*countPerPage...(pageNumber+1)*countPerPage]
#    result

  Record.count= (criteria_id)->
    4
#    length = (records.filter (e)-> e.criteria_id == criteria_id).length
#    length
#  for r in records
#    r.$remove = ()-> console.log("Removing record "+r.id.toString())
#    r.prototype = MyRecord
  return Record



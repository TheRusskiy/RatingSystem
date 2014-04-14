"use strict"
angular.module("verificationApp").factory "Record", ($resource) ->
  Record = $resource "/sources/verification/index.php", {controller: "records"},
    query:
      method: "GET"
      isArray:true
      params:
        action: "index"
    search_query:
      method: "GET"
      isArray:true
      params:
        action: "search"
    record_count:
      method: "GET"
      params:
        action: "count"
    save:
      method: "POST"
      params:
        action: "create"
    update:
      method: "POST"
      params:
        action: "update"
    delete_record:
      method: "DELETE"
      params:
        action: "delete"
  recordsCache = {}
  recordsSearchCache = {}
  recordsCountCache = {}

  countPerPage = 10

  Record.upsert = (record)->
    if record.id # update
      Record.update {}, record, (r)->
        console.log("Updated:")
        console.log(r)
        r

    else # create
      record.$save {}, (r)->
        console.log recordsCache
        recordsCache[r.criteria_id][1].unshift(r)
        console.log("Created:")
        console.log(r)
        console.log(recordsCache[r.criteria_id][1])
        r

  Record.delete = (record)->
    console.log("cache pages")
    console.log(recordsCache[record.criteria_id])
    for key, cachePage of recordsCache[record.criteria_id]
      console.log("cachePage")
      console.log(cachePage)
      position = null
      for r, i in cachePage
        if r.id is record.id
          position = i
          cachePage.splice(position, 1)
          console.log("Deleted")
          break
    Record.delete_record {record_id: record.id}, (response)->
      console.log(response)

  Record.countPerPage = countPerPage
  Record.index = (criteria_id, pageNumber=1)->
    console.log 'record index'
    unless recordsCache[criteria_id]?
      recordsCache[criteria_id] = {}
    return recordsCache[criteria_id][pageNumber] if recordsCache[criteria_id][pageNumber]
    recordsCache[criteria_id][pageNumber] = Record.query(
      criteria: criteria_id
      page: pageNumber
      page_length: countPerPage
    )
    console.log "writing to page #{pageNumber}"
    return recordsCache[criteria_id][pageNumber]

  Record.count = (criteria_id)->
    return recordsCountCache[criteria_id] if recordsCountCache[criteria_id]
    recordsCountCache[criteria_id] = 100
    Record.record_count {criteria_id: criteria_id}, (result)->
      console.log "count"
      console.log result
      recordsCountCache[criteria_id] = result.count
    return recordsCountCache[criteria_id]

  Record.search = (criteria_id)->
    recordsSearchCache[criteria_id]

  Record.newSearch = (criteria_id, record_template)->
    recordsSearchCache[criteria_id] = Record.search_query(
      search: record_template
    )

  return Record



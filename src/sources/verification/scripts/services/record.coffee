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
    record_search_count:
      method: "GET"
      params:
        action: "search_count"
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
  recordsSearchCountCache = {}

  countPerPage = 10

  Record.upsert = (record)->
    for key, cachePage of recordsCache[record.criteria_id]
      position = null
      for r, i in cachePage
        if r.id is record.id
          position = i
          cachePage[position]=record
          console.log("replaced")
          break
    if recordsSearchCache[record.criteria_id]
      for key, cachePage of recordsSearchCache[record.criteria_id]
        position = null
        for r, i in cachePage
          if r.id is record.id
            position = i
            cachePage[position]=record
            console.log("replaced")
            break
    if record.id # update
      record.$update {}, (r)->
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
    if recordsSearchCache[record.criteria_id]
      for key, cachePage of recordsSearchCache[record.criteria_id]
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
      criteria_id: criteria_id
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

  Record.searchCount = (criteria_id, record_template)->
    return recordsSearchCountCache[criteria_id] if recordsSearchCountCache[criteria_id]
    recordsSearchCountCache[criteria_id] = 100
    Record.record_search_count {criteria_id: criteria_id, search: record_template}, (result)->
      console.log "search count"
      console.log result
      recordsSearchCountCache[criteria_id] = result.count
    return recordsSearchCountCache[criteria_id]

  Record.search = (criteria_id, record_template, pageNumber=1)->
    console.log 'record search'
    unless recordsSearchCache[criteria_id]?
      recordsSearchCache[criteria_id] = {}
    return recordsSearchCache[criteria_id][pageNumber] if recordsSearchCache[criteria_id][pageNumber]
    recordsSearchCache[criteria_id][pageNumber] = Record.search_query(
      criteria_id: criteria_id
      page: pageNumber
      page_length: countPerPage
      search: record_template
    )
    console.log "writing to search page #{pageNumber}"
    return recordsSearchCache[criteria_id][pageNumber]

  Record.newSearch = (criteria_id)->
    recordsSearchCache[criteria_id] = {}
    recordsSearchCountCache[criteria_id] = null

  return Record



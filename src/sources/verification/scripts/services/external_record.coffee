"use strict"
angular.module("verificationApp").factory "ExternalRecord", ($resource) ->
  External = $resource "/sources/verification/index.php", {controller: "external_records"},
    query:
      method: "GET"
      isArray:true
      params:
        action: "index"
    save:
      method: "POST"
      params:
        action: "create"
    delete_record:
      method: "DELETE"
      params:
        action: "delete"
  records = [
    {
      id: 1
      criteria_id: 1
      description: 'Some description'
      date: '2014-04-02'
      notes: []
      teacher:
        id: 1
        name: 'Some Name'
      status: 'new'
      created_by:
        id: 1
        name: "some dude"
      reviewed_by:
        id: 1
        name: "verification"
    }
    {
      id: 2
      criteria_id: 1
      description: 'Some description sadsdasda    sdasdasda dassda'
      date: '2014-04-03'
      notes: [4,5]
      teacher:
        id: 2
        name: 'Some other name'
      status: 'new'
      created_by:
        id: 1
        name: "some dude"
      reviewed_by:
        id: 1
        name: "verification"
    }
    {
      id: 3
      criteria_id: 1
      description: 'Some description adssdasda'
      date: '2014-04-04'
      notes: [1,2,3]
      teacher:
        id: 1
        name: 'Yet another name'
      status: 'new'
      created_by:
        id: 1
        name: "some dude"
      reviewed_by:
        id: 1
        name: "verification"
    }
  ]
  externalCache = {}
  External.index = (criteria_id)->
    console.log 'external records index'
    return externalCache[criteria_id] if externalCache[criteria_id]
    externalCache[criteria_id] = External.query(
      criteria: criteria_id
    )
    return externalCache[criteria_id]

  External.create = (record)->
    record.$save {}, (r)->
      console.log "External created:"
      console.log record
      r

  External.delete = (record)->
    External.delete_record {record_id: record.id}, (response)->
      console.log(response)


  return External
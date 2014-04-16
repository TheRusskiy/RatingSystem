"use strict"
angular.module("verificationApp").factory "ExternalRecord", ($resource) ->
  External = $resource "/sources/verification/index.php", {controller: "external_records"},
    query:
      method: "GET"
      isArray:true
      params:
        action: "index"
    all_records:
      method: "GET"
      isArray:true
      params:
        action: "all"
    record_approve:
      method: "GET"
      params:
        action: "approve"
    record_reject:
      method: "GET"
      params:
        action: "reject"
    save:
      method: "POST"
      params:
        action: "create"
    delete_record:
      method: "DELETE"
      params:
        action: "delete"

  externalCache = {}
  allExternalCache = {}
  External.index = (criteria_id)->
    console.log 'external records index'
    return externalCache[criteria_id] if externalCache[criteria_id]
    externalCache[criteria_id] = External.query(
      criteria: criteria_id
    )
    return externalCache[criteria_id]
  External.all = (criteria_id)->
    console.log 'external records index'
    return allExternalCache[criteria_id] if allExternalCache[criteria_id]
    allExternalCache[criteria_id] = External.all_records(
      criteria: criteria_id
    )
    return allExternalCache[criteria_id]

  External.create = (record)->
    record.$save {}, (r)->
      console.log "External created:"
      console.log record
      allExternalCache[record.criteria_id] = null
      r

  External.delete = (record)->
    External.delete_record {record_id: record.id}, (response)->
      console.log(response)
      for rec, i in allExternalCache[record.criteria_id]
        if rec.id.toString() == record.id.toString()
          allExternalCache[record.criteria_id].splice(i, 1)
          break

  External.approve = (record)->
    return unless confirm("Вы уверены, что хотите подтвердить запись?")
    External.record_approve record, {}, (r)->
      console.log "approved:"
      console.log r
      for rec, i in externalCache[record.criteria_id]
        if rec.id.toString() == record.id.toString()
          externalCache[record.criteria_id].splice(i, 1)
          break
      r

  External.reject = (record)->
    return unless confirm("Вы уверены, что хотите отклонить запись?")
    External.record_reject record, {}, (r)->
      console.log "rejected:"
      console.log r
      for rec, i in externalCache[record.criteria_id]
        if rec.id.toString() == record.id.toString()
          externalCache[record.criteria_id].splice(i, 1)
          break
      r

  External.clearCache = ()->
    externalCache = {}

  return External
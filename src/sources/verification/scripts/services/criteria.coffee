"use strict"
angular.module("verificationApp").factory "Criteria", ($resource) ->
  Criteria = $resource "/sources/verification/index.php", {controller: "criteria"},
    query:
      method: "GET"
      isArray:true
      params:
        action: "index"
    with_records_query:
      method: "GET"
      isArray:true
      params:
        action: "with_records"
    get:
      method: "GET"
      params:
        action: "show"
    save:
      method: "POST"
      params:
        action: "create"
    update:
      method: "POST"
      params:
        action: "update"
    fetch_types_index:
      method: "GET"
      params:
        action: "fetch_types"
    delete_criteria:
      method: "DELETE"
      params:
        action: "delete"
  resetCache = ()->
    console.log "reset criteria cache"
    Criteria.criteriaCache = null
    Criteria.withRecordsCache = null

  Criteria.index = ()->
    console.log 'criteria index'
    return @criteriaCache if @criteriaCache
    @criteriaCache = Criteria.query()
    return @criteriaCache
  Criteria.with_records = ()->
    console.log 'criteria with records'
    return @withRecordsCache if @withRecordsCache
    @withRecordsCache = Criteria.with_records_query()
    return @withRecordsCache
  Criteria.fetch_types = ()->
    console.log 'fetch types'
    return @fetchTypesCache if @fetchTypesCache
    @fetchTypesCache = Criteria.fetch_types_index()
    return @fetchTypesCache
  Criteria.find = (id)->
    console.log 'find criteria '+id
    return Criteria.get(id: id)
  Criteria.delete = (c)->
    console.log "deleting criteria"
    console.log c
    Criteria.delete_criteria {criteria_id: c.id}, (response)->
      console.log(response)
      resetCache()
    resetCache()
  Criteria.upsert = (c)->
    if c.id # update
      Criteria.update {}, c, (new_c)->
        console.log("Updated:")
        console.log(new_c)
        resetCache()
        new_c
    else
      Criteria.save {}, c, (new_c)->
        console.log("Updated:")
        console.log(new_c)
        resetCache()
        new_c
  return Criteria
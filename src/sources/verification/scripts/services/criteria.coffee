"use strict"
angular.module("verificationApp").factory "Criteria", ($resource) ->
  criteria = $resource "/sources/verification/index.php", {controller: "criteria"},
    query:
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
    calculation_types_index:
      method: "GET"
      params:
        action: "calculation_types"
  resetCache = ()->
    criteria.criteriaCache = null
    criteria.withRecordsCache = null

  criteria.index = ()->
    console.log 'criteria index'
    return @criteriaCache if @criteriaCache
    @criteriaCache = criteria.query()
    return @criteriaCache
  criteria.with_records = ()->
    console.log 'criteria with records'
    return @withRecordsCache if @withRecordsCache
    @withRecordsCache = criteria.query()
    return @withRecordsCache
  criteria.fetch_types = ()->
    console.log 'fetch types'
    return @fetchTypesCache if @fetchTypesCache
    @fetchTypesCache = criteria.fetch_types_index()
    return @fetchTypesCache
  criteria.calculation_types = ()->
    console.log 'fetch types'
    return @calcTypesCache if @calcTypesCache
    @calcTypesCache = criteria.calculation_types_index()
    return @calcTypesCache
  criteria.find = (id)->
    console.log 'find criteria '+id
    return criteria.get(id: id)
  criteria.upsert = (c)->
    if c.id # update
      criteria.update {}, c, (new_c)->
        console.log("Updated:")
        console.log(new_c)
        resetCache()
        new_c
    else
      criteria.$save {}, c, (new_c)->
        console.log("Updated:")
        console.log(new_c)
        resetCache()
        new_c
  return criteria
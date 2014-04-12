"use strict"
angular.module("verificationApp").factory "Criteria", ($resource) ->
  criteria = $resource "/sources/verification/index.php", {controller: "criteria"},
    query:
      method: "GET"
      isArray:true
      params:
        action: "with_records"
    fetch_types:
      method: "GET"
      params:
        action: "fetch_types"
    calculation_types:
      method: "GET"
      params:
        action: "calculation_types"
  return {
  index: ()->
    console.log 'criteria index'
    return @criteriaCache if @criteriaCache
    @criteriaCache = criteria.query()
    return @criteriaCache
  with_records: ()->
    console.log 'criteria with records'
    return @withRecordsCache if @withRecordsCache
    @withRecordsCache = criteria.query()
    return @withRecordsCache
  fetch_types: ()->
    console.log 'fetch types'
    return @fetchTypesCache if @fetchTypesCache
    @fetchTypesCache = criteria.fetch_types()
    return @fetchTypesCache
  calculation_types: ()->
    console.log 'fetch types'
    return @calcTypesCache if @calcTypesCache
    @calcTypesCache = criteria.calculation_types()
    return @calcTypesCache
  }
"use strict"
angular.module("verificationApp").factory "Criteria", ($resource, Version) ->
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
    Criteria.criteriaCache = null
    Criteria.withRecordsCache = null

  Criteria.resetCache = resetCache

  Criteria.prototype.versions = ()->
    return @versionsCache if @versionsCache
    @versionsCache = Version.index(@id)
    @versionsCache.$promise.then (vs)=>
      for v in vs
        v.criteria = {
          id: @.id
          name: @.name
          fetch_type: @.fetch_type
          fetch_value: @.fetch_value
          external_records : @.external_records
          description : @.description
        }
    @versionsCache

  Criteria.index = ()->
    return @criteriaCache if @criteriaCache
    @criteriaCache = Criteria.query()
    return @criteriaCache
  Criteria.with_records = ()->
    return @withRecordsCache if @withRecordsCache
    @withRecordsCache = Criteria.with_records_query()
    return @withRecordsCache
  Criteria.fetch_types = ()->
    return @fetchTypesCache if @fetchTypesCache
    @fetchTypesCache = Criteria.fetch_types_index()
    return @fetchTypesCache
  Criteria.find = (id)->
    return Criteria.get(id: id)
  Criteria.delete = (c)->
    Criteria.delete_criteria {criteria_id: c.id}, (response)->
      resetCache()
    resetCache()
  Criteria.upsert = (c)->
    if c.id # update
      Criteria.update {}, c, (new_c)->
        resetCache()
        new_c
    else
      Criteria.save {}, c, (new_c)->
        resetCache()
        new_c
  return Criteria
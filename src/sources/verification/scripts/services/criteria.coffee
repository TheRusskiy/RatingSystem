"use strict"
angular.module("verificationApp").factory "Criteria", ($resource) ->
  criteria = $resource "/sources/verification/index.php", {controller: "criteria"},
    query:
      method: "GET"
      isArray:true
      params:
        action: "index"
  return {
  index: ()->
    console.log 'criteria index'
    return @criteriaCache if @criteriaCache
    @criteriaCache = criteria.query()
    return @criteriaCache
  }
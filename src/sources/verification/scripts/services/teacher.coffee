"use strict"
angular.module("verificationApp").factory "Teacher", ($resource) ->
  teachers = $resource "/sources/verification/index.php", {controller: "teachers"},
    query:
      method: "GET"
      isArray:true
      params:
        action: "index"
  return {
      index: ()->
        console.log 'teacher index'
        return @teachersCache if @teachersCache
        @teachersCache = teachers.query()
        return @teachersCache
    }



"use strict"
angular.module("verificationApp").filter "allowed_criteria", ->
  (items, user) ->
    filtered = []
    angular.forEach items, (item) ->
      filtered.push item if user.permissions[item.id.toString()]
      return

    filtered

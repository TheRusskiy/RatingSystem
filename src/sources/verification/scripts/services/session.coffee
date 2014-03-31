"use strict"
angular.module("verificationApp").factory "Session", ($resource) ->
  $resource "/api/session/"

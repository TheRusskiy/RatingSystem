"use strict"
angular.module("verificationApp").factory "User", ($resource) ->
  $resource "/sources/verification/index.php", {controller: "users"}
  ,
    #parameters default
    update:
      method: "PUT"
      params: {}

    get:
      method: "GET"
      params:
        id: "@id"

    current:
      method: "GET"
      params:
        id: "me"
        action: "current"


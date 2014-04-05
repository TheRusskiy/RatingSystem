"use strict"
angular.module("verificationApp").factory "User", ($resource) ->
  $resource "/sources/verification/index.php", {controller: "users"}
  ,
    current:
      method: "GET"
      params:
        id: "me"
        action: "current"


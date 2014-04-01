"use strict"
angular.module("verificationApp").factory "Session", ($resource) ->
  $resource "/sources/verification/index.php", {controller: "sessions"}
  ,
    #parameters default
    delete:
      method: "DELETE"
      params:
        action: "logout"


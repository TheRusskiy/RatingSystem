"use strict"
angular.module("verificationApp").factory "User", ($resource) ->
  Users = $resource "/sources/verification/index.php", {controller: "users"},
    current:
      method: "GET"
      params:
        id: "me"
        action: "current"
    update:
      method: "POST"
      params:
        action: "update"
    query:
      method: "GET"
      isArray:true
      params:
        action: "index"

  Users.index = ()->
    console.log 'users index'
    return @usersCache if @usersCache
    @usersCache = Users.query()
    return @usersCache
  Users.update_permissions = (user)->
    console.log 'updating permissions'
    Users.update {user_id: user.id}, user, (u)->
      console.log "updated:"
      console.log u

  return Users


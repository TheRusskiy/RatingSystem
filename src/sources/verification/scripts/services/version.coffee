"use strict"
angular.module("verificationApp").factory "Version", ($resource, Criteria) ->
  Version = $resource "/sources/verification/index.php", {controller: "versions"},
    query:
      method: "GET"
      isArray:true
      params:
        action: "index"
    save:
      method: "POST"
      params:
        action: "create"
    update:
      method: "POST"
      params:
        action: "update"
    delete_version:
      method: "DELETE"
      params:
        action: "delete"

  resetCache = ()->
    console.log "reset version cache"
    Version.versionCache = null

  Version.index = ()->
    console.log 'version index'
    return @versionCache if @versionCache
    @versionCache = Version.query()
    return @versionCache

  Version.delete = (c)->
    console.log "deleting version"
    console.log c
    Version.delete_version {version_id: c.id}, (response)=>
      console.log(response)
      for r, i in @versionCache
        if r.id == c.id
          @versionCache.splice(i, 1)
          break
      Criteria.resetCache()

  Version.upsert = (c)->
    if c.id # update
      old_id = c.id
      Version.update {}, c, (new_c)=>
        console.log("Updated:")
        console.log(new_c)
        for r, i in @versionCache
          if r.id == old_id
            @versionCache[i]=new_c
            console.log "replace version"
            break
        new_c
    else
      Version.save {}, c, (new_c)=>
        console.log("Created:")
        console.log(new_c)
        @versionCache.unshift(new_c)
        Criteria.resetCache()
        new_c

  return Version
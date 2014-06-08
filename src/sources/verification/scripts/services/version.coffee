"use strict"
angular.module("verificationApp").factory "Version", ($resource, $injector) ->
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

  Version.versionCache = {}

  resetCache = ()->
    console.log "reset version cache"
    Version.versionCache = {}

  Version.index = (criteria_id)->
    console.log 'version index'
    return @versionCache[criteria_id] if @versionCache[criteria_id]
    @versionCache[criteria_id] = Version.query(criteria_id: criteria_id)
    return @versionCache[criteria_id]

  Version.delete = (c)->
    console.log "deleting version"
    console.log c
    Version.delete_version {version_id: c.id}, (response)=>
      console.log(response)
      for r, i in @versionCache[c.criteria_id]
        if r.id == c.id
          @versionCache[c.criteria_id].splice(i, 1)
          break
      $injector.get('Cache').Criteria.resetCache()

  Version.upsert = (c)->
    if c.id # update
      old_id = c.id
      Version.update {}, c, (new_c)=>
        console.log("Updated:")
        console.log(new_c)
        for r, i in @versionCache[c.criteria_id]
          if r.id == old_id
            @versionCache[c.criteria_id][i]=new_c
            console.log "replace version"
            break
        new_c
    else
      Version.save {}, c, (new_c)=>
        console.log("Created:")
        console.log(new_c)
        @versionCache[c.criteria_id].unshift(new_c)
        $injector.get('Cache').Criteria.resetCache()
        new_c

  return Version
"use strict"
angular.module("verificationApp").factory "Season", ($resource) ->
  Season = $resource "/sources/verification/index.php", {controller: "seasons"},
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
    delete_season:
      method: "DELETE"
      params:
        action: "delete"
  resetCache = ()->
    console.log "reset season cache"
    Season.seasonCache = null

  Season.index = ()->
    console.log 'season index'
    return @seasonCache if @seasonCache
    @seasonCache = Season.query()
    return @seasonCache

  Season.delete = (c)->
    console.log "deleting season"
    console.log c
    Season.delete_season {season_id: c.id}, (response)=>
      console.log(response)
      for r, i in @seasonCache
        if r.id == c.id
          @seasonCache.splice(i, 1)
          break

  Season.upsert = (c)->
    if c.id # update
      old_id = c.id
      Season.update {}, c, (new_c)=>
        console.log("Updated:")
        console.log(new_c)
        for r, i in @seasonCache
          if r.id == old_id
            @seasonCache[i]=new_c
            console.log "replace season"
            break
        new_c
    else
      Season.save {}, c, (new_c)=>
        console.log("Created:")
        console.log(new_c)
        @seasonCache.unshift(new_c)
        new_c

  return Season
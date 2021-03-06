"use strict"
angular.module("verificationApp").factory "Season", ($resource, Criteria, $q) ->
  Season = $resource "/sources/verification/index.php", {controller: "seasons"},
    query:
      method: "GET"
      isArray:true
      params:
        action: "index"
    query_criteria:
      method: "GET"
      isArray:true
      params:
        action: "index_criteria"
    get:
      method: "GET"
      params:
        action: "show"
    save:
      method: "POST"
      params:
        action: "create"
    replace_criteria:
      method: "POST"
      isArray: true
      params:
        action: "replace_criteria"
    update:
      method: "POST"
      params:
        action: "update"
    delete_season:
      method: "DELETE"
      params:
        action: "delete"
  resetCache = ()->
    Season.seasonCache = null
  Season.seasonCriteriaCache = {}

  set_criteria = (promise)->
    $q.all([
      Criteria.index().$promise,
      promise.$promise
    ]).then (data)->
      criteria = data[0]
      versions = data[1]
      for v, i in versions
        for c, j in criteria
          if c.id == v.criteria_id
            v.criteria = c
            break
      return versions

  Season.season_criteria = (season_id)->
    return @seasonCriteriaCache[season_id] if @seasonCriteriaCache[season_id]
    promise = Season.query_criteria(season_id: season_id)
    promise = set_criteria(promise)
    @seasonCriteriaCache[season_id] = promise
    return @seasonCriteriaCache[season_id]

  Season.replace_season_criteria = (season_id, season_criteria)->
    promise = Season.replace_criteria(season_criteria: season_criteria, season_id: season_id)
    promise = set_criteria(promise)
    @seasonCriteriaCache[season_id] = promise
    return @seasonCriteriaCache[season_id]

  Season.index = ()->
    return @seasonCache if @seasonCache
    @seasonCache = Season.query()
    return @seasonCache

  Season.find = (id)->
    return Season.get(id: id)

  Season.delete = (c)->
    Season.delete_season {season_id: c.id}, (response)=>
      for r, i in @seasonCache
        if r.id == c.id
          @seasonCache.splice(i, 1)
          break

  Season.upsert = (c)->
    if c.id # update
      old_id = c.id
      Season.update {}, c, (new_c)=>
        for r, i in @seasonCache
          if r.id == old_id
            @seasonCache[i]=new_c
            break
        new_c
    else
      Season.save {}, c, (new_c)=>
        @seasonCache.unshift(new_c)
        new_c

  return Season
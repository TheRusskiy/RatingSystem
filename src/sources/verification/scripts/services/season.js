(function() {
  "use strict";
  angular.module("verificationApp").factory("Season", function($resource, Criteria, $q) {
    var Season, resetCache, set_criteria;
    Season = $resource("/sources/verification/index.php", {
      controller: "seasons"
    }, {
      query: {
        method: "GET",
        isArray: true,
        params: {
          action: "index"
        }
      },
      query_criteria: {
        method: "GET",
        isArray: true,
        params: {
          action: "index_criteria"
        }
      },
      get: {
        method: "GET",
        params: {
          action: "show"
        }
      },
      save: {
        method: "POST",
        params: {
          action: "create"
        }
      },
      replace_criteria: {
        method: "POST",
        isArray: true,
        params: {
          action: "replace_criteria"
        }
      },
      update: {
        method: "POST",
        params: {
          action: "update"
        }
      },
      delete_season: {
        method: "DELETE",
        params: {
          action: "delete"
        }
      }
    });
    resetCache = function() {
      return Season.seasonCache = null;
    };
    Season.seasonCriteriaCache = {};
    set_criteria = function(promise) {
      return $q.all([Criteria.index().$promise, promise.$promise]).then(function(data) {
        var c, criteria, i, j, v, versions, _i, _j, _len, _len1;
        criteria = data[0];
        versions = data[1];
        for (i = _i = 0, _len = versions.length; _i < _len; i = ++_i) {
          v = versions[i];
          for (j = _j = 0, _len1 = criteria.length; _j < _len1; j = ++_j) {
            c = criteria[j];
            if (c.id === v.criteria_id) {
              v.criteria = c;
              break;
            }
          }
        }
        return versions;
      });
    };
    Season.season_criteria = function(season_id) {
      var promise;
      if (this.seasonCriteriaCache[season_id]) {
        return this.seasonCriteriaCache[season_id];
      }
      promise = Season.query_criteria({
        season_id: season_id
      });
      promise = set_criteria(promise);
      this.seasonCriteriaCache[season_id] = promise;
      return this.seasonCriteriaCache[season_id];
    };
    Season.replace_season_criteria = function(season_id, season_criteria) {
      var promise;
      promise = Season.replace_criteria({
        season_criteria: season_criteria,
        season_id: season_id
      });
      promise = set_criteria(promise);
      this.seasonCriteriaCache[season_id] = promise;
      return this.seasonCriteriaCache[season_id];
    };
    Season.index = function() {
      if (this.seasonCache) {
        return this.seasonCache;
      }
      this.seasonCache = Season.query();
      return this.seasonCache;
    };
    Season.find = function(id) {
      return Season.get({
        id: id
      });
    };
    Season["delete"] = function(c) {
      var _this = this;
      return Season.delete_season({
        season_id: c.id
      }, function(response) {
        var i, r, _i, _len, _ref, _results;
        _ref = _this.seasonCache;
        _results = [];
        for (i = _i = 0, _len = _ref.length; _i < _len; i = ++_i) {
          r = _ref[i];
          if (r.id === c.id) {
            _this.seasonCache.splice(i, 1);
            break;
          } else {
            _results.push(void 0);
          }
        }
        return _results;
      });
    };
    Season.upsert = function(c) {
      var old_id,
        _this = this;
      if (c.id) {
        old_id = c.id;
        return Season.update({}, c, function(new_c) {
          var i, r, _i, _len, _ref;
          _ref = _this.seasonCache;
          for (i = _i = 0, _len = _ref.length; _i < _len; i = ++_i) {
            r = _ref[i];
            if (r.id === old_id) {
              _this.seasonCache[i] = new_c;
              break;
            }
          }
          return new_c;
        });
      } else {
        return Season.save({}, c, function(new_c) {
          _this.seasonCache.unshift(new_c);
          return new_c;
        });
      }
    };
    return Season;
  });

}).call(this);

//# sourceMappingURL=../../scripts/services/season.js.map

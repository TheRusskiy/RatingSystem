(function() {
  "use strict";
  angular.module("verificationApp").factory("Season", function($resource) {
    var Season, resetCache;
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
      console.log("reset season cache");
      return Season.seasonCache = null;
    };
    Season.season_criteria = function() {
      console.log('season criteria index');
      if (this.seasonCriteriaCache) {
        return this.seasonCriteriaCache;
      }
      this.seasonCriteriaCache = Season.query_criteria();
      return this.seasonCriteriaCache;
    };
    Season.replace_season_criteria = function(season_criteria) {
      console.log('replace season criteria');
      this.seasonCriteriaCache = Season.replace_criteria({
        season_criteria: season_criteria
      });
      return this.seasonCriteriaCache;
    };
    Season.index = function() {
      console.log('season index');
      if (this.seasonCache) {
        return this.seasonCache;
      }
      this.seasonCache = Season.query();
      return this.seasonCache;
    };
    Season.find = function(id) {
      console.log('find season ' + id);
      return Season.get({
        id: id
      });
    };
    Season["delete"] = function(c) {
      var _this = this;
      console.log("deleting season");
      console.log(c);
      return Season.delete_season({
        season_id: c.id
      }, function(response) {
        var i, r, _i, _len, _ref, _results;
        console.log(response);
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
          console.log("Updated:");
          console.log(new_c);
          _ref = _this.seasonCache;
          for (i = _i = 0, _len = _ref.length; _i < _len; i = ++_i) {
            r = _ref[i];
            if (r.id === old_id) {
              _this.seasonCache[i] = new_c;
              console.log("replace season");
              break;
            }
          }
          return new_c;
        });
      } else {
        return Season.save({}, c, function(new_c) {
          console.log("Created:");
          console.log(new_c);
          _this.seasonCache.unshift(new_c);
          return new_c;
        });
      }
    };
    return Season;
  });

}).call(this);

//# sourceMappingURL=../../scripts/services/season.js.map

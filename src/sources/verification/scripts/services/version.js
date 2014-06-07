(function() {
  "use strict";
  angular.module("verificationApp").factory("Version", function($resource, Criteria) {
    var Version, resetCache;
    Version = $resource("/sources/verification/index.php", {
      controller: "versions"
    }, {
      query: {
        method: "GET",
        isArray: true,
        params: {
          action: "index"
        }
      },
      save: {
        method: "POST",
        params: {
          action: "create"
        }
      },
      update: {
        method: "POST",
        params: {
          action: "update"
        }
      },
      delete_version: {
        method: "DELETE",
        params: {
          action: "delete"
        }
      }
    });
    resetCache = function() {
      console.log("reset version cache");
      return Version.versionCache = null;
    };
    Version.index = function() {
      console.log('version index');
      if (this.versionCache) {
        return this.versionCache;
      }
      this.versionCache = Version.query();
      return this.versionCache;
    };
    Version["delete"] = function(c) {
      var _this = this;
      console.log("deleting version");
      console.log(c);
      return Version.delete_version({
        version_id: c.id
      }, function(response) {
        var i, r, _i, _len, _ref;
        console.log(response);
        _ref = _this.versionCache;
        for (i = _i = 0, _len = _ref.length; _i < _len; i = ++_i) {
          r = _ref[i];
          if (r.id === c.id) {
            _this.versionCache.splice(i, 1);
            break;
          }
        }
        return Criteria.resetCache();
      });
    };
    Version.upsert = function(c) {
      var old_id,
        _this = this;
      if (c.id) {
        old_id = c.id;
        return Version.update({}, c, function(new_c) {
          var i, r, _i, _len, _ref;
          console.log("Updated:");
          console.log(new_c);
          _ref = _this.versionCache;
          for (i = _i = 0, _len = _ref.length; _i < _len; i = ++_i) {
            r = _ref[i];
            if (r.id === old_id) {
              _this.versionCache[i] = new_c;
              console.log("replace version");
              break;
            }
          }
          return new_c;
        });
      } else {
        return Version.save({}, c, function(new_c) {
          console.log("Created:");
          console.log(new_c);
          _this.versionCache.unshift(new_c);
          Criteria.resetCache();
          return new_c;
        });
      }
    };
    return Version;
  });

}).call(this);

//# sourceMappingURL=../../scripts/services/version.js.map

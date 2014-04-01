"use strict"
angular.module("verificationApp").factory "Auth", ($location, $rootScope, Session, User, $window) ->

  ###
  Authenticate user
  
  @param  {Object}   user     - login info
  @param  {Function} callback - optional
  @return {Promise}
  ###
  login: (user, callback) ->
    cb = callback or angular.noop
    Session.save(
      nickname: user.nickname
      password: user.password
    , (user) ->
      $rootScope.currentUser = user
      cb()
    , (err) ->
      cb err
    ).$promise



  ###
  Unauthenticate user
  
  @param  {Function} callback - optional
  @return {Promise}
  ###

  logout: (callback)->
    cb = callback || angular.noop
    return Session.delete(
      ()->
        $rootScope.currentUser = null;
        $location.url('/');
        $window.location.reload(true);
        return cb();
      ,(err)->
        return cb(err);
      ).$promise


  ###
  Gets all available info on authenticated user
  
  @return {Object} user
  ###
  currentUser: ()->
    User.current()


  ###
  Simple check to see if a user is logged in
  
  @return {Boolean}
  ###
  isLoggedIn: ->
    user = $rootScope.currentUser
    !!user

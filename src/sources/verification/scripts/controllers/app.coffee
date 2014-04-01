'use strict';

angular.module('verificationApp')
  .controller 'AppCtrl', ($scope, $http, Auth, $rootScope)->
    unless $rootScope.currentUser
      Auth.currentUser().$promise.then( (user)->
        console.log user
        if user.id?
          $rootScope.currentUser = user;
        else
          $rootScope.currentUser = null;
      ).catch( (err)->
        console.log('Current user:'+err.data);
  #        $scope.errors.other = err.message;
      );
    $rootScope.logout = ()->
      Auth.logout()

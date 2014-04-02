'use strict';

angular.module('verificationApp')
  .controller 'AppCtrl', ($scope, $http, Auth, $rootScope, $location, $window)->
    unless $rootScope.currentUser
      Auth.currentUser().$promise.then( (user)->
        console.log user
        if user.id?
          $rootScope.currentUser = user;
        else
          $rootScope.currentUser = null;
          alert('Пользователь в текущей сессии не найден, перенаправляем..')
          new_path = $location.protocol()+"://"+$location.host()+":"+$location.port()
          $window.location.href = new_path
      ).catch( (err)->
        console.log('Current user:'+err.data);
  #        $scope.errors.other = err.message;
      );
    $rootScope.logout = ()->
      Auth.logout()
    $scope.location = $location.path()

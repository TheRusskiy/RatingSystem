'use strict';

angular.module('verificationApp')
  .controller 'MainCtrl', ($scope, $http, Auth, $rootScope, $location, $window)->
    unless $rootScope.currentUser
      Auth.currentUser().$promise.then( (user)->
        if user.id?
          $rootScope.currentUser = user;
          $rootScope.is_admin = user.role=="admin"
        else
          $rootScope.currentUser = null;
          alert('Пользователь в текущей сессии не найден, перенаправляем..')
          new_path = $location.protocol()+"://"+$location.host()+":"+$location.port()
          $window.location.href = new_path
      ).catch( (err)->
        if (err)
          console.log('Authentication error:'+err.data);
        else
          console.log('Authentication error:'+err);
      );
    $rootScope.logout = ()->
      Auth.logout()
    $scope.location = $location.path()
    $rootScope.goto = (path)->
      console.log path
      $location.path(path)
      $scope.location = $location.path()

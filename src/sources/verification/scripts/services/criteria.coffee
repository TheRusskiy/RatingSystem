"use strict"
angular.module("verificationApp").factory "Criteria", ($resource) ->
  criterias = [
    {
      id: 1
      title: "Руководство студентами в межвузовской олимпиаде"
      description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat."
    }
    {
      id: 2
      title: "Публикации в журналах"
      description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi."
    }
    {
      id: 3
      title: "Приглашение иностранного преподавателя"
      description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua. Et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi."
    }
  ]
  for c in criterias
    c.$remove = ()-> console.log("Removing criteria "+c.id.toString())
  return {
      index: ()->
        criterias
    }



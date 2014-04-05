"use strict"
angular.module("verificationApp").factory "Criteria", ($resource) ->
  criteria = $resource "/sources/verification/index.php", {controller: "criteria"},
    query:
      method: "GET"
      isArray:true
      params:
        action: "index"
  return {
  index: ()->
    console.log 'criteria index'
    return @criteriaCache if @criteriaCache
    @criteriaCache = criteria.query()
    return @criteriaCache
  }



#criterias = [
#    {
#      id: 1
#      title: "Руководство студентами в межвузовской олимпиаде"
#      description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
#            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
#            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
#            consequat."
#      options: [
#        {
#          value: 1
#          name: "1 место"
#        }
#        {
#          value: 2
#          name: "2 место"
#        }
#        {
#          value: 3
#          name: "3 место"
#        }
#      ]
#    }
#    {
#      id: 2
#      title: "Публикации в журналах"
#      description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
#            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
#            quis nostrud exercitation ullamco laboris nisi."
#    }
#    {
#      id: 3
#      title: "Приглашение иностранного преподавателя"
#      description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
#            tempor incididunt ut labore et dolore magna aliqua. Et dolore magna aliqua. Ut enim ad minim veniam,
#            quis nostrud exercitation ullamco laboris nisi."
#    }
#  ]
#  return {
#      index: ()->
#        criterias
#    }
#


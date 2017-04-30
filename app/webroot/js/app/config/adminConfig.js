var app = angular.module('myApp', ['ngRoute', 'ui.bootstrap', 'ngAnimate']);

app.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
    when('/', {
      title: 'Products',
      templateUrl: 'admins/userList',
      controller: 'usersCrtl'
    }) 
    .when('/usersManager', {
      title: '/usersManager',            
      templateUrl: 'admins/userList',
      controller: 'usersCrtl'
    })
    .when('/admins/userAdd', {
      title: '/addUser',      
      templateUrl: 'admins/userAdd',
    })  
    .when('/admins/userEdit/:rec_id', {
      title: '/editUser',      
       templateUrl: function(params){ return 'admins/userEdit?user_id=' + params.rec_id; }      
    })
    .when('/departmentsManager', {
      title: '/departmentsManager',      
      templateUrl: 'admins/departmentList',
      controller: 'departmentCrtl'
    }) 
    .when('/admins/departmentAdd', {
      title: '/addDepartment',      
      templateUrl: 'admins/departmentAdd',
    })  
    .when('/admins/departmentEdit/:rec_id', {
      title: '/editUser',      
       templateUrl: function(params){ return 'admins/departmentEdit?department_id=' + params.rec_id; }      
    })
    .when('/systemSettings', {
      title: '/systemSettings',
      templateUrl: 'admins/settingsList',
    }) 
    .when('/admins/settingEdit/:rec_id', {
      title: '/editSetting',      
       templateUrl: function(params){ return 'admins/settingEdit?setting_id=' + params.rec_id; }      
    })
    .when('/changePassword', {
      title: '/changePassword',
      templateUrl: 'users/changePassword',
    }) 
    .when('/shiftsManager', {
      title: '/shifsManager',
      templateUrl: 'admins/shiftList',
    })
    .when('/missionsManager', {
      title: '/missionsManager',
      templateUrl: 'admins/missionList',
    }) 
    .when('/admins/shiftAdd', {
      title: '/addShift',      
      templateUrl: 'admins/shiftAdd',
    })   
    .when('/admins/shiftEdit/:rec_id', {
      title: '/EditShift',      
       templateUrl: function(params){ return 'admins/shiftEdit?shift_id=' + params.rec_id; }      
    })
    .when('/admins/missionAdd', {
      title: '/addMission',      
      templateUrl: 'admins/missionAdd',
    })   
    .when('/managers/missionEdit/:rec_id', {
      title: '/EditMission',      
       templateUrl: function(params){ return 'managers/missionEdit?mission_id=' + params.rec_id; }      
    })  
    .otherwise({
      redirectTo: '/'
    });
}]);



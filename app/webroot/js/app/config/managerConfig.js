
var app = angular.module('myApp', ['ngRoute', 'ui.bootstrap', 'ngAnimate','ui.bootstrap.persian.datepicker','ui.bootstrap.datepicker','xeditable']);

app.run(function(editableOptions) {
  editableOptions.theme = 'bs3';
});

app.config(['$routeProvider',
  function($routeProvider,$routeParams) {
    $routeProvider.
    when('/', {
      title: 'shift',
      templateUrl: 'managers/missionList',      
    }) 
    .when('/shiftsManager', {
      title: '/shifsManager',
      templateUrl: 'managers/shiftList',
    })
    .when('/missionsManager', {
      title: '/missionsManager',
      templateUrl: 'managers/missionList',
    }) 
    .when('/changePassword', {
      title: '/changePassword',
      templateUrl: 'users/changePassword',
    }) 
    .when('/managers/shiftAdd', {
      title: '/addShift',      
      templateUrl: 'managers/shiftAdd',
    })   
    .when('/managers/shiftEdit/:rec_id', {
      title: '/EditShift',      
       templateUrl: function(params){ return 'managers/shiftEdit?shift_id=' + params.rec_id; }      
    })
    .when('/managers/missionAdd', {
      title: '/addMission',      
      templateUrl: 'managers/missionAdd',
    })   
    .when('/managers/missionEdit/:rec_id', {
      title: '/EditMission',      
       templateUrl: function(params){ return 'managers/missionEdit?mission_id=' + params.rec_id; }      
    })
    .otherwise({
      redirectTo: '/'
    });
}]);

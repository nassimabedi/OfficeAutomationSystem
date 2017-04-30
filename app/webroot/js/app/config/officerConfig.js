var app = angular.module('myApp', ['ngRoute', 'ui.bootstrap', 'ngAnimate','ui.bootstrap.persian.datepicker','ui.bootstrap.datepicker']);



app.config(['$routeProvider',
  function($routeProvider,$routeParams) {
    $routeProvider.
    when('/', {
      title: 'shift',
      templateUrl: 'officers/missionReport',
    }) 
    .when('/shifReport', {
      title: '/shifReport',
      templateUrl: 'officers/shiftReport',
    })
    .when('/missionReport', {
      title: '/missionReport',
      templateUrl: 'officers/missionReport',
      //controller: 'missionReportCrtl'
    }) 
    .when('/changePassword', {
      title: '/changePassword',
      templateUrl: 'users/changePassword',
    }) 
    .when('/staffs/shiftAdd', {
      title: '/addShift',      
      templateUrl: 'staffs/shiftAdd',
    })   
    .when('/staffs/shiftEdit/:rec_id', {
      title: '/EditShift',      
       templateUrl: function(params){ return 'staffs/shiftEdit?shift_id=' + params.rec_id; }      
    })
    .when('/staffs/missionAdd', {
      title: '/addMission',      
      templateUrl: 'staffs/missionAdd',
    })   
    .when('/staffs/missionEdit/:rec_id', {
      title: '/EditMission',      
       templateUrl: function(params){ return 'staffs/missionEdit?mission_id=' + params.rec_id; }      
    })
    .otherwise({
      redirectTo: '/'
    });
}]);

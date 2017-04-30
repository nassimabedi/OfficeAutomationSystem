//var app = angular.module('myApp', ['ngRoute', 'ui.bootstrap', 'ngAnimate','ui.bootstrap.persian.datepicker','ui.bootstrap.datepicker','xeditable']);
var app = angular.module('myApp', ['ngRoute', 'ui.bootstrap','ui.bootstrap.persian.datepicker','ui.bootstrap.datepicker','xeditable','ADM-dateTimePicker']);

app.run(function(editableOptions) {
  editableOptions.theme = 'bs3';
});


app.config(['$routeProvider',
  function($routeProvider,$routeParams) {
    $routeProvider.
    when('/', {
      title: 'shift',
      templateUrl: 'staffs/missionList',      
    }) 
    .when('/shiftsManager', {
      title: '/shiftsManager',
      templateUrl: 'staffs/shiftList',
    })
    .when('/missionsManager', {
      title: '/missionsManager',
      templateUrl: 'staffs/missionList',
    }) 
    .when('/changePassword', {
      title: '/changePassword',
      templateUrl: 'users/changePassword',
    }) 
    .when('/staffs/shiftAdd', {
      title: '/addShift',      
      templateUrl: 'staffs/shiftAdd',
    })  
    .when('/test', {
      title: '/test',      
      templateUrl: 'staffs/test',
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
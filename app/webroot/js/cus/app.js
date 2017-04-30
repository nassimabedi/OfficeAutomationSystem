var app = angular.module('myApp', ['ngRoute', 'ui.bootstrap', 'ngAnimate']);

/*app.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
    when('/', {
      title: 'Products',
      //templateUrl: 'partials/products11111.html',      
      //templateUrl: 'departments/index',
      templateUrl: 'admins/departmentList',
      controller: 'productsCtrl'
    })
    .otherwise({
      redirectTo: '/'
    });;
}]);*/


app.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
    when('/', {
      title: 'Products',
      //templateUrl: 'partials/products11111.html',      
      //templateUrl: 'departments/index',
      templateUrl: 'admins/departmentList',
      controller: 'productsCtrl'
    }) 
    .when('/usersManager', {
      title: '/usersManager',
      //templateUrl: 'partials/products11111.html',      
      //templateUrl: 'departments/index',
      templateUrl: 'users/test',
      controller: 'usersCrtl'
    })
    .when('/departmentsManager', {
      title: '/departmentsManager',
      //templateUrl: 'partials/products11111.html',      
      //templateUrl: 'departments/index',
      templateUrl: 'admins/departmentList',
      controller: 'productsCtrl'
    }) 
    .when('/changePassword', {
      title: '/changePassword',
      templateUrl: 'users/changePassword',
    })   
    .otherwise({
      redirectTo: '/'
    });
}]);
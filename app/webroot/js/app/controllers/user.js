//var app = angular.module('myApp', ['ui.bootstrap']);

app.filter('startFrom', function() {
    return function(input, start) {
        if(input) {
            start = +start; //parse to int
            return input.slice(start);
        }
        return [];
    }
});
app.controller('usersCrtl', function ($scope, $http, $timeout) {
   //$http.get('getUserList').success(function(data){
     $http.get('users/getUserList').success(function(data){
        //console.log(data);
        $scope.list = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 5; //max no of items to display in a page
        $scope.filteredItems = $scope.list.length; //Initially for no filter  
        $scope.totalItems = $scope.list.length;
    });
    $scope.setPage = function(pageNo) {
        $scope.currentPage = pageNo;
    };
    $scope.filter = function() {
        $timeout(function() { 
            $scope.filteredItems = $scope.filtered.length;
        }, 10);
    };
    $scope.sort_by = function(predicate) {
        $scope.predicate = predicate;
        $scope.reverse = !$scope.reverse;
    };
    //$scope.changeProductStatus = function(product){
    $scope.changeProductStatus = function(pp){
        //product.status = (product.status=="Active" ? "Inactive" : "Active");
        //product.status = (product.status=="Active" ? "Inactive" : "Active");
        console.log('pp');
        //data.User.disabled = (data.User.disabled=="0" ? "Inactive" : "Active");
        //Data.put("products/"+product.id,{status:product.status});
    };
});


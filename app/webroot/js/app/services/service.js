app.service('fileUpload', ['$http', function ($http) {
    this.uploadFileToUrl = function(file, uploadUrl){
        var fd = new FormData();
        fd.append('file', file);
        $http.post(uploadUrl, fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined}
        })
        .success(function(){
          //alert('ssss');
        })
        .error(function(){
          //alert('eeee');
        });
    }
}]);



app.service('shiftService',['$http',function($http,$rootScope){
    
    this.shiftServiceShow = function( ){
        alert('shiftService');
       /* $rootScope.services = [    
        ];

  $scope.checkName = function(data, id) {
    if (id === 2 && data !== 'awesome') {
      return "Username 2 should be `awesome`";
    }
  };

  $scope.saveService = function(data, id) {
    //$scope.user not updated yet
    alert('ssss');
    angular.extend(data, {id: id});
    console.log(data);
    //return $http.post('/saveUser', data);
  };

  // remove service
  $scope.removeService = function(index) {
    $scope.services.splice(index, 1);
  };

  // add service
  $scope.addService = function() {
    alert('zzzzz');
    $scope.inserted = {
      id: $scope.services.length+1,
      customer: '',
      ticket_num: null,
      description: null 
    };
    $scope.services.push($scope.inserted);
  };*/
     
  
    }

}]);
app.filter('startFrom', function() {
    return function(input, start) {
        if(input) {
            start = +start; //parse to int
            return input.slice(start);
        }
        return [];
    }
});
app.controller('departmentCrtl', function ($scope, $http,$location, $timeout) {   
     $http.get('admins/getAllDepartments').success(function(data){        
        $scope.list = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 10; //max no of items to display in a page
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
    
    $scope.add = function (path) {        
        $location.path( path );
    };

    $scope.edit = function (path,rec_id) {           
        $location.path( path +'/'+rec_id);
    }

     $scope.delete = function (rec_id) {            
        
        if(confirm("آیا از حذف رکورد مطمئن هستید؟")){          
            $http({
               method:'post',        
                url:'admins/deleteDepartment',        
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                params: { 
                  id : rec_id,
                }
              }).success(function(data){              
                  var index = -1;   
                  var comArr = eval( $scope.list );
                  for( var i = 0; i < comArr.length; i++ ) {
                    if( comArr[i].Departments.id === rec_id ) {
                      index = i;
                      break;
                    }
                  }
                  if( index === -1 ) {
                    alert( "Something gone wrong" );
                  }
                  $scope.list.splice( index, 1 );
              });
          
        }
      }


});

app.controller('departmentAddCrtl', function ($scope, $http,$location, $timeout,$modal,$q) {

    $scope.submitForm = function(isValid) {        
    if (isValid) {             
      department = $scope.department;      
      
      $http({
       method:'post',        
        url:'admins/departmentInsert',        
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        params: { 
                  department : department,
                }
      }).success(function(result){                    
          window.location.href = "Admins#/departmentsManager";
      });
    }

  }

})

app.controller('departmentEditCrtl', function ($scope, $http,$location, $timeout,$modal,$q,$routeParams) {
    $http.get("admins/getDepartment?rec_id="+$routeParams.rec_id).success(function(data)
    {      
      $scope.department = data.Departments.name;            
      $scope.department_id = data.Departments.id;
 
    });
    $scope.submitForm = function(isValid) { 
      if (isValid) {         
        department = $scope.department;   
        department_id = $scope.department_id;   
        
        $http({
         method:'post',        
          url:'admins/departmentUpdate',        
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
          params: { id : department_id,
                    department : department,
                    }
        }).success(function(result){            
            window.location.href = "Admins#/departmentsManager";
        });
      }
  }

})


app.controller('usersCrtl', function ($scope, $http,$location, $timeout) {

   //$http.get('getUserList').success(function(data){
     $http.get('admins/getUsers').success(function(data){        
        $scope.list = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 10; //max no of items to display in a page
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
    
    $scope.add = function (path) {        
        $location.path( path );
    };

     $scope.edit = function (path,rec_id) {           
        $location.path( path +'/'+rec_id);
    }

      var processOptions = function(){
        var options = angular.copy($scope.options);

        if (options.values.length === 0) {
            options.values = undefined;
        }

        options.buttons = _.chain(options.buttons.split(','))
            .filter(function(val){
                return val;
            })
            .map(function(val){
                val = val.trim();
                return {label:val,cancel:val.toLowerCase() === 'cancel',primary:val.toLowerCase() === 'ok'};
            })
            .value();
        if (options.buttons.length === 0) {
            options.buttons = undefined;
        }

        if (!options.input){
            options.input = undefined;
            options.value = undefined;
            options.values = undefined;
            options.label = undefined;
        }
        return options;
    };
    $scope.deleteUser = function (rec_id) {            
        
        if(confirm("آیا از حذف رکورد مطمئن هستید؟")){          
            $http({
               method:'post',        
                url:'admins/deleteUser',        
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                params: { 
                  id : rec_id,
                }
              }).success(function(data){              
                  var index = -1;   
                  var comArr = eval( $scope.list );
                  for( var i = 0; i < comArr.length; i++ ) {
                    if( comArr[i].User.id === rec_id ) {
                      index = i;
                      break;
                    }
                  }
                  if( index === -1 ) {
                    alert( "Something gone wrong" );
                  }
                  $scope.list.splice( index, 1 );
              });
          
        }
      }
});

app.controller('userAddCrtl', function ($scope, $http,$location, $timeout,$modal,$q) {
    $http.get('admins/getAllDepartments').success(function(data){        
      $scope.departments = data;
    });

    $scope.submitForm = function(isValid) {        
    if (isValid) {             
          
      
      $http({
       method:'post',        
        url:'admins/userInsert',        
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        params: { 
                  first_name : $scope.first_name,
                  last_name : $scope.last_name,
                  username : $scope.username,
                  password : $scope.password,
                  department : $scope.department_id,
                  role : $scope.role_id,
                }
      }).success(function(result){          
          window.location.href = "Admins#/usersManager";
      });
    }

  }

})


app.controller('userEditCrtl', function ($scope, $http,$location, $timeout,$modal,$q,$routeParams) {
    $http.get('admins/getAllDepartments').success(function(data){        
      $scope.departments = data;
    });

     $http.get("admins/getUser?rec_id="+$routeParams.rec_id).success(function(data)
    {            
      $scope.user_id = data.User.id;            
      $scope.first_name = data.User.first_name;
      $scope.last_name = data.User.last_name;
      $scope.username = data.User.username;
      $scope.password = data.User.password;
      $scope.role_id = data.User.role;
      $scope.department_id = data.Departments.id;
 
    });

    $scope.submitForm = function(isValid) {        
    if (isValid) {             
          
      $http({
       method:'post',        
        url:'admins/userUpdate',        
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        params: { 
                  id : $scope.user_id,
                  first_name : $scope.first_name,
                  last_name : $scope.last_name,
                  username : $scope.username,
                  password : $scope.password,
                  department : $scope.department_id,
                  role : $scope.role_id,
                }
      }).success(function(result){          
          window.location.href = "Admins#/usersManager";
      });
    }

  }

})


app.controller('settingsCrtl', function ($scope, $http,$location, $timeout) {   
     $http.get('admins/getSettings').success(function(data){          
        $scope.list = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 10; //max no of items to display in a page
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

    $scope.edit = function (path,rec_id) {           
        $location.path( path +'/'+rec_id);
    }

});


app.controller('settingEditCrtl', function ($scope, $http,$location, $timeout,$modal,$q,$routeParams) {

  //========time  
  $scope.leave_time = new Date();  

  $scope.hstep = 1;
  $scope.mstep = 15;

  $scope.options = {
    hstep: [1, 2, 3],
    mstep: [1, 5, 10, 15, 25, 30]
  };

  $scope.ismeridian = false;

  $scope.update = function() {
    var d = new Date();
    d.setHours( 14 );
    d.setMinutes( 0 );
    $scope.mytime = d;
  };

  $scope.changed = function () {
  };

  $scope.clear = function() {
    $scope.mytime = null;
  };    
     $http.get("admins/getSetting?rec_id="+$routeParams.rec_id).success(function(data)
    {           
      $scope.setting_id = data.Settings.id;            
      $scope.leave_time = new Date(data.Settings.leave_time.replace(/-/g,"/"));      
    });

    $scope.submitForm = function(isValid) {        
    if (isValid) {   
      setting_id = $scope.setting_id;
      leave_time = $scope.leave_time.getHours() + ':'+$scope.leave_time.getMinutes()          
          
      $http({
       method:'post',        
        url:'admins/settingUpdate',        
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        params: { 
                  id : $scope.setting_id,
                  leave_time : leave_time,                 
                }
      }).success(function(result){          
          window.location.href = "Admins#/systemSettings";
      });
    }

  }

})




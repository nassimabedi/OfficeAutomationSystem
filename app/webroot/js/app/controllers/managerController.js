function getUsers($http,$scope) {    
    $http.get('Managers/getUsers').success(function(data){  
        $scope.users = data;        
    });    
}

function getLeaveTime($http,$scope) {    
    $http.get('Managers/getLeaveTime').success(function(data){          
        $scope.start_leave_time = data.Settings.leave_time;        
    });    
}



function covertDate (date,time) { 
  return date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate() + ' ' + time.getHours() + ':'+time.getMinutes();
}




function displayShiftDate($scope) {
   $scope.today = function() {
    $scope.dt = new Date();
  };
  $scope.today();

  $scope.clear = function () {
    $scope.dt = null;
  };

  // Disable weekend selection
  $scope.disabled = function(date, mode) {
    return ( mode === 'day' &&date.getDay() === 5  );
  };

  $scope.toggleMin = function() {
    $scope.minDate = $scope.minDate ? null : new Date();
  };
  $scope.toggleMin();

  $scope.openPersian = function($event) {    
    $event.preventDefault();
    $event.stopPropagation();

    $scope.persianIsOpen = true;        
  };



  $scope.openPersianEndDate = function($event) {
    $event.preventDefault();
    $event.stopPropagation();
    
    $scope.persianIsOpenEndDate = true;
  };


  $scope.dateOptions = {
    formatYear: 'yy',
    startingDay: 6
  };

  $scope.initDate = new Date('2016-15-20');
  $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
  $scope.format = $scope.formats[1];

}


function displayMissionDate($scope) {
   $scope.today = function() {
    $scope.dt = new Date();
  };
  $scope.today();

  $scope.clear = function () {
    $scope.dt = null;
  };

  // Disable weekend selection
  $scope.disabled = function(date, mode) {
    return ( mode === 'day' &&date.getDay() === 5  );
  };

  $scope.toggleMin = function() {
    $scope.minDate = $scope.minDate ? null : new Date();
  };
  $scope.toggleMin();

  $scope.openPersian = function($event) {    
    $event.preventDefault();
    $event.stopPropagation();

    $scope.persianIsOpen = true;        
  };


 
  $scope.openPersianStartDate = function($event) {
    $event.preventDefault();
    $event.stopPropagation();

    $scope.persianIsOpenStartDate = true;
  };

  $scope.openPersianEndDate = function($event) {
    $event.preventDefault();
    $event.stopPropagation();
    
    $scope.persianIsOpenEndDate = true;
  };


  $scope.dateOptions = {
    formatYear: 'yy',
    startingDay: 6
  };

  $scope.initDate = new Date('2016-15-20');
  $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
  $scope.format = $scope.formats[1];

}


function displayMissionTime($scope) {
//========time
    $scope.mytime = new Date();
    $scope.start_time = new Date();
    $scope.end_time = new Date();

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

}


function openCalendar(func_name,variable) {
   func_name = function($event) {
    $event.preventDefault();
    $event.stopPropagation();
    variable = true;    
  };
}





app.filter('startFrom', function() {
    return function(input, start) {
        if(input) {
            start = +start; //parse to int
            return input.slice(start);
        }
        return [];
    }
});

app.controller('shiftListCrtl', function ($scope, $http,$location, $timeout,$modal) {
    displayDate($scope);
    displayTime($scope);

    getUsers($http,$scope);

    $scope.currentPage = 1;
    params = { 
              curr_page : $scope.currentPage,
              };
    showList('managers/getShifts',params,$http,$scope);   
  
    $scope.setPage = function(pageNo) {
      $scope.currentPage = pageNo;        
      if (typeof($scope.start_date)!=='undefined') {
        start_date = $scope.start_date.getFullYear()+'-'+($scope.start_date.getMonth()+1)+'-'+$scope.start_date.getDate();
      } else {
        start_date = '';
      }
      
      if (typeof($scope.end_date)!=='undefined') {
        end_date = $scope.end_date.getFullYear()+'-'+($scope.end_date.getMonth()+1)+'-'+$scope.end_date.getDate();      
      } else {
        end_date = '';
      }

      if (typeof($scope.user_id) !=='undefined') {
        user_id = $scope.user_id; 
      }  else {
        user_id = '';
      }
          
               
      params = { 
                curr_page : $scope.currentPage,                
                start_date : start_date,
                end_date : end_date,
                user_id : user_id                                
                };
      
      showList('managers/getShifts',params,$http,$scope);
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
            url:'Managers/shiftDelete',        
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            params: { 
              id : rec_id,
            }
          }).success(function(data){              
              var index = -1;   
              var comArr = eval( $scope.list );
              for( var i = 0; i < comArr.length; i++ ) {
                if( comArr[i].Shifts.id === rec_id ) {
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

  $scope.submitForm = function(isValid) {        
    if (isValid) {       
      start_date = $scope.start_date.getFullYear()+'-'+($scope.start_date.getMonth()+1)+'-'+$scope.start_date.getDate();
      end_date = $scope.end_date.getFullYear()+'-'+($scope.end_date.getMonth()+1)+'-'+$scope.end_date.getDate();      
      user_id = $scope.user_id;     
         
      $scope.currentPage = 1;
      params = { 
                curr_page : $scope.currentPage,                
                start_date : start_date,
                end_date : end_date,
                user_id : user_id                                
                };
      showList('Managers/getShifts',params,$http,$scope);
    }

  }

  $scope.approve_shift = function (rec_id,approve_val) {   
       $http({
         method:'post',        
          url:'Managers/approveShift',        
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
          params: { id : rec_id,
                    approve : approve_val,
                                                  
                    }
        }).success(function(result){                        
           //window.location.href = "Managers#/missionsManager";
        });
  }

});


app.controller('missionListCrtl', function ($scope, $http,$location, $timeout,$modal) {       
    
    displayDate($scope);
    displayTime($scope);

    getUsers($http,$scope);
    $scope.currentPage = 1;
    params = { 
              curr_page : $scope.currentPage,
              };
    showList('managers/getMissions',params,$http,$scope);   
    $scope.setPage = function(pageNo) {
      $scope.currentPage = pageNo;
      if (typeof($scope.start_date)!=='undefined') {
        start_date = $scope.start_date.getFullYear()+'-'+($scope.start_date.getMonth()+1)+'-'+$scope.start_date.getDate();
      } else {
        start_date = '';
      }
      
      if (typeof($scope.end_date)!=='undefined') {
        end_date = $scope.end_date.getFullYear()+'-'+($scope.end_date.getMonth()+1)+'-'+$scope.end_date.getDate();      
      } else {
        end_date = '';
      }

      if (typeof($scope.user_id) !=='undefined') {
        user_id = $scope.user_id; 
      }  else {
        user_id = '';
      }
          
               
      params = { 
                curr_page : $scope.currentPage,                
                start_date : start_date,
                end_date : end_date,
                user_id : user_id                                
                };
      
      showList('managers/getMissions',params,$http,$scope);
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
            url:'Managers/missionDelete',        
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            params: { 
              id : rec_id,
            }
          }).success(function(data){              
              var index = -1;   
              var comArr = eval( $scope.list );
              for( var i = 0; i < comArr.length; i++ ) {
                if( comArr[i].Missions.id === rec_id ) {
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


  $scope.submitForm = function(isValid) {        
    if (isValid) {             
      start_date = $scope.start_date.getFullYear()+'-'+($scope.start_date.getMonth()+1)+'-'+$scope.start_date.getDate();
      end_date = $scope.end_date.getFullYear()+'-'+($scope.end_date.getMonth()+1)+'-'+$scope.end_date.getDate();      
      user_id = $scope.user_id;     
         
      $scope.currentPage = 1;
      params = { 
                curr_page : $scope.currentPage,                
                start_date : start_date,
                end_date : end_date,
                user_id : user_id                                
                };
      showList('Managers/getMissions',params,$http,$scope);
    }

  }

    $scope.approve_mission = function (rec_id,approve_val) {
       $http({
         method:'post',        
          url:'Managers/approveMission',        
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
          params: { id : rec_id,
                    approve : approve_val,
                                                  
                    }
        }).success(function(result){                        
           //window.location.href = "Managers#/missionsManager";
        });
  } 


});





app.controller('missionAddCrtl', function ($scope, $http,$location, $timeout,$modal,$q,fileUpload) {
    displayMissionDate($scope);
    displayMissionTime($scope);  
    getAccounts($http,$scope);    
    getUsers($http,$scope);
    
    file_name = '';


    $scope.uploadFile = function(){
        var file = $scope.mission_file;
        file_name = $scope.mission_file.name;
        var uploadUrl = "Managers/fileUpload?type=missions";
        fileUpload.uploadFileToUrl(file, uploadUrl);
    };
  
    $scope.submitForm = function(isValid) {               
        if (isValid) {               
          user_id = $scope.user_id;  
          date = $scope.date.getFullYear()+'-'+($scope.date.getMonth()+1)+'-'+$scope.date.getDate()
          start_time = covertDate($scope.start_date,$scope.start_time);
          end_time = covertDate($scope.end_date,$scope.end_time);
          customer_name = $scope.customer_name;
          purpose = $scope.purpose;
          description = $scope.description;
          mission_type = $scope.mission_type;
       
          
          $http({
           method:'post',        
            url:'Managers/missionInsert',        
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            params: { 
                      user_id : user_id,
                      date : date,
                      customer_name : customer_name,
                      purpose : purpose,
                      mission_type : mission_type,
                      start_time : start_time,
                      end_time : end_time,
                      description :description,
                      file_name :file_name}
          }).success(function(result){              
              window.location.href = "Managers#/missionsManager";
          });
        }

      }
});


app.controller('missionEditCrtl', function ($scope, $http,$location, $timeout,$modal,$routeParams,fileUpload) {
  displayMissionDate($scope);
  displayMissionTime($scope);
  
  getAccounts($http,$scope); 
  $scope.users = getUsers($http,$scope);
 
  $http.get("Managers/getMission?rec_id="+$routeParams.rec_id).success(function(data)
    {
      
      $scope.user_id = data.User.id;
      $scope.customer_name = data.Missions.customer_name;
      $scope.purpose = data.Missions.purpose;
      $scope.approve = data.Missions.approve;      
      $scope.date = new Date(data.Missions.date);
      $scope.start_date = new Date(data.Missions.start_date);      
      $scope.start_time = new Date(data.Missions.start_time.replace(/-/g,"/"));
      $scope.end_date = new Date(data.Missions.end_date);      
      $scope.end_time = new Date(data.Missions.end_time.replace(/-/g,"/"));
      $scope.description = data.Missions.description;
      $scope.mission_id = data.Missions.id;
      $scope.mission_type = data.Missions.type;
      if (data.Missions.file_name) {
        mission_file = $scope.mission_file_dl = data.Missions.file_name;
      } else {
        mission_file = '';
      }
        
 
    });

    $scope.uploadFile = function(){
        var file = $scope.mission_file;
        mission_file = $scope.mission_file.name;
        var uploadUrl = "Managers/fileUpload?type=missions";
        fileUpload.uploadFileToUrl(file, uploadUrl);
    };

    $scope.download_file = function () {
      url = '/ladybird/files/missions/'+$scope.mission_file_dl; 
      document.location.href = url;      
    } 


    $scope.submitForm = function(isValid) { 
      if (isValid) {          
        user_id = $scope.user_id;    
        date = $scope.date.getFullYear()+'-'+($scope.date.getMonth()+1)+'-'+$scope.date.getDate()
        mission_id = $scope.mission_id;
        start_time = covertDate($scope.start_date,$scope.start_time);
        end_time = covertDate($scope.end_date,$scope.end_time);        
        customer_name = $scope.customer_name;
        purpose = $scope.purpose;
        approve = $scope.approve;
        description = $scope.description;
        mission_type = $scope.mission_type;

     

        
        $http({
         method:'post',        
          url:'Managers/missionUpdate',        
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
          params: { id : mission_id,
                    user_id : user_id,
                    date : date,
                    customer_name : customer_name,
                    mission_type : mission_type,
                    purpose : purpose,
                    start_time : start_time,
                    end_time : end_time,
                    approve : approve,
                    description :description,
                    file_name:mission_file}
        }).success(function(result){            
            window.location.href = "Managers#/missionsManager";
        });
      }
  }


});

app.controller('shiftAddCrtl', function ($scope, $http,$location, $timeout,$modal,$q,shiftService,fileUpload) {
  //Start Shift Service 
  $scope.services = [ 
    ];
  shiftServices($scope);
  // End Shift Service

  $scope.weekend = false;
  $scope.after_shift_date = false;
  $scope.isDisabled = false;

  $scope.getLeaveTime = getLeaveTime($http,$scope);
   $scope.$watch('date',function() {               
        if (typeof($scope.date) != "undefined") {
          $scope.delivery_hour_date = $scope.date;  
          $scope.exit_hour_date = $scope.date;     
          var tomorrow = new Date($scope.date);
          tomorrow.setDate(tomorrow.getDate() + 1);          
          $scope.after_shift_start_date = tomorrow;
          $scope.after_shift_end_date = tomorrow;
          //$scope.isDisabled = false;
        }        
   })

   $scope.$watch('after_shift_end_time',function() {
      
      var end_hour = new Date($scope.after_shift_end_time).getHours();
      var end_mins = new Date($scope.after_shift_end_time).getMinutes();      
      if (typeof($scope.start_leave_time) != "undefined") {
        $scope.overtime = diff($scope.start_leave_time,end_hour + ':' + end_mins);        
      }    
   });

  $scope.message = "";
  displayMissionDate($scope);
  displayMissionTime($scope); 
  displayShiftDate($scope);  
  $scope.users = getUsers($http,$scope);
  $scope.exit_hour_time = new Date();
  $scope.delivery_hour_time = new Date();
  $scope.after_shift_start_time = new Date();
  $scope.after_shift_end_time = new Date(); 
  shift_file = "";

  $scope.uploadFile = function(){
        var file = $scope.shift_file;
        shift_file = $scope.shift_file.name;
        var uploadUrl = "Managers/fileUpload?type=shifts";
        fileUpload.uploadFileToUrl(file, uploadUrl);
 };

 $scope.weekendCheck = function () {            
    if ($scope.weekend ) {
      $scope.after_shift_date = true;
      $scope.overtime = '00:00:00';
    } else {
      $scope.after_shift_date = false;      
    }    
  };


  $scope.submitForm = function(isValid) {       
    if (isValid) {        
      date = $scope.date.getFullYear()+'-'+($scope.date.getMonth()+1)+'-'+$scope.date.getDate();
      user_id = $scope.user_id;
      if (typeof($scope.exit_hour_date)!= "undefined") {
        exit_hour_date = covertDate($scope.exit_hour_date,$scope.exit_hour_time);
      } else {
        exit_hour_date = '';
      }

      if (typeof($scope.delivery_hour_date)!= "undefined") {
        delivery_hour_date = covertDate($scope.delivery_hour_date,$scope.delivery_hour_time);
      } else {
        delivery_hour_date = '';
      }

      if (typeof($scope.all_calls_num)!= "undefined") {
        all_calls_num = $scope.all_calls_num;
      } else {
        all_calls_num = '';
      }
      if (typeof($scope.successfull_calls_num)!= "undefined") {
        successfull_calls_num = $scope.successfull_calls_num;
      } else {
        successfull_calls_num = '';
      }

      if (typeof($scope.unsuccessfull_calls_num)!= "undefined") {
        unsuccessfull_calls_num = $scope.unsuccessfull_calls_num;
      } else {
        unsuccessfull_calls_num = '';
      }

      if (typeof($scope.after_shift_start_date)!= "undefined") {
        after_shift_start_date = covertDate($scope.after_shift_start_date,$scope.after_shift_start_time);
      } else {
        after_shift_start_date = '';
      }

      if (typeof($scope.after_shift_end_date)!= "undefined") {
        after_shift_end_date = covertDate($scope.after_shift_end_date,$scope.after_shift_end_time);
      } else {
        after_shift_end_date = '';
      }

     
      if($scope.services.length > 0){   
        services = toObject($scope.services);
      } else {
        services = '';
      }
      
      $http({
       method:'post',        
        url:'Managers/shiftInsert',        
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        params: { 
                  user_id : user_id,
                  date : date,
                  exit_hour : exit_hour_date,
                  delivery_hour : delivery_hour_date,
                  all_calls_num : all_calls_num,
                  successfull_calls_num : successfull_calls_num,
                  unsuccessfull_calls_num :unsuccessfull_calls_num,
                  after_shift_start_time : after_shift_start_date,
                  after_shift_end_time : after_shift_end_date,
                  overtime : $scope.overtime,
                  send_shift_report : $scope.send_shift_report,
                  description : $scope.desc,
                  services : services,
                  file_name : shift_file
                }
      }).success(function(result){          
          window.location.href = "Managers#/shiftsManager";
      });
    }
  }


});


app.controller('shiftEditCrtl', function ($scope, $http,$location, $timeout,$modal,$routeParams,fileUpload) {
  displayMissionDate($scope);
  displayMissionTime($scope);
  displayMissionTime($scope); 
  displayShiftDate($scope);
  $scope.exit_hour_time = new Date();
  $scope.delivery_hour_time = new Date();
  $scope.after_shift_start_time = new Date();
  $scope.after_shift_end_time = new Date();   
  
  
  
  $scope.users = getUsers($http,$scope);

  $scope.$watch('after_shift_end_time',function() {
      
      var end_hour = new Date($scope.after_shift_end_time).getHours();
      var end_mins = new Date($scope.after_shift_end_time).getMinutes();      
      if (typeof($scope.start_leave_time) != "undefined") {
        $scope.overtime = diff($scope.start_leave_time,end_hour + ':' + end_mins);        
      }    
   });


  /*$scope.$watch('approved_overtime',function() {
      
      var hour_approved_overtime = new Date($scope.approved_overtime).getHours();
      var min_approved_overtime = new Date($scope.approved_overtime).getMinutes();      
      approved_overtime_value = hour_approved_overtime + ':' + min_approved_overtime;
     
   });   */
   
   
  $http.get("Managers/getShift?rec_id="+$routeParams.rec_id).success(function(data)
    {        

      $scope.user_id = data.Shifts.user_id;
      $scope.date = new Date(data.Shifts.date);
      if (data.Shifts.exit_hour != null) {
        $scope.exit_hour_date = new Date(data.Shifts.exit_hour_date);      
        $scope.exit_hour_time = new Date(data.Shifts.exit_hour_time.replace(/-/g,"/"));
      }
      if (data.Shifts.delivery_hour_date != null) {
        $scope.delivery_hour_date = new Date(data.Shifts.delivery_hour_date);      
        $scope.delivery_hour_time = new Date(data.Shifts.delivery_hour_time.replace(/-/g,"/"));
      }
                        
      $scope.all_calls_num = parseInt(data.Shifts.all_calls_num);
      $scope.successfull_calls_num = parseInt(data.Shifts.successfull_calls_num);
      $scope.unsuccessfull_calls_num = parseInt(data.Shifts.unsuccessfull_calls_num);
      if (data.Shifts.after_shift_start_date != null) {
          $scope.after_shift_start_date = new Date(data.Shifts.after_shift_start_date);      
          $scope.after_shift_start_time = new Date(data.Shifts.after_shift_start_time.replace(/-/g,"/"));
      }
      if (data.Shifts.after_shift_end_date != null){
          $scope.after_shift_end_date = new Date(data.Shifts.after_shift_end_date);      
          $scope.after_shift_end_time = new Date(data.Shifts.after_shift_end_time.replace(/-/g,"/"));
      }
      
     $scope.overtime = data.Shifts.overtime;      

      if ($scope.overtime == '00:00:00') {        
        $scope.weekend = true;
        $scope.after_shift_date = true;
      } else {        
        $scope.weekend = false;
        $scope.after_shift_date = false;  
      }

      if (data.Shifts.approved_overtime != null) {
          $scope.approved_overtime = new Date(data.Shifts.approved_overtime);      
          $scope.approved_overtime = new Date(data.Shifts.approved_overtime.replace(/-/g,"/"));
      }

      if (data.Shifts.file_name) {
        shift_file = $scope.shift_file_dl = data.Shifts.file_name;
      } else {
        shift_file = '';
      }

      $scope.desc = data.Shifts.description;
      $scope.shift_id = data.Shifts.id;

      $scope.services = data.Shifts.shift_services;
      shiftServices($scope);         
    });

    $scope.download_file = function () {
      url = '/ladybird/files/shifts/'+$scope.shift_file_dl; 
      document.location.href = url;      
    }    

    $scope.uploadFile = function(){
        var file = $scope.shift_file;
        shift_file = $scope.shift_file.name;
        var uploadUrl = "Managers/fileUpload?type=shifts";
        fileUpload.uploadFileToUrl(file, uploadUrl);
    };
    $scope.submitForm = function(isValid) { 
      if (isValid) {         
        user_id =  $scope.user_id;        
        date = $scope.date.getFullYear()+'-'+($scope.date.getMonth()+1)+'-'+$scope.date.getDate()
        shift_id = $scope.shift_id;
        exit_hour_date = covertDate($scope.exit_hour_date,$scope.exit_hour_time);
        delivery_hour_date = covertDate($scope.delivery_hour_date,$scope.delivery_hour_time);
        all_calls_num = $scope.all_calls_num;
        successfull_calls_num = $scope.successfull_calls_num;
        unsuccessfull_calls_num = $scope.unsuccessfull_calls_num;
        after_shift_start_date = covertDate($scope.after_shift_start_date,$scope.after_shift_start_time);
        after_shift_end_date = covertDate($scope.after_shift_end_date,$scope.after_shift_end_time);
        overtime = $scope.overtime;
        approved_overtime = $scope.approved_overtime;
        approved_resttime = $scope.approved_resttime;

       
          var hour_approved_overtime = new Date($scope.approved_overtime).getHours();
          var min_approved_overtime = new Date($scope.approved_overtime).getMinutes();      
          approved_overtime_value = hour_approved_overtime + ':' + min_approved_overtime;
          
          if($scope.services.length > 0){   
            services = toObject($scope.services);
          } else {
            services = '';
          }
     
        
        $http({
         method:'post',        
          url:'Managers/shiftUpdate',        
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
          params: { id : shift_id,
                    user_id : user_id,
                  date : date,
                  exit_hour : exit_hour_date,
                  delivery_hour : delivery_hour_date,
                  all_calls_num : all_calls_num,
                  successfull_calls_num : successfull_calls_num,
                  unsuccessfull_calls_num :unsuccessfull_calls_num,
                  after_shift_start_time : after_shift_start_date,
                  after_shift_end_time : after_shift_end_date,
                  overtime : $scope.overtime,
                  send_shift_report : $scope.send_shift_report,
                  description : $scope.desc,
                  approved_overtime : approved_overtime_value,
                  approved_resttime : approved_resttime,
                  services : services,
                  file_name : shift_file
                    }
        }).success(function(result){                        
           window.location.href = "Managers#/shiftsManager";
        });
      }
  }


});

//var app = angular.module('myApp', ['ui.bootstrap']);

function covertDate (date,time) { 
  return date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate() + ' ' + time.getHours() + ':'+time.getMinutes();
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



app.controller('missionListCrtl', function ($scope, $http,$location, $timeout,$modal) {
  displayMissionDate($scope);
  displayMissionTime($scope);

    $http.get('officers/getAllUsers').success(function(data){  
        $scope.users = data;        
    }); 
    $http.get('officers/getAllDepartments').success(function(data){          
        $scope.departments = data;        
    });   
   
    $scope.setPage = function(pageNo) {
        $scope.currentPage = pageNo;
	start_date = $scope.start_date.getFullYear()+'-'+($scope.start_date.getMonth()+1)+'-'+$scope.start_date.getDate();
      end_date = $scope.end_date.getFullYear()+'-'+($scope.end_date.getMonth()+1)+'-'+$scope.end_date.getDate();      
      if (typeof($scope.user_id)!='undefined') {
        user_id = $scope.user_id;
      } else {
        user_id = '';
      }
            
      if (typeof($scope.department_id)!='undefined'){
        department_id = $scope.department_id;   
      } else {
        department_id = '';
      }

     if (typeof($scope.mission_type)!= 'undefined' ) {
        mission_type = $scope.mission_type;
     } else {
        mission_type = '';
     }

     if (typeof($scope.customer_name)!= 'undefined') {
	customer_name = $scope.customer_name;
     } else {
	customer_name = '';
	}
        params = { 
              curr_page : $scope.currentPage,
	      start_date : start_date,
                end_date : end_date,
                user_id : user_id,
                department_id : department_id,
                mission_type : mission_type,
		customer_name : customer_name
	              
              };
        //showList('officers/getMissions',params,$http,$scope);
	showList('officers/searchMissions',params,$http,$scope);
    };
    
    $scope.download_csv = function() {

      start_date = $scope.start_date.getFullYear()+'-'+($scope.start_date.getMonth()+1)+'-'+$scope.start_date.getDate();
      end_date = $scope.end_date.getFullYear()+'-'+($scope.end_date.getMonth()+1)+'-'+$scope.end_date.getDate();      
      if (typeof($scope.user_id)!='undefined') {
        user_id = $scope.user_id;
      } else {
        user_id = '';
      }
            
      if (typeof($scope.department_id)!='undefined'){
        department_id = $scope.department_id;   
      } else {
        department_id = '';
      }

     if (typeof($scope.mission_type)!= 'undefined' ) {
	mission_type = $scope.mission_type;
     } else {
	mission_type = '';
     }

      if (typeof($scope.customer_name)!= 'undefined') {
        customer_name = $scope.customer_name;
     } else {
        customer_name = '';
        }
      
      url = '/ladybird/officers/getMissionCsv?start_date='+start_date+'&end_date='+end_date+'&user_id='+user_id+'&department_id='+department_id+'&mission_type='+mission_type+'&customer_name='+customer_name;       
      document.location.href = url;      
    }
    
    //======================form submit==============================
    $scope.submitForm = function(isValid) {        
    if (isValid) {       
      start_date = $scope.start_date.getFullYear()+'-'+($scope.start_date.getMonth()+1)+'-'+$scope.start_date.getDate();
      end_date = $scope.end_date.getFullYear()+'-'+($scope.end_date.getMonth()+1)+'-'+$scope.end_date.getDate();      

      if (typeof($scope.user_id)!='undefined') {
        user_id = $scope.user_id;
      } else {
        user_id = '';
      }

      if (typeof($scope.department_id)!='undefined'){
        department_id = $scope.department_id;
      } else {
        department_id = '';
      }

     if (typeof($scope.mission_type)!= 'undefined' ) {
        mission_type = $scope.mission_type;
     } else {
        mission_type = '';
     }

       if (typeof($scope.customer_name)!= 'undefined') {
        customer_name = $scope.customer_name;
     } else {
        customer_name = '';
        }

         
      $scope.currentPage = 1;
      params = { 
                curr_page : $scope.currentPage,                
                start_date : start_date,
                end_date : end_date,
                user_id : user_id,                
                department_id : department_id,
		mission_type : mission_type,
		customer_name:customer_name
                };
      showList('officers/searchMissions',params,$http,$scope);
    }
  }

});



app.controller('shiftListCrtl', function ($scope, $http,$location, $timeout,$modal) {
  displayMissionDate($scope);
  displayMissionTime($scope);

  $scope.currentPage = 1;
  $scope.entryLimit = 10;

  $http.get('officers/getAllUsers').success(function(data){  
        $scope.users = data;        
  }); 

  $http.get('officers/getAllDepartments').success(function(data){          
        $scope.departments = data;        
  });
  

  $scope.setPage = function(pageNo) {    
      start_date = $scope.start_date.getFullYear()+'-'+($scope.start_date.getMonth()+1)+'-'+$scope.start_date.getDate();
      end_date = $scope.end_date.getFullYear()+'-'+($scope.end_date.getMonth()+1)+'-'+$scope.end_date.getDate();      
      user_id = $scope.user_id;
      department_id = $scope.department_id;    
      $scope.currentPage = pageNo;  
      params = { 
                curr_page : $scope.currentPage,                
                start_date : start_date,
                end_date : end_date,
                user_id : user_id,                
                department_id : department_id
                };
      showList('officers/searchShifts',params,$http,$scope);          
  }; 


  $scope.download_csv = function() {
      start_date = $scope.start_date.getFullYear()+'-'+($scope.start_date.getMonth()+1)+'-'+$scope.start_date.getDate();
      end_date = $scope.end_date.getFullYear()+'-'+($scope.end_date.getMonth()+1)+'-'+$scope.end_date.getDate();      
      if (typeof($scope.user_id)!='undefined') {
        user_id = $scope.user_id;
      } else {
        user_id = '';
      }
            
      if (typeof($scope.department_id)!='undefined'){
        department_id = $scope.department_id;   
      } else {
        department_id = '';
      }
     
      url = '/ladybird/officers/getShiftsCsv?start_date='+start_date+'&end_date='+end_date+'&user_id='+user_id+'&department_id='+ department_id;   ; 
      document.location.href = url;      
    }

  $scope.submitForm = function(isValid) {        
    if (isValid) {       
      start_date = $scope.start_date.getFullYear()+'-'+($scope.start_date.getMonth()+1)+'-'+$scope.start_date.getDate();
      end_date = $scope.end_date.getFullYear()+'-'+($scope.end_date.getMonth()+1)+'-'+$scope.end_date.getDate();      
      user_id = $scope.user_id;
      department_id = $scope.department_id;  
      
      $scope.currentPage = 1;      
      params = { 
                curr_page : $scope.currentPage,                
                start_date : start_date,
                end_date : end_date,
                user_id : user_id,                
                department_id : department_id
                };
      showList('officers/searchShifts',params,$http,$scope);    


    }

  }


});



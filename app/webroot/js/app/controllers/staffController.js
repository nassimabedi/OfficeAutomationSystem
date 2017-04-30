function getLeaveTime($http,$scope) {
	$http.get('Staffs/getLeaveTime').success(function(data){
		$scope.start_leave_time = data.Settings.leave_time;
	});
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

		//$scope.persianIsOpen = true;
		$scope.persianIsOpenStartDate = true;
		//$scope.gregorianIsOpen = false;
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
		//$log.log('Time changed to: ' + $scope.mytime);
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

	$scope.currentPage = 1;
	params = {
		curr_page : $scope.currentPage,
	};
	showList('Staffs/getShifts',params,$http,$scope);

	$scope.setPage = function(pageNo) {
		$scope.currentPage = pageNo;
		params = { 
			curr_page : $scope.currentPage,
		};
		showList('Staffs/getShifts',params,$http,$scope);
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
				url:'Staffs/shiftDelete',
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
				params: {id : rec_id,}
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

});

app.controller('missionAddCrtl', function ($scope, $http,$location, $timeout,$modal,$q,fileUpload) {
	$scope.message = "";
	displayMissionDate($scope);
	displayMissionTime($scope);
	getAccounts($http,$scope);
	file_name = '';

	$scope.uploadFile = function(){
		var file = $scope.mission_file;
		file_name = $scope.mission_file.name;
		var uploadUrl = "Managers/fileUpload?type=missions";
		fileUpload.uploadFileToUrl(file, uploadUrl);
	};
	
	$scope.submitForm = function(isValid) {
		if (isValid) {
			date = $scope.date.getFullYear()+'-'+($scope.date.getMonth()+1)+'-'+$scope.date.getDate();
			start_time = covertDate($scope.start_date,$scope.start_time);
			end_time = covertDate($scope.end_date,$scope.end_time);
			customer_name = $scope.customer_name;
			purpose = $scope.purpose;
			description = $scope.description;
			mission_type = $scope.mission_type;
			$http({
				method:'post',
				url:'staffs/missionInsert',
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
				params: { date : date,
					customer_name : customer_name,
					mission_type : mission_type,
					purpose : purpose,
					start_time : start_time,
					end_time : end_time,
					description :description,
					file_name :file_name}
				}).success(function(result){
					window.location.href = "Staffs#/missionsManager";
				}
			);
		}
	}
});

app.controller('missionEditCrtl', function ($scope, $http,$location, $timeout,$modal,$routeParams) {
	displayMissionDate($scope);
	displayMissionTime($scope);
	getAccounts($http,$scope);

	$http.get("staffs/getMission?rec_id="+$routeParams.rec_id).success(function(data)
	{      
		$scope.customer_name = data.Missions.customer_name;
		$scope.purpose = data.Missions.purpose;
		$scope.mission_type = data.Missions.type;
		$scope.date = new Date(data.Missions.date);
		$scope.start_date = new Date(data.Missions.start_date);
		$scope.start_time = new Date(data.Missions.start_time.replace(/-/g,"/"));
		$scope.end_date = new Date(data.Missions.end_date);
		$scope.end_time = new Date(data.Missions.end_time.replace(/-/g,"/"));
		$scope.description = data.Missions.description;
		$scope.mission_id = data.Missions.id;

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
			date = $scope.date.getFullYear()+'-'+($scope.date.getMonth()+1)+'-'+$scope.date.getDate()
			mission_id = $scope.mission_id;
			start_time = covertDate($scope.start_date,$scope.start_time);
			end_time = covertDate($scope.end_date,$scope.end_time);
			customer_name = $scope.customer_name;
			purpose = $scope.purpose;
			description = $scope.description;
			mission_type = $scope.mission_type;

			$http({
				method:'post',
				url:'staffs/missionUpdate',
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
				params: { id : mission_id,
					date : date,
					customer_name : customer_name,
					mission_type: mission_type,
					purpose : purpose,
					start_time : start_time,
					end_time : end_time,
					description :description}
				}).success(function(result){
					window.location.href = "Staffs#/missionsManager";
				});
			}
		}
	}
);


app.controller('missionListCrtl', function ($scope, $http,$location, $timeout,$modal) {        

	displayDate($scope);
	displayTime($scope); 
	$scope.currentPage = 1;

	params = { 
		curr_page : $scope.currentPage,
	};
	showList('staffs/getMissions',params,$http,$scope);   

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

		if (typeof($scope.mission_type)!= 'undefined' ) {
			mission_type = $scope.mission_type;
		} else {
			mission_type = '';
		}


		params = {
			curr_page : $scope.currentPage,
			start_date : start_date,
			end_date : end_date,
			mission_type:mission_type
		};

		showList('staffs/getMissions',params,$http,$scope);
	};
	$scope.filter = function() {
		$timeout(function() { 
			$scope.filteredItems = $scope.filtered.length;
		}, 10);
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
				url:'Staffs/missionDelete',        
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
			if (typeof($scope.mission_type)!= 'undefined' ) {
				mission_type = $scope.mission_type;
			} else {
				mission_type = '';
			}


			$scope.currentPage = 1;
			params = {
				curr_page : $scope.currentPage,
				start_date : start_date,
				end_date : end_date,
				mission_type: mission_type
			};
			showList('staffs/getMissions',params,$http,$scope);
		}

	}
});


app.controller('shiftAddCrtl', function ($scope, $http,$location, $timeout,$modal,$q,$filter,fileUpload) {
	//============== Start shift Service =================================
	$scope.services = [];   
	shiftServices($scope);
	$scope.weekend = false;
	$scope.after_shift_date = false;

	//============== End Shift Service =================================
	$scope.getLeaveTime = getLeaveTime($http,$scope);

	$scope.$watch('date',function() {
		if (typeof($scope.date) != "undefined") {
			$scope.delivery_hour_date = $scope.date;
			$scope.exit_hour_date = $scope.date;

			if(typeof $scope.date == 'number')
			{
				var date = new Date($scope.date);
				greDate = toGregorian(date.getFullYear(),date.getMonth() + 1,date.getDate());
			}else{
				var date = $scope.date.split("/");
				greDate = toGregorian(parseInt(date[0]),parseInt(date[1]),parseInt(date[2]));
			}

			var d = new Date(greDate.gy, greDate.gm, greDate.gd);
			d.setDate(d.getDate() + 1); 
			j = toJalaali(d.getFullYear(),d.getMonth(),d.getDate());
			tomorrow = j.jy.toString()+'/'+j.jm.toString()+'/'+j.jd.toString();
			$scope.after_shift_start_date = tomorrow;
			$scope.after_shift_end_date = tomorrow;
			$scope.isDisabled = false;
		}
	});

	$scope.$watch('after_shift_end_time',function() {
		var end_hour = new Date($scope.after_shift_end_time).getHours();
		var end_mins = new Date($scope.after_shift_end_time).getMinutes();      
		if (typeof($scope.start_leave_time) != "undefined") {
			$scope.overtime = diff($scope.start_leave_time,end_hour + ':' + end_mins);        
		}    
	});

	$scope.message = "";
	$scope.exit_hour_time = new Date();
	$scope.delivery_hour_time = new Date();
	$scope.after_shift_start_time = new Date();
	$scope.after_shift_end_time = new Date();  
	shift_file = "";

	$scope.uploadFile = function(){
		var file = $scope.shift_file;
		console.log('file is ' + JSON.stringify(file));   
		console.log($scope.shift_file.name);           
		shift_file = $scope.shift_file.name;
		var uploadUrl = "Staffs/fileUpload?type=shifts";
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
			var date = $scope.date.split("/");
			greDate = toGregorian(parseInt(date[0]),parseInt(date[1]),parseInt(date[2]));
			var d = new Date(greDate.gy, greDate.gm, greDate.gd);
			date = greDate.gy+'-'+greDate.gm+'-'+greDate.gd;
			shift_id = $scope.shift_id;
			//
			exit_hour_date = $scope.exit_hour_date.split("/");
			exit_hour_date = toGregorian(parseInt(exit_hour_date[0]),parseInt(exit_hour_date[1]),parseInt(exit_hour_date[2]));
			exit_hour_date = new Date(exit_hour_date.gy, exit_hour_date.gm, exit_hour_date.gd);
			exit_hour_date = covertDate(exit_hour_date,$scope.exit_hour_time);
			//
			delivery_hour_date = $scope.delivery_hour_date.split("/");
			delivery_hour_date = toGregorian(parseInt(delivery_hour_date[0]),parseInt(delivery_hour_date[1]),parseInt(delivery_hour_date[2]));
			delivery_hour_date = new Date(delivery_hour_date.gy, delivery_hour_date.gm, delivery_hour_date.gd);
			delivery_hour_date = covertDate(delivery_hour_date,$scope.delivery_hour_time);
			//
			after_shift_start_date = $scope.after_shift_start_date.split("/");
			after_shift_start_date = toGregorian(parseInt(after_shift_start_date[0]),parseInt(after_shift_start_date[1]),parseInt(after_shift_start_date[2]));
			after_shift_start_date = new Date(after_shift_start_date.gy, after_shift_start_date.gm, after_shift_start_date.gd);
			after_shift_start_date = covertDate(after_shift_start_date,$scope.after_shift_start_time);
			//
			after_shift_end_date = $scope.after_shift_end_date.split("/");
			after_shift_end_date = toGregorian(parseInt(after_shift_end_date[0]),parseInt(after_shift_end_date[1]),parseInt(after_shift_end_date[2]));
			after_shift_end_date = new Date(after_shift_end_date.gy, after_shift_end_date.gm, after_shift_end_date.gd);
			after_shift_end_date = covertDate(after_shift_end_date,$scope.after_shift_end_time);
			//

			all_calls_num = $scope.all_calls_num;
			successfull_calls_num = $scope.successfull_calls_num;
			unsuccessfull_calls_num = $scope.unsuccessfull_calls_num;
			//
			services = '';
			if($scope.services.length > 0)
			{
				services = [];
				$scope.services.forEach(function(currentService,index){
					//
					if(typeof currentService.start_date!='undefined')
					{
						var d = currentService.start_date.split(/\D/);
						dg 	= toGregorian(parseInt(d[0]),parseInt(d[1]),parseInt(d[2]));
						currentService.start_date = dg.gy+'-'+dg.gm+'-'+dg.gd+' '+d[3]+':'+d[4];
					}
					//
					if(typeof currentService.end_date!='undefined')
					{
						var d = currentService.end_date.split(/\D/);
						dg 	= toGregorian(parseInt(d[0]),parseInt(d[1]),parseInt(d[2]));
						currentService.end_date = dg.gy+'-'+dg.gm+'-'+dg.gd+' '+d[3]+':'+d[4];
					}
					services.push(currentService);
				});
				services = toObject(services);
			}
			//
			
			$http({
				method:'post',        
				url:'staffs/shiftInsert',        
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
				params: { date : date,
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
				window.location.href = "Staffs#/shiftsManager";
			});
		}
	}
});


app.controller('shiftEditCrtl', function ($scope, $http,$location, $timeout,$modal,$routeParams) {
	//displayMissionDate($scope);
	displayMissionTime($scope);
	$scope.exit_hour_time = new Date();
	$scope.delivery_hour_time = new Date();
	$scope.after_shift_start_time = new Date();
	$scope.after_shift_end_time = new Date();  
	$scope.getLeaveTime = getLeaveTime($http,$scope);

	$scope.openPersianExitDate = function($event) {
		$event.preventDefault();
		$event.stopPropagation();
		$scope.persianIsOpenExitDate = true;    
	};
	$scope.openPersianDeliveryDate = function($event) {
		$event.preventDefault();
		$event.stopPropagation();
		$scope.persianIsOpenDeliveryDate = true;    
	};
	$scope.openPersianAfterShiftStart = function($event) {
		$event.preventDefault();
		$event.stopPropagation();
		$scope.persianIsOpenAfterShiftStart = true;    
	};
	$scope.openPersianAfterShiftEnd = function($event) {
		$event.preventDefault();
		$event.stopPropagation();
		$scope.persianIsOpenAfterShiftEnd = true;    
	};

	$scope.try = function($event) {
		$event.preventDefault();
		$event.stopPropagation();
		alert('test');

	};

	$scope.$watch('date',function() {
		if (typeof($scope.date) != "undefined") {
			$scope.delivery_hour_date = $scope.date;
			$scope.exit_hour_date = $scope.date;

			if(typeof $scope.date == 'number')
			{
				var date = new Date($scope.date);
				greDate = toGregorian(date.getFullYear(),date.getMonth() + 1,date.getDate());
			}else{
				var date = $scope.date.split("/");
				greDate = toGregorian(parseInt(date[0]),parseInt(date[1]),parseInt(date[2]));
			}

			var d = new Date(greDate.gy, greDate.gm, greDate.gd);
			d.setDate(d.getDate() + 1); 
			j = toJalaali(d.getFullYear(),d.getMonth(),d.getDate());
			tomorrow = j.jy.toString()+'/'+j.jm.toString()+'/'+j.jd.toString();
			$scope.after_shift_start_date = tomorrow;
			$scope.after_shift_end_date = tomorrow;
			$scope.isDisabled = false;
		}
	});

	$http.get("staffs/getShift?rec_id="+$routeParams.rec_id).success(function(data)
	{      
		$scope.date = new Date(data.Shifts.date).getTime();
		$scope.exit_hour_date = new Date(data.Shifts.exit_hour_date).getTime();
		$scope.exit_hour_time = new Date(data.Shifts.exit_hour_time.replace(/-/g,"/"));
		$scope.delivery_hour_date = new Date(data.Shifts.delivery_hour_date).getTime();
		$scope.delivery_hour_time = new Date(data.Shifts.delivery_hour_time.replace(/-/g,"/"));
		$scope.delivery_hour_date = new Date(data.Shifts.delivery_hour_date).getTime();
		$scope.delivery_hour_time = new Date(data.Shifts.delivery_hour_time.replace(/-/g,"/"));
		$scope.all_calls_num = parseInt(data.Shifts.all_calls_num);
		$scope.successfull_calls_num = parseInt(data.Shifts.successfull_calls_num);
		$scope.unsuccessfull_calls_num = parseInt(data.Shifts.unsuccessfull_calls_num);
		$scope.after_shift_start_date = new Date(data.Shifts.after_shift_start_date).getTime();
		$scope.after_shift_start_time = new Date(data.Shifts.after_shift_start_time.replace(/-/g,"/"));
		$scope.after_shift_end_date = new Date(data.Shifts.after_shift_end_date).getTime();
		$scope.after_shift_end_time = new Date(data.Shifts.after_shift_end_time.replace(/-/g,"/"));
		$scope.desc = data.Shifts.description;
		$scope.shift_id = data.Shifts.id;
		$scope.overtime = data.Shifts.overtime;      

		data.shift_services.forEach(function(currentValue,index,arr){
			data.shift_services[index].start_date 	= new Date(currentValue.start_date).getTime();
			data.shift_services[index].end_date 	= new Date(currentValue.end_date).getTime();
		});

		if ($scope.overtime == '00:00:00') {        
			$scope.weekend = true;
			$scope.after_shift_date = true;
		} else {        
			$scope.weekend = false;
			$scope.after_shift_date = false;  
		}

		if (data.Shifts.file_name) {
			shift_file = $scope.shift_file_dl = data.Shifts.file_name;
		} else {
			shift_file = '';
		}

		$scope.services = data.shift_services;
		shiftServices($scope);
	});

	$scope.$watch('after_shift_end_time',function() {      
		var end_hour = new Date($scope.after_shift_end_time).getHours();
		var end_mins = new Date($scope.after_shift_end_time).getMinutes();      
		if (typeof($scope.start_leave_time) != "undefined") {        
			$scope.overtime = diff($scope.start_leave_time,end_hour + ':' + end_mins);        
		}
	});

	$scope.download_file = function () {
		url = '/ladybird/files/shifts/'+$scope.shift_file_dl; 
		document.location.href = url;      
	}    

	$scope.uploadFile = function(){
		var file = $scope.shift_file;
		shift_file = $scope.shift_file.name;
		var uploadUrl = "Staffs/fileUpload?type=shifts";
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
			var date = $scope.date.split("/");
			greDate = toGregorian(parseInt(date[0]),parseInt(date[1]),parseInt(date[2]));
			var d = new Date(greDate.gy, greDate.gm, greDate.gd);
			date = greDate.gy+'-'+greDate.gm+'-'+greDate.gd;
			shift_id = $scope.shift_id;
			//
			exit_hour_date = $scope.exit_hour_date.split("/");
			exit_hour_date = toGregorian(parseInt(exit_hour_date[0]),parseInt(exit_hour_date[1]),parseInt(exit_hour_date[2]));
			exit_hour_date = new Date(exit_hour_date.gy, exit_hour_date.gm, exit_hour_date.gd);
			exit_hour_date = covertDate(exit_hour_date,$scope.exit_hour_time);
			//
			delivery_hour_date = $scope.delivery_hour_date.split("/");
			delivery_hour_date = toGregorian(parseInt(delivery_hour_date[0]),parseInt(delivery_hour_date[1]),parseInt(delivery_hour_date[2]));
			delivery_hour_date = new Date(delivery_hour_date.gy, delivery_hour_date.gm, delivery_hour_date.gd);
			delivery_hour_date = covertDate(delivery_hour_date,$scope.delivery_hour_time);
			//
			after_shift_start_date = $scope.after_shift_start_date.split("/");
			after_shift_start_date = toGregorian(parseInt(after_shift_start_date[0]),parseInt(after_shift_start_date[1]),parseInt(after_shift_start_date[2]));
			after_shift_start_date = new Date(after_shift_start_date.gy, after_shift_start_date.gm, after_shift_start_date.gd);
			after_shift_start_date = covertDate(after_shift_start_date,$scope.after_shift_start_time);
			//
			after_shift_end_date = $scope.after_shift_end_date.split("/");
			after_shift_end_date = toGregorian(parseInt(after_shift_end_date[0]),parseInt(after_shift_end_date[1]),parseInt(after_shift_end_date[2]));
			after_shift_end_date = new Date(after_shift_end_date.gy, after_shift_end_date.gm, after_shift_end_date.gd);
			after_shift_end_date = covertDate(after_shift_end_date,$scope.after_shift_end_time);
			//
			all_calls_num = $scope.all_calls_num;
			successfull_calls_num = $scope.successfull_calls_num;
			unsuccessfull_calls_num = $scope.unsuccessfull_calls_num;
			overtime = $scope.overtime;
			approved_overtime = $scope.approved_overtime;
			approved_resttime = $scope.approved_resttime;

			services = '';
			if($scope.services.length > 0)
			{
				services = [];
				$scope.services.forEach(function(currentService,index){
					//
					if(typeof currentService.start_date!='undefined')
					{
						var d = currentService.start_date.split(/\D/);
						dg 	= toGregorian(parseInt(d[0]),parseInt(d[1]),parseInt(d[2]));
						currentService.start_date = dg.gy+'-'+dg.gm+'-'+dg.gd+' '+d[3]+':'+d[4];
					}
					//
					if(typeof currentService.end_date!='undefined')
					{
						var d = currentService.end_date.split(/\D/);
						dg 	= toGregorian(parseInt(d[0]),parseInt(d[1]),parseInt(d[2]));
						currentService.end_date = dg.gy+'-'+dg.gm+'-'+dg.gd+' '+d[3]+':'+d[4];
					}
					services.push(currentService);
				});
				services = toObject(services);
			}

			$http({
				method:'post',        
				url:'staffs/shiftUpdate',        
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
				params: { id : shift_id,                   
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
					approved_overtime : approved_overtime,
					approved_resttime : approved_resttime,
					services : services,
					file_name : shift_file
				}
			}).success(function(result){            
				window.location.href = "Staffs#/shiftsManager";
			});
		}
	}
});


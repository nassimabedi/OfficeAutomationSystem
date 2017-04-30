app.controller("MainController", function($scope){

	
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
    $scope.gregorianIsOpen = false;
  };
  $scope.openGregorian = function($event) {
    $event.preventDefault();
    $event.stopPropagation();

    $scope.gregorianIsOpen = true;
    $scope.persianIsOpen = false;
  };

  $scope.dateOptions = {
    formatYear: 'yy',
    startingDay: 6
  };

  $scope.initDate = new Date('2016-15-20');
  $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
  $scope.format = $scope.formats[0];

//=========================time picker ===================================
$scope.mytime = new Date();

  $scope.hstep = 1;
  $scope.mstep = 15;

  $scope.options = {
    hstep: [1, 2, 3],
    mstep: [1, 5, 10, 15, 25, 30]
  };

  $scope.ismeridian = false;
  /*$scope.toggleMode = function() {
    $scope.ismeridian = ! $scope.ismeridian;
  };*/

  $scope.update = function() {
    var d = new Date();
    d.setHours( 14 );
    d.setMinutes( 0 );
    $scope.mytime = d;
  };

  $scope.changed = function () {
    $log.log('Time changed to: ' + $scope.mytime);
  };

  $scope.clear = function() {
    $scope.mytime = null;
  };






  });



app.directive('datetimez', function() {
  return {
      restrict: 'A',
      require : 'ngModel',
      link: function(scope, element, attrs, ngModelCtrl) {
        element.datetimepicker({           
         language: 'en',
         pickDate: false,          
        }).on('changeDate', function(e) {
          ngModelCtrl.$setViewValue(e.date);
          scope.$apply();
        });
      }
  };
});

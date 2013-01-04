'use strict';

//listApp.controller('listCtrl', function listCtrl($scope, monitorList, monitorTotal) {
listApp.controller('listCtrl', function listCtrl($scope, monitorList, monitorFilter, monitorGAservice) {
			$scope.monitor			= {};
		
			$scope.list 			= monitorList.query();
			//$scope.total			= monitorTotal.query();
			//$scope.date01 			= new Date("06/21/2012");
			//$scope.date02 			= "\/Date(1339453260000-0500)\/";
			
			//console.log($scope.list);
			$scope.filter			= monitorFilter.query();
			$scope.date01 = null;
			$scope.date02 = null;
			
			/*$scope.onSubmitted = function() {
				var start_date = $scope.monitor.date01;
				var end_date = $scope.monitor.date01;
				/*var filters = {
					start_date; $scope.monitor.date01,
					end_date: $scope.monitor.date01
				};*/
				
				/*var api = new GAservice({start_date: start_date, end_date: end_date});
				api.$send(function() { 
				api.$index();	
				});
			}*/
			
			//listCtrl.$inject = ['$scope','monitorList','monitorFilter','monitorGAservice'];
			listCtrl.$inject = ['$scope'];
			$scope.proceed = function($event) {
				if(evolveJS.validate($j(evolveJS.currentForm($event.target)))) {
					monitorGAservice.save(
						{data: $scope.monitor},
						function(response) {
							//console.log(response);
							//$scope.list 			= monitorListUp.query();
							//$scope.$apply();
							//$scope.$digest();
							//window.location 	= 'index.php?option=com_emc_monitor&task=jsonlistup';
						}
					);
				}
				return false;
			}
			
			
}

);

/*
listApp.controller('filterCtrl', function filterCtrl($scope, monitorFilter) {
	$scope.filter			= monitorFilter.query();
	$scope.date01 = null;
	$scope.date02 = null;
	//console.log($scope.filter);
	return false;
});*/


/*listApp.controller('totalsCtrl', function totalsCtrl($scope) {
	//$scope.totalsEvents = ;
	$scope.timeOfDay = 'morning';
	//console.log($scope);
});*/

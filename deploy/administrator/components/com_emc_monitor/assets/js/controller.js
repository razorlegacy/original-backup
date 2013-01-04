'use strict';

/**
* List Controller
**/
var listCtrl = function($scope, monitorList, monitorAction) {
	$scope.monitor		= {};
	$scope.$monitor_totals	= {};
	
	$scope.list 		= monitorList.loadList(function(response) {
		$scope.monitor_totals = {'totalEvents':response[0].totalEvents,'uniqueEvents':response[0].uniqueEvents};
	});
	
	$scope.title = 'Top Events';
	$scope.hide = false;
			
	$scope.filter		= monitorList.loadFilter();
	$scope.date01 		= null;
	$scope.date02 		= null;	
	
	listCtrl.$inject = ['$scope'];
	
	$scope.proceed = function($event) {
		if(evolveJS.validate($j(evolveJS.currentForm($event.target)))) {
			monitorList.loadDataApi(
				{data: $scope.monitor},
				function(response) {
					$scope.list = monitorList.loadList();
					//window.location 	= 'index.php?option=com_emc_origin&task='+response['task']+'&id='+response['oid'];
				}
			);
		}
		return false;
	}
	
	$scope.monitorController = function(category, start_date, end_date) {
		var actions = monitorAction.loadActions(
		{
			category: category,
			start_date: start_date,
			end_date: end_date
		}, function(monitor) {
			$scope.monitor_category = monitor[0].category;
			$scope.title = 'Event Category: '+$scope.monitor_category;
			$scope.monitor_totals = monitor[1];
			$scope.actions = monitor[2];
			$scope.hide = true;
			//console.log($scope.monitor_category);
			//console.log($scope.monitor_totals.totalEvents);
			//window.location 	= 'index.php?option=com_emc_monitor&task=getCategoryData';
		});
		return false;
	}
		
}

/**
* Action Controller
**/

var actionCtrl = function($scope, monitorAction) {
	$scope.monitor		= {};
	$scope.monitor_totals ={};
	//console.log($scope);
	//$scope.actions 			= listCtrl.monitor_totals;
	$scope.totals = $scope.monitor_totals;
	console.log($scope.totals );
	
}


$j(function() {
	
});
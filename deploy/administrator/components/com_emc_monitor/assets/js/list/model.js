'use strict';

	angular.module('monitorList', ['ngResource']).
		factory('monitorList', function($resource) {
			return $resource('/administrator/index.php?option=com_emc_monitor&task=jsonlist', {}, {});
		});
	
	angular.module('monitorFilter', ['ngResource']).
		factory('monitorFilter', function($resource) {
			return $resource('/administrator/index.php?option=com_emc_monitor&task=jsonfilter', {}, {});
		});
		/*
	angular.module('monitorListUp', ['ngResource']).
		factory('monitorList', function($resource) {
			return $resource('/administrator/index.php?option=com_emc_monitor&task=jsonlistup', {}, {});
		});
	*/
	
	/*angular.module('GAservice', ['ngResource']).
		factory('GAservice', function($resource) {
			//return $resource('/administrator/components/com_emc_monitor/classes/ga_api.php', {
			return $resource('index.php', {
							'option': 'com_emc_monitor',
							'task': 'getdata'
							}, {
							'send': { method: 'POST' },
							'index': { method: 'GET', isArray: true },
						  });
		});*/
	
	angular.module('monitorGAservice', []).
		factory('monitorGAservice', function($resource) {
			return $resource('index.php', {'option': 'com_emc_monitor', 'task': 'getdata'}, {});
		});
		
	//angular.module('monitorDate', ['ui.directives'])
	//	.controller('Ctrl', ['$scope', function($scope) {
    //}]);
	
	//angular.module('GAService',['ngResource']).
	
		/*factory('OpenApi', function($resource) {
			var openApi = $resource(
						'/api/:controller/:id',
						[],
						{
							postLogOn: { method: 'POST', params: { controller: 'Account' } },
							postCustomer: { method: 'POST', params: { controller: 'Employee' } }
						}
						);
			return openApi;
		})*/
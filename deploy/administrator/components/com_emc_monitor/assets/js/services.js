'use strict';

angular.module('monitorApp.services', ['ngResource'])
	.factory('monitorList', function($resource) {
		return $resource('index.php', {option: 'com_emc_monitor'}, {
			'loadList': {method: 'GET', params: {task: 'jsonlist'}, isArray: true},
			'loadFilter': {method: 'GET', params: {task: 'jsonfilter'}, isArray: true},
			'loadDataApi': {method: 'POST', params: {task: 'getdata'}}
		});
	})
	.factory('monitorAction', function($resource) {
		return $resource('index.php', {option: 'com_emc_monitor'}, {
			'loadActions': {method: 'GET', params: {task: 'jsonaction'}, isArray: true}
			//'getActions': {return actions;}
		});
	});
	/*
	.factory('Workspace', function($resource) {
		return $resource('index.php', {option: 'com_emc_origin'}, {
			'loadAssets': {method: 'GET', params: {task: 'jsonAssets'}},
			'loadOrigin': {method: 'GET', params: {task: 'jsonOrigin'}},
			'saveContent': {method: 'POST', params: {task: 'saveContent'}}
		});
	});*/
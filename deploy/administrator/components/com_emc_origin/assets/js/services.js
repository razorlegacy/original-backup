'use strict';

angular.module('originApp.services', ['ngResource'])
	.factory('loadJSON', function($resource) {
		return $resource('/:administrator/:components/com_emc_origin/assets/data/:filename', {}, {
			'components': {method: 'GET', params: {administrator: 'administrator', components: 'components', filename: 'components.json'}},
			'types': {method: 'GET', params: {administrator: 'components', filename: 'originTypes.json'}, isArray: true}
		});
	})
	.factory('List', function($resource) {
		return $resource('index.php', {option: 'com_emc_origin'}, {
			'create': {method: 'POST', params: {task: 'create'}},
			'load': {method: 'GET', params: {task: 'jsonList'}, isArray: true}
		});
	})
	.factory('Workspace', function($http) {
		var Workspace = {
			get: function(location) {
				var promise = $http.get(location).then(function(response) {
					return response.data;
				});
				return promise;
			},
			post: function(task, data) {
				var promise = $http.post('index.php?option=com_emc_origin&task='+task, data).then(function(response) {
					return response.data;
				});
				return promise;
			}
		};
		
		return Workspace;
/*
		return $resource('index.php', {option: 'com_emc_origin'}, {
			'createContent': {method: 'POST', params: {task: 'createContent'}},
			'deleteContent': {method: 'POST', params: {task: 'deleteContent'}},
			'loadAssets': {method: 'GET', params: {task: 'jsonAssets'}},
			'loadOrigin': {method: 'GET', params: {task: 'jsonOrigin'}},
			'loadSpringboard': {method: 'GET', params: {task: 'jsonSpringboard'}},
			'saveContentConfig': {method: 'POST', params: {task: 'saveContentConfig'}},
			'saveContent': {method: 'POST', params: {task: 'saveContent'}},
			'saveOrder': {method: 'POST', params: {task: 'saveOrder'}},
			'saveOrigin': {method: 'POST', params: {task: 'saveOrigin'}}
		});
*/
	});
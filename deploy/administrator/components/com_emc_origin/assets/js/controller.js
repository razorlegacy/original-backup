'use strict';

var origin_id		= $j('#origin_id').val(),
	origin_assets	= 'http://'+document.domain+'/assets/components/com_emc_origin/'+origin_id,
	duration		= 200;
	
	
/**
* List Controller
**/
var listCtrl = function($scope, $filter, loadJSON, List) {
	$scope.origin		= {};
	$scope.listState	= 'display all';
	
	//Assign tooltip
	$j('#create').qtip({
		content: {
			text: $j('#create-modal')
		},
		hide: false,
		position: {
			my: 'center',
			at: 'center',
			target: $j(window)
		},
		show: {
			event: 'click',
			modal: true,
			solo: true
		},
		style: {
			classes: 'originUI-bg',
			def: false
		}
	});
	
	$scope.toggleShown = function() {
		switch($scope.listState) {
			case 'display all':
				$scope.listShown	= $scope.list;
				$scope.listState	= 'display active';
				break;
			case 'display active':
				$scope.listShown	= $scope.listActive;
				$scope.listState	= 'display all';
				break;
		}
	}
	
	$scope.list = List.load(function() {
		$scope.listActive	= $filter('filter')($scope.list, '!inactive');
		$scope.listShown	= $scope.listActive;
	});

	$scope.types = loadJSON.types(function() {
		$scope.origin.type 	= $scope.types[0];
	});
	
	$scope.cancel = function() {
		$scope.origin		= {};
		$scope.origin.type 	= $scope.types[0];
		$j('#create').qtip('hide');
		return false;
	}
	
	$scope.proceed = function($event) {
		if(evolveJS.validate($j(evolveJS.currentForm($event.target)))) {
			List.create(
				{data: $scope.origin},
				function(response) {
					window.location 	= 'index.php?option=com_emc_origin&task='+response['task']+'&id='+response['oid'];
				}
			);
		}
		return false;
	}
		
}

/**
* Workspace Controller
**/

angular.module('workspaceApp', ['originApp.services', 'originApp.directives', 'originApp.filters', 'ui']);

var workspaceCtrl = function($scope, $filter, loadJSON, Workspace) {
	//Global Origin object
	$scope.originObj = {};
	$scope.originEditor = {};
	$scope.springboard = {};
	
	//Global workspace settings
	$scope.originWorkspace	= {
		'id':		origin_id,
		'panel':	'layers',
		'panelSlide':'close',
		'panelSlideContent': 'components',
		'schedule':	'0',
		'settings':	'close',
		'state':	'initial',
		'view':		'desktop',
		'state_view':'initial_desktop'
	};
	
	//Load JSON feeds
	Workspace.loadOrigin({id: origin_id}, function(data) {
		$scope.originObj.content	= data.content;
		$scope.originObj.config		= data.config;
		$scope.originObj.assets		= Workspace.loadAssets({id: origin_id});
		$scope.originObj.components	= loadJSON.components();
		$scope.originObj.current 	= $scope.originObj.content[$scope.originWorkspace.schedule][$scope.originWorkspace.state+'_'+$scope.originWorkspace.view];
		//$scope.originObj.springboard= Workspace.loadSpringboard();
		document.title				= 'Origin | '+$scope.originObj.config.name;
	});
	
	$scope.workspaceUI = function(type, value) {
		$scope.originWorkspace[type]		= value;
		$scope.originWorkspace.state_view	= $scope.originWorkspace.state+'_'+$scope.originWorkspace.view;
		$scope.originObj.current 	 		= $scope.originObj.content[$scope.originWorkspace.schedule][$scope.originWorkspace.state+'_'+$scope.originWorkspace.view];
		
		$scope.originWorkspace.settings = 'open';
		$scope.settings('close');
		//$scope.panelAdd('settings');
	}
	
	$scope.originServices = function(type, data) {
		switch(type) {
			case 'background_preview':
				$scope.background 		= data.name;
				//$scope.originObj.config.config[$scope.originWorkspace.state_view]	= data.name;
/*
				$scope.$watch('originWorkspace.panelSlide', function() {
					console.log('here');
				}, true);
*/
				break;
			case 'background_save':
				$scope.originObj.config.config[$scope.originWorkspace.state_view] = $scope.background;
				
				Workspace.saveOrigin({data: $scope.originObj.config}, function(data) {
					azure._originNotification('Background saved');
					refreshOrigin(data);
				});
				break;
			case 'content_create':
				break;
			case 'content':
				Workspace.createContent({data: data}, function(data) {
					azure._originNotification('Content added to workspace');
					refreshOrigin(data);
				});
				break;
			case 'content_config':
				Workspace.saveContentConfig({data: data}, function(data) {
					azure._originNotification('Workspace updated');
					refreshOrigin(data);
				});
				break;
			case 'delete':
				data.oid	= origin_id;
				Workspace.deleteContent({data: data}, function(data) {
					azure._originNotification('Item has been deleted', 'alert');
					$scope.panelSlide('close');
					refreshOrigin(data);
				});
				break;
			case 'order':
				Workspace.saveOrder({data: data}, function(data) {
					azure._originNotification('Item order has been updated');
					refreshOrigin(data);
				});
				break;
			case 'save':
				console.log($scope.originEditor);
/*
				var data = {
					'id':		$scope.originEditor.id,
					'oid':		origin_id,
					'config':	$scope.originEditor.content_config
				};
				Workspace.saveContentConfig({data: data}, function(data) {
					azure._originNotification('Content saved');
					refreshOrigin(data);
					$scope.panelSlide('close');
				});
*/
		}
	}
	
	function refreshOrigin(data) {
		$scope.originObj.content	= data.content;
		$scope.originObj.config		= data.config;
		$scope.originObj.current 	= $scope.originObj.content[$scope.originWorkspace.schedule][$scope.originWorkspace.state+'_'+$scope.originWorkspace.view];
		
		//if($scope.originWorkspace.panelSlide === 'open') ;
	}
	
	$scope.panelSlide = function(action) {
		switch(action) {
			case 'close':
				$j('#panel-slide').animate({left: '0'}, duration);
				$scope.originWorkspace.panelSlide 	= 'close';
				$scope.originEditor					= {};
				break;
			case 'open':
				$j('#panel-slide').animate({left: '300'}, duration);
				$scope.originWorkspace.panelSlide 	= 'open';
				$scope.settings('close');
				break;
		}
	}
	
	$scope.settings = function(action) {
		switch(action) {
			case 'close':
				$j('#panel').animate({left: '75'}, duration);
				$scope.originWorkspace.settings = 'close';
				break;
			case 'open':
				$j('#panel').animate({left: '300'}, duration);
				$scope.originWorkspace.settings	= 'open';
				$scope.panelSlide('close');
				break;
		}
		//$scope.panelSlide('close');
	}
	
	$scope.panelSlideBackground = function() {
		if($scope.originWorkspace.panelSlide === 'close') $scope.panelSlide('open');
		$scope.originWorkspace.panelSlideContent	= 'background';
		$scope.editor								= '';
	}
	
	$scope.panelSlideComponents = function() {
		if($scope.originWorkspace.panelSlide === 'close') $scope.panelSlide('open');
		$scope.originWorkspace.panelSlideContent	= 'components';
		$scope.editor								= '';
	}
	
	$scope.panelSlideEditor = function(type, model) {
		if($scope.originWorkspace.panelSlide === 'close') $scope.panelSlide('open');
		
		$scope.originWorkspace.panelSlideContent	= 'editor';
		$scope.editor								= '/administrator/components/com_emc_origin/assets/templates/'+type+'.php';
		$scope.originEditor							= (!model)? {empty: true}: model;
		
		$scope.originWorkspace.panelEditor			= type;
		
		//Special conditions for certain templates
		switch(type) {
			case 'springboard':
				if($j.isEmptyObject($scope.springboard)) {
					Workspace.loadSpringboard(function(data) {
						//console.log(data);
						$scope.springboard 		= data;
					});	
				}
				break;
		}
/*
		$j.grep($scope.originObj.current, function(element, index) {
			if(element.id === model.id) {
				console.log(element);
				$scope.originEditor		= element;
			}
		});
*/
	}
	
/*
	$scope.panelSlidePreview = function(data) {
		if($scope.originWorkspace.panelSlide === 'close') $scope.panelSlide('open');
		
		//console.log(data);
		$scope.originWorkspace.panelSlideContent	= 'preview';
		$scope.originEditor							= data;
		//console.log(data);
		//console.log($scope.originEditor);
		
		//		$scope.originWorkspace
	}
*/
	
	$scope.panelSlideScheduler = function(data) {
		if($scope.originWorkspace.panelSlide === 'close') $scope.panelSlide('open');
		$scope.originWorkspace.panelSlideContent	= 'scheduler';
	}
	
	$scope.layerZindex = function(layer) {
		return layer.content_config.zIndex;
	}
	
/*
	$scope.panelAdd = function(type, data) {
		switch(type) {
			case 'close':
				$scope.originWorkspace.settings = 'open';
				add.close();
				$scope.panelAdd('settings');
				break;
			case 'components':
				$scope.originWorkspace.panelAdd = 'components';
				$scope.originWorkspace.settings = 'open';
				$scope.panelAdd('settings');
				add.open();
				break;
			case 'edit':
				break;
			case 'editor':
				$scope.originWorkspace.panelAdd	= 'editor';
				$scope.editor					= '/administrator/components/com_emc_origin/assets/templates/'+data+'.php';
				
				console.log($scope.originObj.current);
				//$scope.originObj.editor	= '';
				add.open();
				break;
			 case 'settings':
			 	$scope.originWorkspace.settings	= ($scope.originWorkspace.settings === 'close')? 'open': 'close';
			 	add.settings($scope.originWorkspace.settings);
			 	add.close();
			 	break;
		}
	}
*/
	
	
	
	
	$j('#fileupload').fileupload({
		dataType: 'json',
		dropZone: $j('#panel, #panel-slide'),
		url: '/libraries/evolve/classes/originFileUploader.php',
		add: function(e, data) {
			data.submit();
		},
		done: function(e, data) {
			//$scope.uiChange('panel', 'assets');
			$scope.originObj.assets		= Workspace.loadAssets({id: origin_id});
			//$scope.assets = Workspace.loadAssets({id: origin_id});
		}
	});
	
	$j(document).bind('drop dragover', function (e) {
    	e.preventDefault();
    });
}
/*

var slide = (function() {
	var duration	= 200;
	
	function slideOpen() {
		settingsClose();
		$j('#panel-slide').animate({left: '300'}, duration);
	}
	
	function slideClose() {
		$j('#panel-slide').animate({left: '0'}, duration, function() {
			//$j('#workspaceCtrl').scope().originUI.panelAdd	= 'components';
		});
	}
	
	function settingsOpen() {
		$j('#panel').animate({left: '300'}, duration, function() {
			
		});
	}
	
	function settingsClose() {
		$j('#panel').animate({left: '75'}, duration, function() {
			
		});
	}

	return {
		open: function() {
			slideOpen();
		},
		close: function() {
			slideClose();
		},
		settings: function(type) {
			switch(type) {
				case 'close':
					settingsClose();
					break;
				case 'open':
					settingsOpen();
					break;
			}
		}
	}
})();
*/
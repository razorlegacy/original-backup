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
	
	//Load static component feed
	Workspace.get('/administrator/components/com_emc_origin/assets/data/components.json').then(function(data) {
		$scope.originObj.components = data;
		
		//Load assets
		Workspace.get('index.php?option=com_emc_origin&task=jsonAssets&id='+origin_id).then(function(data) {
			$scope.originObj.assets	= data;
			
			//LOad Origin data
			Workspace.get('index.php?option=com_emc_origin&task=jsonOrigin&id='+origin_id).then(function(data) {
				/*
$scope.originObj.content	= data.content;
				$scope.originObj.config		= data.config;
				
				$scope.originObj.current 	= $scope.originObj.content[$scope.originWorkspace.schedule][$scope.originWorkspace.state+'_'+$scope.originWorkspace.view];
*/
				refreshOrigin(data);
				document.title				= 'Origin | '+$scope.originObj.config.name;
			});
		});
	});
		
/*
		$scope.originObj.content	= data.content;
		$scope.originObj.config		= data.config;
		$scope.originObj.assets		= Workspace.loadAssets({id: origin_id});
		$scope.originObj.components	= loadJSON.components();
		$scope.originObj.current 	= $scope.originObj.content[$scope.originWorkspace.schedule][$scope.originWorkspace.state+'_'+$scope.originWorkspace.view];
		//$scope.originObj.springboard= Workspace.loadSpringboard();
		document.title				= 'Origin | '+$scope.originObj.config.name;
		
		console.log($scope.originObj.components);
*/
	
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
				
				Workspace.post('saveOrigin', $scope.originObj.config).then(function(data) {
					$j('html, body').animate({scrollTop: 0}, 'fast', function() {
						azure._originNotification('Background saved');
						refreshOrigin(data);
					});
				});
				break;
			//case 'content_create':
			//	break;
			case 'content_config':
				Workspace.post('saveContentConfig', data).then(function(data) {
					azure._originNotification('Workspace updated');
					refreshOrigin(data);
				});
				break;
			case 'delete':
				data.oid	= origin_id;
				Workspace.post('deleteContent', data).then(function(data) {
					azure._originNotification('Item has been deleted', 'alert');
					$scope.panelSlide('close');
					refreshOrigin(data);
				});
				break;
			case 'droppable':
				Workspace.post('createContent', data).then(function(data) {
					azure._originNotification('Content added to workspace');
					refreshOrigin(data);
				});
				break;
			case 'order':
				Workspace.post('saveOrder', data).then(function(data) {
					azure._originNotification('Item order has been updated');
					refreshOrigin(data);
				});
				break;
			case 'save':
				var data = {
					'content_config':	$scope.originEditor.content_config,
					'content_data':		$scope.originEditor.content_data,
					'content_render':	$scope.originEditor.content_render,
					'id':				$scope.originEditor.id,
					'oid':				origin_id,
					'sid':				$scope.originObj.content[$scope.originWorkspace.schedule].id,
					'state':			$scope.originWorkspace.state_view
				};
				
				//If there's an content id, update
				if(data.id) {
					Workspace.post('saveContent', data).then(function(data) {
						$scope.panelSlide('close');
						$j('html, body').animate({scrollTop: 0}, 'fast').promise().done(function() {
							azure._originNotification('Content added to workspace');
							refreshOrigin(data);
						});
					});
				} else {	
					Workspace.post('createContent', data).then(function(data) {
						$scope.panelSlide('close');
						azure._originNotification('Content added to workspace');
						refreshOrigin(data);
					});
				}
				break;
		}
	}
	
	function refreshOrigin(data) {
	
		if(!$scope.$$phase) {
			$scope.$apply(function() {
				$scope.originObj.content	= data.content;
				$scope.originObj.config		= data.config;
				$scope.originObj.current 	= $scope.originObj.content[$scope.originWorkspace.schedule][$scope.originWorkspace.state+'_'+$scope.originWorkspace.view];
	        });	
		} else {
			//NOT SURE.... FIND A BETTER WAY!
			$scope.originObj.content	= data.content;
			$scope.originObj.config		= data.config;
			$scope.originObj.current 	= $scope.originObj.content[$scope.originWorkspace.schedule][$scope.originWorkspace.state+'_'+$scope.originWorkspace.view];
		}
	}
	
	$scope.panelSlide = function(action) {
		switch(action) {
			case 'close':
				$j('#panel-slide').animate({left: '0'}, duration);
				$scope.originWorkspace.panelSlide 	= 'close';
				$scope.originEditor					= {};
				
				if($scope.originObj.reset) {
					$scope.originObj.reset = '';
				} else {
					$scope.originObj.reset = true;
				}
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
		$scope.editor								= '';
	
		if($scope.originWorkspace.panelSlide === 'close') $scope.panelSlide('open');
		
		$scope.originWorkspace.panelSlideContent	= 'editor';
		$scope.editor								= '/administrator/components/com_emc_origin/assets/templates/'+type+'.php';
		//$scope.originEditor							= (!model)? {empty: true, content: {}}: angular.copy(model);
		
		var zIndexSelect			= $j('#layers .layer'),
			zIndexArray				= [];			
		for(var i=0; typeof(zIndexSelect[i]) != 'undefined'; zIndexArray.push(zIndexSelect[i++].getAttribute('data-zindex')));
		
		if(!model) {
			$scope.originEditor = {
				empty: true, //is this needed?
				content_data: {
					'type': type
				},
				content_config: {
					'left': '0px',
					'top':	'0px',
					'zIndex':(Math.max.apply(Math, zIndexArray) + 1).toString()
				}
			}
		} else {
			$scope.originEditor	= angular.copy(model);
		}

		$scope.originWorkspace.panelEditor			= type;
		
		//Special conditions for certain templates
		switch(type) {
			case 'springboard':
				if($j.isEmptyObject($scope.springboard)) {
					//Workspace.loadSpringboard(function(data) {
					//'loadSpringboard': {method: 'GET', params: {task: 'jsonSpringboard'}},
					Workspace.get('index.php?option=com_emc_origin&task=jsonSpringboard').then(function(data) {
						//console.log(data);
						$scope.springboard 		= data;
					});	
				}
				break;
		}
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
			$scope.originObj.assets		= Workspace.get('index.php?option=com_emc_origin&task=jsonAssets&id='+origin_id);
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
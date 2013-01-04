'use strict';

var origin_id		= $j('#origin_id').val(),
	origin_assets	= 'http://'+document.domain+'/assets/components/com_emc_origin/'+origin_id;
	
	
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

angular.module('workspaceApp', ['originApp.services', 'originApp.directives']);

var workspaceCtrl = function($scope, $filter, loadJSON, Workspace) {
	$scope.originConfig		= {};
	$scope.originContent 	= {};
	$scope.asset			= {};
	$scope.id				= origin_id;
	$scope.assets 			= Workspace.loadAssets({id: origin_id});
	$scope.components 		= loadJSON.components();
	$scope.originEditor		= {};
	
	$scope.originUI	= {
		'addShown':	false,
		'editor':	'',
		'panel':	'layers',
		'panelAdd':	'components',
		'schedule': '0',
		'state': 	'initial',
		'workspace':'desktop'
	};
	
	$scope.originObj = {
		'oid':		origin_id,
		'sid':		'',
		'zIndex':	'',
		'state': 	''
	}
	
	$scope.originController	= function(type) {
		switch(type) {
			case 'load':
				Workspace.loadOrigin({id: origin_id}, function(origin) {
					$scope.originConfig		= origin.config;
					$scope.originContent	= origin.content;
					$scope.uiChange();
				});
				break;
		}
	}
	
	
	$scope.originSave = function(type, data) {
		switch(type) {
			case 'content_create':
				Workspace.createContent({data: data}, function(response) {
					//Fire notification
					//Add to workspace
					$scope.originController('load');
				});
				break;
			case 'content_config':
				Workspace.saveConfig({data: data}, function(response) {
					//Fire notification
				});
				break;
			case 'content_data':
				//Workspace.saveContent({data: $scope.originEditor}, function(response) {});
				add.close();
				break;
		}
	}
	
	//Workspace view change (desktop, tablet, mobile or schedules or panels, etc)
	$scope.uiChange = function(type, value) {
		$scope.originUI[type]	= value;
		$scope.state_content	= $scope.originUI.state+'_'+$scope.originUI.workspace;
		$scope.layers			= ($scope.originContent[$scope.originUI.schedule][$scope.state_content] != null)?$scope.originContent[$scope.originUI.schedule][$scope.state_content]: {};
		
		//Update OriginObj
		$scope.originObj.sid	= $scope.originContent[$scope.originUI.schedule].id;
		$scope.originObj.zIndex = ($scope.layers.length >0)? $scope.layers[0].content_config.zIndex: 1;
	}
	
	$scope.addPanel = function(panel, editor) {
		switch(panel) {
			case 'background':
				$scope.originUI.editor		= 'background';
				$scope.originUI.panelAdd	= 'editor';
				$scope.editor				= '/administrator/components/com_emc_origin/assets/templates/background.html';
				add.open();
				break;
			case 'cancel':
				$scope.originUI.addShown = false;
				add.close();
				break;
			case 'components':
				$scope.originUI.addShown = true;
				$scope.originUI.panelAdd = 'components';
				add.open();
				break;
			case 'editor':
				$scope.originUI.addShown	= true;
				$scope.originUI.panelAdd	= 'editor';
				$scope.originUI.editor		= editor;
				$scope.originEditor			= {};
				$scope.editor				= '/administrator/components/com_emc_origin/assets/templates/'+$scope.originUI.editor+'.html';
				break;
			default:
				$scope.originUI.addShown 	= true;
				$scope.originUI.panelAdd 	= 'editor';
				$scope.content				= $scope.originContent[$scope.originUI.schedule][$scope.originUI.state+'_'+$scope.originUI.workspace][panel];
				$scope.originEditor.content = $scope.content.content_data;
				$scope.originEditor.config	= $scope.content.content_config;
				
				$scope.originUI.editor		= $scope.originEditor.config.type;
				
				$scope.editor 	= '/administrator/components/com_emc_origin/assets/templates/'+$scope.originUI.editor+'.html';
				$scope.config	= '/administrator/components/com_emc_origin/assets/templates/config.html';
				add.open();
				break;
		}
	}
	
	
	$j('#fileupload').fileupload({
		dataType: 'json',
		dropZone: $j('#panel, #panel-add'),
		url: '/libraries/evolve/classes/originFileUploader.php',
		add: function(e, data) {
			data.submit();
		},
		done: function(e, data) {
			$scope.uiChange('panel', 'assets');
			$scope.assets = Workspace.loadAssets({id: origin_id});
		}
	});
	
	$j(document).bind('drop dragover', function (e) {
    	e.preventDefault();
    });
	
	
	
	
	$scope.originController('load');
}

var add = (function() {
	var duration	= 200;
	
	function addOpen() {
		$j('#panel-add').animate({left: '250'}, duration);
	}
	
	function addClose() {
		$j('#panel-add').animate({left: '-100'}, duration, function() {
			$j('#workspaceCtrl').scope().originUI.panelAdd	= 'components';
		});
	}

	return {
		open: function() {
			addOpen();
		},
		close: function() {
			addClose();
		}
	}
})();


$j(function() {
	//$j('.originButton-radio').buttonset();
});
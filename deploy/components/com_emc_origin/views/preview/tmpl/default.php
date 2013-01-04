<!DOCTYPE HTML>
<?php
	$this->_addPath( 'template', JPATH_COMPONENT_SITE . DS . 'views' . DS . 'template' . DS . 'tmpl' );
	$originConfigObj= json_decode($this->originObj['config']->config);
		
	$auto			= isset($_GET['auto'])? $_GET['auto']: 0;
	$close			= isset($_GET['close'])? $_GET['close']: 0;
	$hover			= isset($_GET['hover'])? $_GET['hover']: 0;

	$params			= isset($_GET['params'])? stripslashes($_GET['params']): "{'emcOriginDomain': '{$_SERVER['HTTP_HOST']}', 'bgHex': '{$originConfigObj->bgHex}', 'auto': '{$auto}', 'close': '{$close}', 'hover': '{$hover}', 'clickthru1': 'http://www.google.com/?q=click-thru-1','clickthru2': 'http://www.google.com/?q=click-thru-2','clickthru3': 'http://www.google.com/?q=click-thru-3','clickthru4': 'http://www.google.com/?q=click-thru-4','clickthru5': 'http://www.google.com/?q=click-thru-5','preview': true}";
	
	$debug			= isset($_GET['debug'])? '&debug=1': '';
	$cache			= isset($_GET['cache'])? '&cache='.$_GET['cache']: '';
	$link			= 'http://'.$_SERVER['HTTP_HOST'].'/index.php?option=com_emc_origin&view=preview&format=raw&id='.$originConfigObj->id.$debug.$cache.'&auto=0&close=0&hover=0';
	
	$adTag			= "<script type='text/javascript'>
							(function() {
								var emcOriginScript	= document.createElement('script'),
									emcLocation		= document.getElementsByTagName('script')[document.getElementsByTagName('script').length - 1],
									emcOriginConfig	= 'http://{$_SERVER['HTTP_HOST']}/index.php?option=com_emc_origin&view={$originConfigObj->type}&format=raw&id={$originConfigObj->id}{$debug}{$cache}',
									emcOriginParams	= {$params};
									emcOriginScript.src	= 'http://{$_SERVER['HTTP_HOST']}/components/com_emc_origin/assets/js/emcOrigin.js';
		
								if(emcOriginScript.addEventListener) {
									emcOriginScript.addEventListener('load', function(){emcOriginInit(emcLocation)}, false);
								} else if (emcOriginScript.readyState) {
									emcOriginScript.onreadystatechange = function() {
										if(emcOriginScript.readyState == 'loaded') {
											emcOriginInit(emcLocation);
										}
									};
								}

								function emcOriginInit(emcLocation) {
									if(window == window.top) {
										emcOriginCreate.init(emcOriginConfig, emcOriginParams, emcLocation);
									} else {
										var url				= 'http://' + document.referrer.split('/')[2] + '/';
											window.name 	= encodeURIComponent(JSON.stringify(emcOriginParams));
											window.location = url + 'emcOriginIframe/emcOriginIframe.html?'+encodeURIComponent(emcOriginConfig);
									}						
								}
								
								emcLocation.parentNode.insertBefore(emcOriginScript, emcLocation)
					})();
						</script>";
?>
<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title><?php echo $originConfigObj->name;?></title>
			<link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/components/com_emc_origin/assets/css/emcPreview.css" />
			<!--[if LT IE 8]><link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/components/com_emc_origin/assets/css/emcPreview-ie.css" /><![endif]-->
	</head>
	<body id="emcPreview-<?php echo $originConfigObj->type;?>" ng:app="previewApp">
		<div id="content" ng:controller="previewCtrl" ng:models="previews">
			<div id="ad"><?php echo $adTag;?></div>
			
			<div id="item-{{$index}}" class="item" ng:repeat="preview in previews">
				<a href="#" target="_self"><img class="thumbnail" ng:src="{{preview.thumbnail}}"/></a>
				<a href="" target="_top"><h3 class="title">{{preview.title}}</h3></a>
				<p class="blurb">{{preview.blurb}}</p>
				<a href="" class="readmore">read more</a>
			</div>
		</div>
		
		<div ng:controller="typesCtrl" ng:model="types">
			<div id="instructions-wrapper" ng:repeat="type in types | filter: '<?php echo $originConfigObj->type;?>'" class="{{type.position}}">
				<div id="instructions">
					<img id="logo" src="/components/com_emc_origin/assets/images/logo.png"/>
					<p id="description">{{type.description}}</p>
					<img ng:src="{{type.thumbnail}}" id="storyboard"/>
				</div>
			</div>
		</div>
		<div id="watermark"></div>
		<script type="text/javascript" src="/libraries/evolve/js/angularjs/angular.min.js"></script>
		<script type="text/javascript">
			var previewApp	= angular.module('previewApp', []);
		
			previewApp.controller('typesCtrl', function typesCtrl($scope, $http) {
				$http.get('/components/com_emc_origin/assets/data/originTypes.json')
					.success(function(data) {
						$scope.types	= data;
					});
			});
			
			previewApp.controller('previewCtrl', function previewCtrl($scope, $http) {
				$http.get('/components/com_emc_origin/assets/data/preview.json')
					.success(function(data) {
						$scope.previews	= data;
					});
			});
		</script>

	</body>
</html>
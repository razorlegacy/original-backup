<!DOCTYPE HTML>
<?php $debug	= isset($_GET['debug'])? 'dev': 'min';?>
<html ng:app="homepageApp" ng:cloak>
	<head>
		<title>Origin</title>
		<link href="templates/<?php echo $this->template ?>/css/styles.<?php echo $debug;?>.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="/templates/azure/images/favicon.ico"/>
	</head>
	<body id="azure-homepage" class="originUI">
		<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/azure/template/bar.php');?>
		<div id="content-wrapper">
			<div id="showcase" class="originTiles azure-bg-glow" ng:controller="showcaseCtrl">
				<a href="{{showcase.link}}" target="_blank">
					<img ng:src="{{showcase.thumbnail}}"/>
					<div class="originTiles-title originUI-bg">{{showcase.label}}</div>
				</a>
			</div>
			<div id="specsheets" class="originTiles" ng:controller="specsheetCtrl" ng:model="specsheets" style="display: none;"><!--
				--><a href="{{specsheet.pdf}}" id="specSheet-{{specsheet.id}}" class="originTiles" ng:repeat="specsheet in specsheets" target="_blank">
					<img class="specsheet-thumbnail" ng:src="{{specsheet.thumbnail}}"/>
					<div class="originTiles-title">
						<span class="specsheet-label">{{specsheet.label}}</span>
						<img class="specsheet-icon" src="/templates/azure/images/specsheet-icon.png"/>
					</div>
				</a><!--
			--></div>
			<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/azure/template/footer.php');?>
		</div>
		<script type="text/javascript" src="/templates/azure/js/azure.<?php echo $debug;?>.js"></script>
		<script type="text/javascript">
			$j(function() {azure._originBar();});
		</script>
		<!--
<div id="body-bg">
			<img src="/templates/azure/images/_background/bg-blue.png">
		</div>
-->
		
		<script type="text/javascript">
			var homepageApp	= angular.module('homepageApp', []);
		
			homepageApp.controller('showcaseCtrl', function typesCtrl($scope, $http) {
				$http.get('/templates/azure/data/showcase.json')
					.success(function(data) {
						$scope.showcase	= data[Math.floor(Math.random() * data.length)];
					});
			});
			
			homepageApp.controller('specsheetCtrl', function previewCtrl($scope, $http) {
				$http.get('/templates/azure/data/specsheet.json')
					.success(function(data) {
						$scope.specsheets	= data;
					});
			});
		</script>
	</body>
</html>


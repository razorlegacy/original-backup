<!DOCTYPE HTML>
<?php
	$this->_addPath( 'template', JPATH_COMPONENT_SITE . DS . 'views' . DS . 'template' . DS . 'tmpl' );
	$originConfigObj	= json_decode($this->originObj['config']->config);
	$bg					= "http://{$_SERVER['HTTP_HOST']}/assets/components/com_emc_origin/{$this->originObj['config']->id}/";
	
	$this->assignRef('originObj', $this->originObj);
	$this->assignRef('debug', $_GET['debug']);
	$this->assignRef('view', $_GET['view']);
	
	$debug		= isset($_GET['debug'])? '&debug=1': '';
?>
<html>
	<head>
		<title></title>
		<?php
			$this->setLayout('header');
			echo $this->loadTemplate();
		?>
		<script type="text/javascript">
			var data = {
					'animateSelector': 	'default',
					'auto':				1,
					'duration': 		250,
					'emcOriginId': 		'emcOrigin-<?php echo $this->originObj['config']->id;?>',
					'end': 				250,
					'format': 			'overlay',
					'id': 				'<?php echo $this->originObj['config']->id;?>',
					'name': 			'<?php echo addslashes($this->originObj['config']->name);?>',
					'start': 			0,
					'toggle':			'expand',
					'type': 			'<?php echo $_GET['view'];?>',
					'url':				'http://<?php echo $_SERVER['HTTP_HOST'];?>/index.php?option=com_emc_origin&format=raw&id=<?php echo $_GET['id'];?>&view=<?php echo $_GET['view'];?>&layout=expand<?php echo $debug;?>'
				};
		</script>
	</head>
	<body id="emcNova">
		<div id="default" style="background-image: url(<?php echo $bg.$originConfigObj->bgDefault;?>)">
		<?php
			$originWrapper		= 'default';
			$this->assignRef('originObj', $this->originObj);
			$this->assignRef('originWrapper', $originWrapper);
			$this->setLayout('schedule');
			echo $this->loadTemplate();
		?>
		</div>
	</body>
</html>
<!DOCTYPE HTML>
<?php
	$this->_addPath( 'template', JPATH_COMPONENT_SITE . DS . 'views' . DS . 'template' . DS . 'tmpl' );
	$originConfigObj	= json_decode($this->originObj['config']->config);
	$bg					= "http://{$_SERVER['HTTP_HOST']}/assets/components/com_emc_origin/{$this->originObj['config']->id}/";
	
	$this->assignRef('originObj', $this->originObj);
	$this->assignRef('debug', $_GET['debug']);
	$this->assignRef('view', $_GET['view']);
?>
<html>
	<head>
		<title></title>
		<?php
			$this->setLayout('header');
			echo $this->loadTemplate();
		?>
		<script type="text/javascript">
			var	data = {
					'animateSelector': 	'default',
					'auto':				0,
					'duration': 		250,
					'emcOriginId': 		'emcOrigin-<?php echo $this->originObj['config']->id;?>',
					'end': 				250,
					'format': 			'overlay',
					'id': 				'<?php echo $this->originObj['config']->id;?>',
					'name': 			'<?php echo addslashes($this->originObj['config']->name);?>',
					'start': 			0,
					'toggle':			'default',
					'type': 			'<?php echo $_GET['view'];?>'
				};
		</script>
	</head>
	<body id="emcNova">
		
		<div id="expand" style="background-image: url(<?php echo $bg.$originConfigObj->bgExpand;?>)">
		<?php
			$originWrapper		= 'expand';
			$this->assignRef('originObj', $this->originObj);
			$this->assignRef('originWrapper', $originWrapper);
			$this->setLayout('schedule');
			echo $this->loadTemplate();
		?>
		</div>
		<div id="overlay"></div>
	</body>
</html>
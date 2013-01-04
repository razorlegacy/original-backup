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
			var source 	= window.location.hash,
				data = {
					'animateSelector': 	'default',
					'auto':				1,
					'duration': 		250,
					'emcOriginId':		'emcOrigin-<?php echo $this->originObj['config']->id;?>',
					'end': 				250,
					'format': 			'expansion',
					'id': 				'<?php echo $this->originObj['config']->id;?>',
					'name': 			'<?php echo addslashes($this->originObj['config']->name);?>',
					'start': 			0,
					'type': 			'<?php echo $_GET['view'];?>'
				};
		</script>
	</head>
	<body id="emcHorizon">
		<div id="container">
			<div id="default" style="background-image: url(<?php echo $bg.$originConfigObj->bgDefault;?>); display: none;">
				<?php
					$originWrapper		= 'default';
					$this->assignRef('originWrapper', $originWrapper);
					$this->setLayout('schedule');
					echo $this->loadTemplate();
				?>
			</div>
			<div id="expand" style="background-image: url(<?php echo $bg.$originConfigObj->bgExpand;?>); display: none;">
				<?php
					$originWrapper		= 'expand';
					$this->assignRef('originWrapper', $originWrapper);
					$this->setLayout('schedule');
					echo $this->loadTemplate();
				?>
			</div>
		</div>
	</body>
</html>
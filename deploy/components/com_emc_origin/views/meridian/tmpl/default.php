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
<!-- 		<meta name="viewport" content="width=device-width; initial-scale=1; maximum-scale=1; user-scalable=0"> -->
		<title></title>
		<?php
			$this->setLayout('header');
			echo $this->loadTemplate();
		?>
		<script type="text/javascript">
			var source 	= window.location.hash,
				data = {
					'emcOriginId':		'emcOrigin-<?php echo $this->originObj['config']->id;?>',
					'format': 			'type',
					'id': 				'<?php echo $this->originObj['config']->id;?>',
					'mobile':			true,
					'name': 			'<?php echo addslashes($this->originObj['config']->name);?>',
					'type': 			'<?php echo $_GET['view'];?>'
				};
				
			meridianTimer		= (emcOriginConfig.close === '0')? 10: emcOriginConfig.close;
			setTimeout(emcOriginAd.adOpen, meridianTimer * 1000);
		</script>
	</head>
	<body id="emcMeridian">
		<div id="default" data-mobile="<?php echo $bg.$originConfigObj->bgExpand;?>" style="background-image: url(<?php echo $bg.$originConfigObj->bgDefault;?>); display: none;">
			<?php
				$originWrapper		= 'default';
				$this->assignRef('originWrapper', $originWrapper);
				$this->setLayout('schedule');
				echo $this->loadTemplate();
			?>
		</div>
		<div id="overlay">
			<div class="trigger" data-type="click"></div>
			<div id="overlay-close">x</div>
			<div id="overlay-bg"></div>
		</div>
	</body>
</html>
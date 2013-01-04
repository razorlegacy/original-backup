<!DOCTYPE HTML>
<?php
	$this->_addPath( 'template', JPATH_COMPONENT_SITE . DS . 'views' . DS . 'template' . DS . 'tmpl' );
?>
<html>
	<head>
		<title></title>
		<?php
			$this->assignRef('debug', $_GET['debug']);
			$this->assignRef('view', $_GET['view']);
			$this->setLayout('header');
			echo $this->loadTemplate();
		?>

	</head>
	<body id="emcPushdown">
		<div id="pushdown" class="pushdown">
			<div id="default">
				<?php
					$originWrapper		= 'default';
					$this->assignRef('originObj', $this->originObj);
					$this->assignRef('originWrapper', $originWrapper);
					$this->setLayout('schedule');
					echo $this->loadTemplate();
				?>
			</div>
			<div id="expand">
				<?php
					$originWrapper		= 'expand';
					$this->assignRef('originObj', $this->originObj);
					$this->assignRef('originWrapper', $originWrapper);
					$this->setLayout('schedule');
					echo $this->loadTemplate();
				?>
			</div>
		</div>
	</body>
		<script type="text/javascript">
			var source 	= window.location.hash,
				data = {
					'animateSelector': 'expand',
					'duration': 300,
					'emcOriginId': '<?php echo $_GET['emcOriginId'];?>',
					'end': '0px',
					'format': 'expansion',
					'id': '<?php echo $this->originObj['config']->id;?>',
					'name': '<?php echo $this->originObj['config']->name;?>',
					'start': '90px',
					'type': '<?php echo $_GET['view'];?>'
				};
		</script>
</html>
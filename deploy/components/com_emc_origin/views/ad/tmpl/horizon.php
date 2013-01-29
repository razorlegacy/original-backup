<?php defined('_JEXEC') or die('Restricted access');?>
<?php
	$this->_addPath('template', JPATH_COMPONENT_SITE . DS . 'views' . DS . 'components' . DS . 'tmpl' );
	//$bgBase	= "http://{$_SERVER['HTTP_HOST']}/assets/components/com_emc_origin/{$this->originConfig->id}/";
?>
	<script type="text/javascript">
		params = {
			'animateStart':		0,
			'animateEnd':		250,
			'animateTime':		250,
			'animateSelector':	'initial',
			'animateIframeStart':50,
			'animateIframeEnd':	250,
			'emcOriginId':		'emcOrigin-<?php echo $this->originConfig->id;?>',
			'type': 			'<?php echo $this->originConfig->config->type;?>'
		};
	</script>
	<div id="initial" class="wrapper">
		<div class="content"></div>
	</div>
	<div id="triggered" class="wrapper">
		<div class="content"></div>
	</div>
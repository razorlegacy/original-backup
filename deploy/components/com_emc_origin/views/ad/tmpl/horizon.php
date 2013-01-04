<?php defined('_JEXEC') or die('Restricted access');?>
<?php
	$this->_addPath('template', JPATH_COMPONENT_SITE . DS . 'views' . DS . 'components' . DS . 'tmpl' );
	$bgBase	= "http://{$_SERVER['HTTP_HOST']}/assets/components/com_emc_origin/{$this->originConfig->id}/";
?>
	<script type="text/javascript">
		params = {
			'animateStart':		0,
			'animateEnd':		250,
			'animateTime':		250,
			'animateSelector':	'default',
			'emcOriginId':		'emcOrigin-<?php echo $this->originConfig->id;?>',
			'type': 			'<?php echo $this->originConfig->type;?>'
		};
	</script>
	<div id="default" class="wrapper" style="background: transparent url(<?php echo $bgBase.$this->originConfig->bgDefault;?>) no-repeat center top;">
		<div class="content"></div>
	</div>
	<div id="expand" class="wrapper" style="background: transparent url(<?php echo $bgBase.$this->originConfig->bgExpand;?>) no-repeat center top;">
		<div class="content"></div>
	</div>
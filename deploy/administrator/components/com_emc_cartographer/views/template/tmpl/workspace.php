<?php defined('_JEXEC') or die('Restricted access');?>
<?php
	$this->_addPath( 'template', JPATH_COMPONENT_SITE . DS . 'views' . DS . 'template' . DS . 'tmpl' );
?>

<script type="text/javascript">
	$j(function() {
		$j('#workspace_bg_upload').fileupload({
			url: '/libraries/evolve/classes/ajaxFileUploader.php',
			add: function (e, data) {
			data.submit();
		}, done: function (e, data) {
			var dataResponse	= $j.parseJSON(data.result);
			
			$j('input[name="bg_img"]').val(dataResponse[0].name);
			$j('input[name="bg_width"]').val(dataResponse[0].width);
			$j('input[name="bg_height"]').val(dataResponse[0].height);
			cartographerAjax.background_save($j(this));
			}
		});
	});		

</script>
<?php
	$config		= json_decode($this->configObj->content);
	$group		= json_decode($this->groupObj->content);
	$bg_width	= !empty($group->bg_width)? " width: {$group->bg_width}px;": "";
	$bg_height	= !empty($group->bg_height)? " height: {$group->bg_height}px;": "";
	$left		= !empty($group->bg_width)? " left: ".((980 - $group->bg_width)/2)."px;": "";
?>
<div id="cartographer_group_<?php echo $this->groupObj->id;?>" class="cartographer_group evolve-hidden" style="<?php echo $bg_height;?>" data-width="<?php echo $left;?>" data-height="<?php echo $bg_height;?>">
	<form id="workspace_bg_upload" class="evolve-ajaxFileUploader-form evolve-absolute evolve-buttons evolve-shadow evolve-border">
		<div class="evolve-buttons-upload"></div>
		<input type="file" name="files[]" id="files" class="evolve-buttons-file" multiple/>
		<input type="hidden" id="uploadDir" name="uploadDir" value="/assets/components/com_emc_cartographer/<?php echo $this->cartographerObj['config']->id?>/"/>
		<input type="hidden" id="id" name="id" value="<?php echo $this->groupObj->id; ?>"/>
		<input type="hidden" id="cid" name="cid" value="<?php echo $this->groupObj->cid; ?>"/>
		<input type="hidden" name="bg_img"/>
		<input type="hidden" name="bg_width"/>
		<input type="hidden" name="bg_height"/>
	</form>
	<label id="dashboard_upload_title" class="evolve-buttons-title"><?php echo JText::_('DASHBOARD_UPLOAD');?></label>
	
	<div id="workspace_markers" class="evolve-absolute" style="<?php echo $bg_width.$bg_height.$left;?>display:block" data-id="<?php echo $this->groupObj->id;?>">
		<?php	
			foreach($this->groupObj->marker as $key=>$value) {
				$this->assignRef('icon_default', $config->icon);
				$this->assignRef('icon_hover', $config->icon_hover);
				$this->assignRef('markerObj', $value);
				$this->setLayout('marker');
				echo $this->loadTemplate();
			}
		?>
	</div>
	<div id="workspace_background" class="evolve-absolute">
		<?php
			if($bg_width) {
				$this->setLayout('map');
				echo $this->loadTemplate();
			}
		?>
	</div>
	<div id="workspace_instructions" class="evolve-absolute"></div>
</div>
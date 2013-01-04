<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
    $orochiTemplate		= new orochiTemplate();
?>
<script type="text/javascript">
		$j(function() {
			//orochiGeneral.upload('orochi_content_form_gallery');
		});
</script>
	<h3 class="orochi-title"><?php echo JText::_('ADD_IMAGE');?></h3>
	<div class="orochi-uploadify inline">
		<div class="orochi-placeholder-image-thumbnail orochi-shadow orochi-bg-primary orochi-uploadify-placeholder"></div>
		<div class="orochi-uploadify-placeholder-text"><?php echo JText::_('IMAGE_IMAGE_DIMENSIONS');?></div>
		<?php echo $orochiTemplate->uploadify('', 'image', 'image_image');?>
	</div>
	<div id="" class="orochi-content-form inline">
		<ul class="disable-list-style">
			<li>
				<label class="inline"><?php echo JText::_('IMAGE_TITLE');?></label>
				<input type="text" class="websvc-required" name="title" id="image_name" value="" placeholder="<?php echo JText::_('IMAGE_TITLE_PLACEHOLDER');?>" title="<?php echo JText::_('REQUIRED');?>"/>
			</li>
			<li>
				<label class="inline"><?php echo JText::_('IMAGE_CLICK_URL');?></label>
				<input type="text" name="clickURL" id="image_click_url" value="" placeholder="<?php echo JText::_('IMAGE_TROUGH_URL_PLACEHOLDER');?>"/>
			</li>
		</ul>
	</div>
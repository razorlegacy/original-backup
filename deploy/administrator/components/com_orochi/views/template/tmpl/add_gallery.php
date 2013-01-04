<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
    $orochiTemplate		= new orochiTemplate();
?>
<script type="text/javascript">
		$j(function() {
			//orochiGeneral.upload('orochi_content_form_gallery');
		});
</script>
	<h3 class="orochi-title"><?php echo JText::_('ADD_GALLERY');?></h3>
<!--
	<div id="orochi_image_form" class="">
		<ul class="disable-list-style">
			<li>
				<label><?php echo JText::_('IMAGE_TITLE');?></label>
				<input type="text" class="websvc-required" name="title" id="image_name" value="" placeholder="<?php echo JText::_('IMAGE_TITLE_PLACEHOLDER');?>" title="<?php echo JText::_('REQUIRED');?>"/>
			</li>
			<li>
				<label><?php echo JText::_('IMAGE_CLICK_URL');?></label>
				<input type="text" name="clickURL" id="image_click_url" value="" placeholder="<?php echo JText::_('IMAGE_TROUGH_URL_PLACEHOLDER');?>"/>
			</li>
			<li class="orochi-uploadify">
				<?php echo $orochiTemplate->uploadify('', 'image', 'gallery_image');?>
			</li>

		</ul>
		<input type="hidden" id="id" name="id" value="<?php echo $this->orochi->id; ?>"/>
		<input type="hidden" name="image_id" id="id"/>
	</div>
-->
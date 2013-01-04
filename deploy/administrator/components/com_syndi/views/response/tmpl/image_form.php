<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
?>
<h3><a href="#"><?php echo JText::_('ADD_IMAGE');?></a></h3>
<div id="syndi_image_form" class="syndi_fieldset syndi_add_form">
	<div class="upload_image syndi_left">
			<img src="components/com_syndi/assets/images/preview_image.png" rel="components/com_syndi/assets/images/preview_image.png" class="image_preview liveImagePreview"/>
			<input type="file" name="image_upload" id="image_upload_<?php echo $this->tabObj->tab_id;?>"/>
		</div>
		<div class="image_form syndi_right">
			<label><?php echo JText::_('IMAGE_CLICK_URL');?></label>
			<input type="text" name="clickURL" id="image_click_url" value="<?php echo $clickurl;?>" placeholder="<?php echo JText::_('IMAGE_TROUGH_URL');?>"/>
		</div>
		<input type="hidden" name="image" id="image" class="required"/>
		<input type="button" id="form_reset" name="form_reset" value="<?php echo JText::_('FORM_RESET');?>"/>
		<input type="button" id="form_add" name="form_add" value="<?php echo JText::_('FORM_SUBMIT');?>"/>
		<input type='hidden' id='sid' name='sid' value='<?php echo $this->syndi->sid; ?>'/>
		<input type="hidden" name="image_id" id="id"/>
</div>

 
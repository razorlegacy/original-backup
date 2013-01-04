<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
?>
<h3><a href="#"><?php echo JText::_('ADD_VIDEO');?></a></h3>
<div id="syndi_video_form" class="syndi_fieldset syndi_add_form">
	<div class="video_form">
		<label><?php echo JText::_('VIDEO_URL');?></label>
		<textarea name="videoURL" class="livePreviewInput" value="<?php echo $this->syndi->videoURL;?>"></textarea>
	</div>
	<div style="display: none;">
		<div id="preview_wrapper"></div>
	</div>
	<input type="hidden" id="siteId" name="siteId"/>
	<input type="hidden" id="videoId" name="videoId"/>
	<input type="hidden" id="sbFeed" name="sbFeed" class="required"/>
	<input type="hidden" id="id" name="video_id"/>
	<input type="button" id="form_reset" name="form_reset" value="<?php echo JText::_('FORM_RESET');?>"/>
	<input type="button" id="form_preview" name="form_preview" value="<?php echo JText::_('FORM_PREVIEW');?>"/>
	<input type="button" id="form_add" name="form_add" value="<?php echo JText::_('FORM_SUBMIT');?>"/>
</div>
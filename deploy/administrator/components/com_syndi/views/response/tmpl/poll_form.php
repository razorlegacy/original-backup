<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
?>
<h3><a href="#"><?php echo JText::_('ADD_POLL');?></a></h3>
<div id="syndi_poll_form" class="syndi_fieldset syndi_add_form">
	<div class="poll_form">
		<label><?php echo JText::_('POLL_TITLE');?></label>
		<input id="title" name="title" class="required" ></input>
		<label><?php echo JText::_('POLL_EMBED');?></label>
		<textarea id="embed" name="embed" class="livePreviewInput" ></textarea>
	</div>
	<div style="display: none;">
		<div id="preview_wrapper"></div>
	</div>
	<input type="hidden" id="polldaddy_key" name="polldaddy_key"/>
	<input type="hidden" id="polldaddy_feed" name="polldaddy_feed" class="required"/>
	<input type="hidden" id="id" name="poll_id"/>
	<input type="button" id="form_reset" name="form_reset" value="<?php echo JText::_('FORM_RESET');?>"/>
	<input type="button" id="form_preview" name="form_preview" value="<?php echo JText::_('FORM_PREVIEW');?>"/>
	<input type="button" id="form_add" name="form_add" value="<?php echo JText::_('FORM_SUBMIT');?>"/>
</div>
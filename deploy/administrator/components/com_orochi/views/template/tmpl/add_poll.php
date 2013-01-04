<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
?>
	<h3 class="orochi-title"><?php echo JText::_('ADD_POLL');?></h3>
	<div id="orochi_poll_form" class="">
		<ul class="disable-list-style">
			<li>
				<label><?php echo JText::_('POLL_TITLE');?></label>
				<input id="title" name="title" class="websvc-required" placeholder="<?php echo JText::_('POLL_TITLE_PLACEHOLDER');?>" title="<?php echo JText::_('REQUIRED');?>"></input>
			</li>
			<li>
				<label><?php echo JText::_('POLL_EMBED');?></label>
				<textarea id="embed" name="embed" class="livePreviewInput" ></textarea>
			</li>
		<div style="display: none;">
			<div id="preview_wrapper"></div>
		</div>
		</ul>
		<input type="hidden" id="polldaddy_key" name="polldaddy_key"/>
		<input type="hidden" id="polldaddy_feed" name="polldaddy_feed" class="required"/>
		<input type="hidden" id="id" name="poll_id"/>
		<input type="button" id="form_preview" name="form_preview" value="<?php echo JText::_('FORM_PREVIEW');?>"/>
	</div>
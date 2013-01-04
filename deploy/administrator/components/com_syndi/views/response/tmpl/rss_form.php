<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
?>

<h3><a href="#"><?php echo JText::_('ADD_RSS');?></a></h3>
<div id="syndi_rss_form" class="syndi_fieldset syndi_add_form">
	<div class="video_form">
		<ul>
			<li>
				<label><?php echo JText::_('RSS_FEED_URL');?></label>
				<input type="text" name="feed_url" id="feed_url"/>
			</li>
			<li>
				<label><?php echo JText::_('RSS_ARTICLES_NUMBER');?></label>
				<input type="text" name="articles_number" id="articles_number" class="required" value="5" placeholder="<?php echo JText::_('RSS_ARTICLES_PLACEHOLDER');?>" />
			</li>
		</ul>
	</div>
	<div style="display: none;">
		<div id="preview_wrapper"></div>
	</div>
	<input type="hidden" id="id" name="rss_id"/>
	<input type="button" id="form_reset" name="form_reset" value="<?php echo JText::_('FORM_RESET');?>"/>
	<!-- <input type="button" id="form_preview" name="form_preview" value="<?php echo JText::_('FORM_PREVIEW');?>"/> -->
	<input type="button" id="form_add" name="form_add" value="<?php echo JText::_('FORM_SUBMIT');?>"/>
</div>
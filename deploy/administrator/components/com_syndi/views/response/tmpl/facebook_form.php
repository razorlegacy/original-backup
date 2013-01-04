<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
	$syndiTemplate      = new syndiTemplate();
	$arColors = array('light', 'dark');
?>
<h3><a href="#"><?php echo JText::_('ADD_FACEBOOK');?></a></h3>
<div id="syndi_facebook_form" class="syndi_fieldset syndi_add_form">
	<div class="facebook_form ">
		<ul>
			<li>
				<label><?php echo JText::_('FACEBOOK_NAME');?></label>
				<input type="text" class="required" name="name" id="facebook_name" value="" placeholder="<?php echo JText::_('FACEBOOK_NAME');?>"/>
			</li>
			<li>
				<label><?php echo JText::_('FACEBOOK_FEEDURL');?></label>
				<input type="text" name="feedURL" id="facebook_feed_url" placeholder="<?php echo JText::_('FACEBOOK_FEEDURL_TEXT');?>"/>
			</li>
			<li>
				<label><?php echo JText::_('FACEBOOK_HEADER');?></label>
				<input type="checkbox" name="headerCheck" id="facebook_header" class="headerCheck"><?php echo JText::_('FACEBOOK_HEADER_TEXT');?>
			</li>
			<li>
				<label><?php echo JText::_('FACEBOOK_COLORSCHEME');?></label>
				<?php echo $syndiTemplate->_createDropDown($arColors, 'colorscheme' );?>
			</li>
		</ul>
	</div>
	<input type="hidden" id="id" name="facebook_id"/>
	<input type="hidden" id="header" name="header"/>
	<input type="button" id="form_reset" name="form_reset" value="<?php echo JText::_('FORM_RESET');?>"/>
	<input type="button" id="form_preview" name="form_preview" value="<?php echo JText::_('FORM_PREVIEW');?>"/>
	<input type="button" id="form_add" name="form_add" value="<?php echo JText::_('FORM_SUBMIT');?>"/>
	
	<div style="display: none;">
		<div id="preview_wrapper"></div>
	</div>
</div>
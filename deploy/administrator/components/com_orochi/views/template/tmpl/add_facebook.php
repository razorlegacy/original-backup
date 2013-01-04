<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
	$orochiTemplate      = new orochiTemplate();
	$arColors = array('light', 'dark');
?>
	<h3 class="orochi-title"><?php echo JText::_('ADD_FACEBOOK');?></h3>
	<div id="orochi_facebook_form" class="">
		<div class="facebook_form ">
			<ul class="disable-list-style">
				<li>
					<label class="inline"><?php echo JText::_('FACEBOOK_NAME');?></label>
					<input type="text" class="websvc-required" name="title" id="facebook_name" value="" placeholder="<?php echo JText::_('FACEBOOK_NAME');?>" title="<?php echo JText::_('REQUIRED');?>"/>
				</li>
				<li>
					<label class="inline"><?php echo JText::_('FACEBOOK_FEEDURL');?></label>
					<input type="text" name="feedURL" id="facebook_feed_url" placeholder="<?php echo JText::_('FACEBOOK_FEEDURL_TEXT');?>"/>
				</li>
				<li>
					<label class="inline"><?php echo JText::_('FACEBOOK_HEADER');?></label>
					<input type="checkbox" name="headerCheck" id="facebook_header" class="inputCheck"><?php echo JText::_('FACEBOOK_HEADER_TEXT');?>
					<input type="hidden" id="header" name="header" class="check"/>
				</li>
				<li>
					<label class="inline"><?php echo JText::_('FACEBOOK_COLORSCHEME');?></label>
					<?php echo $orochiTemplate->_createDropDown($arColors, 'colorscheme' );?>
				</li>
			</ul>
		</div>
		<input type="hidden" id="id" name="facebook_id"/>
		<!-- <input type="button" id="form_preview" name="form_preview" value="<?php echo JText::_('FORM_PREVIEW');?>"/> -->
		
		<!--
<div style="display: none;">
			<div id="preview_wrapper"></div>
		</div>
-->
	</div>
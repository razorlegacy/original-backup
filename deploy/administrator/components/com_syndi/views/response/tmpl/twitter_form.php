<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
?>
<h3><a href="#"><?php echo JText::_('ADD_TWITTER');?></a></h3>
<div id="syndi_twitter_form" class="syndi_fieldset syndi_add_form">
	<div class="twitter_form">
		<ul>
			<li>
				<label><?php echo JText::_('TWITTER_USERNAME');?></label>
				<input type="text" class="required" name="username" id="username" value="<?php echo $twitter_username;?>" />
			</li>
			<li>
				<label><?php echo JText::_('TWITTER_NUMBER');?></label>
				<input type="text" name="tweets" id="tweets" value="10" />
				<?php //echo $syndiTemplate->_createDropDown($arTweets, 'tweets' );?>
			</li>
			<!--<li>
				<input type="checkbox" name="twitter_avatar" id="avatar" class="check"><?php echo JText::_('TWITTER_AVATAR_TEXT');?>
			</li>
			<li>
				<input type="checkbox" name="timestamp" id="twitter_timestamp" class="check"><?php echo JText::_('TWITTER_TIMESTAMP_TEXT');?>
			</li>
			<li>
				<input type="checkbox" name="twitter_hashtag" id="hashtag" class="check"><?php echo JText::_('TWITTER_HASHTAGS_TEXT');?>
			</li>-->
		</ul>
	</div>
	<div style="display: none;">
		<div id="preview_wrapper"></div>
	</div>
	<input type="hidden" id="id" name="twitter_id"/>
	<input type="hidden" id="avatar" name="avatar" value="false"/>
	<input type="hidden" id="twitter_timestamp" name="twitter_timestamp" value="false"/>
	<input type="hidden" id="hashtag" name="hashtag" value="false"/>
	<input type="button" id="form_reset" name="form_reset" value="<?php echo JText::_('FORM_RESET');?>"/>
	<input type="button" id="form_preview" name="form_preview" value="<?php echo JText::_('FORM_PREVIEW');?>"/>
	<!--input type="button" id="form_add" name="form_add" value="<?php //echo JText::_('FORM_SUBMIT');?>"/-->
	<input type="button" id="save_social" name="save_social" value="<?php echo JText::_('CONFIG_SAVE');?>"/>
</div>
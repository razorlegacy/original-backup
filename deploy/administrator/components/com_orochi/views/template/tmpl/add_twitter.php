<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
?>
<h3 class="orochi-title"><?php echo JText::_('ADD_TWITTER');?></h3>
<div id="orochi_twitter_form" class="">
	<div class="twitter_form">
		<ul class="disable-list-style">
			<li>
				<label class="inline"><?php echo JText::_('TWITTER_TITLE');?></label>
				<input type="text" id="title" name="title" class="websvc-required" placeholder="<?php echo JText::_('TWITTER_TITLE_PLACEHOLDER');?>" title="<?php echo JText::_('REQUIRED');?>"></input>
			</li>
			<li>
				<label class="inline"><?php echo JText::_('TWITTER_USERNAME');?></label>
				<input type="text" class="required" name="username" id="username" value="" />
			</li>
			<li>
				<label class="inline"><?php echo JText::_('TWITTER_NUMBER');?></label>
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
<!--
	<div style="display: none;">
		<div id="preview_wrapper"></div>
	</div>
-->
	<input type="hidden" id="id" name="twitter_id"/>
	<input type="hidden" id="avatar" name="avatar" value="false"/>
	<input type="hidden" id="twitter_timestamp" name="twitter_timestamp" value="false"/>
	<input type="hidden" id="hashtag" name="hashtag" value="false"/>
<!-- 	<input type="button" id="form_preview" name="form_preview" value="<?php echo JText::_('FORM_PREVIEW');?>"/> -->
	<!--input type="button" id="form_add" name="form_add" value="<?php //echo JText::_('FORM_SUBMIT');?>"/-->
</div>
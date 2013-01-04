<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
?>
<h3 class="orochi-title"><?php echo JText::_('ADD_RSS');?></h3>
<div id="orochi_rss_form" class="">
	<div class="rss_form">
		<ul class="disable-list-style">
			<li>
				<label class="inline"><?php echo JText::_('RSS_TITLE');?></label>
				<input type="text" id="title" name="title" class="websvc-required" placeholder="<?php echo JText::_('RSS_TITLE_PLACEHOLDER');?>" title="<?php echo JText::_('REQUIRED');?>"></input>
			</li>
			<li>
				<label class="inline"><?php echo JText::_('RSS_FEED_URL');?></label>
				<input type="text" name="feed_url" id="feed_url"/>
			</li>
			<li>
				<label class="inline"><?php echo JText::_('RSS_ARTICLES_NUMBER');?></label>
				<input type="text" name="articles_number" id="articles_number" class="required" value="5" placeholder="<?php echo JText::_('RSS_ARTICLES_PLACEHOLDER');?>" />
			</li>
		</ul>
	</div>
<!--
	<div style="display: none;">
		<div id="preview_wrapper"></div>
	</div>
	<input type="hidden" id="id" name="rss_id"/>
-->
</div>

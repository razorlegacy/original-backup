<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
    $orochiTemplate		= new orochiTemplate();
?>
<script type="text/javascript">
		$j(function() {
			//orochiGeneral.upload('orochi_content_form_article');
		});
</script>
	<h3 class="orochi-title"><?php echo JText::_('ADD_ARTICLE');?></h3>
	<div class="orochi-uploadify inline">
		<div class="orochi-placeholder-article-thumbnail orochi-shadow orochi-bg-primary orochi-uploadify-placeholder"></div>
		<div class="orochi-uploadify-placeholder-text"><?php echo JText::_('ARTICLE_IMAGE_DIMENSIONS');?></div>
		<?php echo $orochiTemplate->uploadify('', 'image', 'article_image');?>
	</div>
	<div class="orochi-content-form inline">
		<ul class="disable-list-style">
			<li>
				<label class="inline"><?php echo JText::_('ARTICLE_TITLE');?></label>
				<input type="text" class="websvc-required" name="title" id="article_title" value="" placeholder="<?php echo JText::_('ARTICLE_FORM_TITLE');?>" title="<?php echo JText::_('REQUIRED');?>"/>
			</li>
			<li>
				<label class="inline"><?php echo JText::_('ARTICLE_URL');?></label>
				<input type="text" name="link" id="article_link" value="" placeholder="<?php echo JText::_('ARTICLE_FORM_URL');?>"/>
			</li>
			<li>
				<label class="inline"><?php echo JText::_('ARTICLE_CONTENT');?></label>
				<textarea name="content" id="article_content" placeholder="<?php echo JText::_('ARTICLE_CONTENT_PLACEHOLDER');?>"></textarea>
			</li>
		</ul>
	</div>
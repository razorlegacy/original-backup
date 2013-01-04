<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
?>
<h3><a href="#"><?php echo JText::_('ADD_ARTICLE');?></a></h3>
<div id="syndi_article_form" class="syndi_fieldset syndi_add_form">
	<div class="upload_image syndi_left">
		<img src="components/com_syndi/assets/images/preview_article.png" rel="components/com_syndi/assets/images/preview_article.png" class="image_preview"/>
		<input type="file" name="image_upload" id="image_upload_<?php echo $this->tabObj->tab_id;?>"/>
		<input type="hidden" name="image" id="image"/>
		<!-- <input type="button" class="upload_image_clear" name="image_upload_clear" value="<?php echo JText::_('IMAGE_UPLOAD_CLEAR');?>"/> -->
	</div>
	<div class="article_form syndi_right">
		<ul>
			<li>
				<label><?php echo JText::_('ARTICLE_TITLE');?></label>
				<input type="text" class="required" name="title" id="article_title" value="<?php echo $article_title;?>" placeholder="<?php echo JText::_('ARTICLE_FORM_TITLE');?>"/>
			</li>
			<li>
				<label><?php echo JText::_('ARTICLE_URL');?></label>
				<input type="text" name="articleURL" id="article_url" value="<?php echo $article_url;?>" placeholder="<?php echo JText::_('ARTICLE_FORM_URL');?>"/>
			</li>
			<li>
				<label><?php echo JText::_('ARTICLE_CONTENT');?></label>
				<textarea class="elastic" name="content" id="article_content"></textarea>
			</li>
		</ul>
	</div>
	<input type="hidden" id="id" name="article_id"/>
	<input type="button" id="form_reset" name="form_reset" value="<?php echo JText::_('FORM_RESET');?>"/>
	<input type="button" id="form_add" name="form_add" value="<?php echo JText::_('FORM_SUBMIT');?>"/>
</div>
<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
	$evolveObj		= new evolveHelper();
?>
<fieldset id="syndi_article_list" class="syndi_list sortable">
	
		<?php		
		if(empty($this->syndiTab)) {
			echo JText::_('ARTICLE_FORM_NO_ARTICLES');
		} else {
			foreach($this->syndiTab as $key=>$article) {
				$class 	= ($key%2 == 0) ? "even" : "odd";
				$article->title	= stripslashes($article->title);
				$content	= $evolveObj->strMultilineContent($article->content);
				//$article->content		= stripslashes($article->content);
		?>
				<div id="article_<?php echo $article->article_id;?>" class="syndi_data_list <?php echo $class;?>">
					<div class="syndi_left">
						<img src="<?php if($article->image) echo $article->image; else echo "components/com_syndi/assets/images/preview_article.png";?>" class="image_preview"/>
					</div>
					<div class="syndi_right">
						<ul>
							<li>
								<label><?php echo JText::_('ARTICLE_TITLE');?></label>
								<span><?php echo $article->title;?></span>
							</li>
							<li class="collapse">
								<label><?php echo JText::_('ARTICLE_CONTENT');?></label>
								<span><?php echo stripslashes($content);?></span>
							</li>
							<li>
								<label><?php echo JText::_('ARTICLE_URL');?></label>
								<span><a href="<?php echo $article->articleURL;?>" target="_blank"><?php echo $article->articleURL;?></a></span>
							</li>
						</ul>
					</div>
					<div name="syndi_data_list_serialize" style="display: none;"><?php echo json_encode($article);?></div>
					<input type="hidden" name="ordering[]" value="<?php echo $article->article_id;?>"/>
					<a href="#" class="syndi_list_edit options"><?php echo JText::_('LIST_EDIT');?></a>
					<a href="#" class="syndi_list_delete options"><?php echo JText::_('LIST_DELETE');?></a>
				</div>
		<?php
			}
		}
		?>
		<input type="hidden" name="typetab" value="article"/>
		<input type="hidden" name="tab_id" value="<?php echo $article->tab_id;?>"/>
</fieldset>
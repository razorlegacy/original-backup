<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
	$evolveObj		= new evolveHelper();
?>
<fieldset id="syndi_rss_list" class="syndi_list sortable">
		<?php		
		if(empty($this->syndiTab)) {
			echo JText::_('RSS_FORM_NO_RSS');
		} else {
			foreach($this->syndiTab as $key=>$rss) {
				$class 	= ($key%2 == 0) ? "even" : "odd";
				
				$rssXML = simplexml_load_file($rss->feed_url, 'SimpleXMLElement', LIBXML_NOCDATA);
				$rssObj	= $rssXML->channel;
		?>
				<div id="rss_<?php echo $rss->rss_id;?>" class="syndi_data_list <?php echo $class;?>">
					<div class="syndi_right">
						<ul>
							<li>
								<label><?php echo JText::_('RSS_TITLE');?></label>
								<span><?php echo $rssObj->title;?></span>
							</li>
							<li>
								<label><?php echo JText::_('RSS_DESCRIPTION');?></label>
								<span><?php echo $rssObj->description;?></span>
							</li>
							<li>
								<label><?php echo JText::_('RSS_FEED_URL');?></label>
								<span><a href="<?php echo $rss->feed_url;?>" target="_blank"><?php echo $rss->feed_url;?></a></span>
							</li>
							<li>
								<label><?php echo JText::_('RSS_ARTICLES_NUMBER');?></label>
								<span><?php echo $rss->articles_number;?></span>
							</li>
						</ul>
					</div>
					<div name="syndi_data_list_serialize" style="display: none;"><?php echo json_encode($rss);?></div>
					<input type="hidden" name="ordering[]" value="<?php echo $rss->rss_id;?>"/>
					<a href="#" class="syndi_list_edit options"><?php echo JText::_('LIST_EDIT');?></a>
					<a href="#" class="syndi_list_delete options"><?php echo JText::_('LIST_DELETE');?></a>
				</div>
		<?php
			}
		}
		?>
		<input type="hidden" name="typetab" value="rss"/>
</fieldset>
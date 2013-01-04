<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
?>
<fieldset id="syndi_video_list" class="syndi_list sortable">
		<?php
		if(empty($this->syndiTab)) {
			echo JText::_('VIDEO_FORM_NO_VIDEOS');
		} else {
			foreach($this->syndiTab as $key=>$video) {
				$class 	= ($key%2 == 0) ? "even" : "odd";

				$sbFeed	= "http://cms.springboard.gorillanation.com/xml_feeds_advanced/index/{$video->siteId}/3/{$video->videoId}/";
				$sbXml 	= simplexml_load_file($sbFeed, 'SimpleXMLElement', LIBXML_NOCDATA);
				$sbObj	= $sbXml->channel->item;				
		?>
			<div id="video_<?php echo $video->video_id;?>" class="syndi_data_list video_list <?php echo $class;?>">
				<div class="syndi_left">
					<img src="<?php echo $sbObj->image;?>" class="video_preview"/>
				</div>
				<div class="syndi_right">
					<ul>
						<li>
							<label><?php echo JText::_('VIDEO_TITLE');?></label>
							<span><?php echo $sbObj->title;?></span>
						</li>
						<li>
							<label><?php echo JText::_('VIDEO_DESCRIPTION');?></label>
							<span><?php echo $sbObj->description;?></span>
						</li>
<!--
						<li>
							<a href=""><?php echo JText::_('VIDEO_PREVIEW');?></a>
							<div class="" style="display: none"></div>
						</li>
-->
					</ul>
				</div>
				<div name="syndi_data_list_serialize" style="display: none;"><?php echo json_encode($video);?></div>
				<input type="hidden" name="ordering[]" value="<?php echo $video->video_id;?>"/>
				<a href="#" class="syndi_list_delete options"><?php echo JText::_('LIST_DELETE');?></a>
			</div>
		<?php
			}//end foreach
		}//end else
		?>
		<input type="hidden" name="typetab" value="video"/>
		<input type="hidden" name="tab_id" value="<?php echo $video->tab_id;?>"/>
</fieldset>
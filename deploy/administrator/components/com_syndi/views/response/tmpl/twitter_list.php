<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
?>
<fieldset id="syndi_twitter_list" class="syndi_list sortable">
	<?php		
		if(empty($this->syndiTab)) {
			echo JText::_('TWITTER_FORM_NO_TWITTERS');
		} else {
			foreach($this->syndiTab as $key=>$twitter) {
				$class 	= ($key%2 == 0) ? "even" : "odd";
				$twitter_config 	= json_decode($twitter->twitter_config);
				$twitter_config->twitter_id = $twitter->twitter_id;
		?>
				<div id="twitter_<?php echo $twitter->twitter_id;?>" class="syndi_data_list <?php echo $class;?>">
					<ul>
						<li>
							<label><?php echo JText::_('TWITTER_USERNAME');?></label>
							<span><?php echo $twitter_config->username;?></span>
						</li>
						<li>
							<label><?php echo JText::_('TWITTER_NUMBER');?></label>
							<span><?php echo $twitter_config->tweets;?></span>
						</li>
						<!--<li>
							<label><?php echo JText::_('TWITTER_AVATAR_TEXT');?></label>
							<span><?php echo $twitter->avatar;?></span>
						</li>
						<li>
							<label><?php echo JText::_('TWITTER_TIMESTAMP_TEXT');?></label>
							<span><?php echo $twitter->twitter_timestamp;?></span>
						</li>
						<li>
							<label><?php echo JText::_('TWITTER_HASHTAGS_TEXT');?></label>
							<span><?php echo $twitter->hashtag;?></span>
						</li>-->
					</ul>
					<div name="syndi_data_list_serialize" style="display: none;"><?php echo json_encode($twitter_config);?></div>
					<input type="hidden" name="ordering[]" value="<?php echo $twitter->twitter_id;?>"/>
					<a href="#" class="syndi_list_edit options"><?php echo JText::_('LIST_EDIT');?></a>
					<a href="#" class="syndi_list_delete options"><?php echo JText::_('LIST_DELETE');?></a>
				</div>
		<?php
			}
		}
		?>
		<input type="hidden" name="typetab" value="twitter"/>
		<input type="hidden" name="tab_id" value="<?php echo $twitter->tab_id;?>"/>
</fieldset>
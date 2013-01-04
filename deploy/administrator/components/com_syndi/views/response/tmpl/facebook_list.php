<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
?>
<fieldset id="syndi_facebook_list" class="syndi_list sortable">
	<?php		
		if(empty($this->syndiTab)) {
			echo JText::_('FACEBOOK_FORM_NO_FACEBOOKS');
		} else {
			foreach($this->syndiTab as $key=>$facebook) {
				$class 	= ($key%2 == 0) ? "even" : "odd";
		?>
				<div id="facebook_<?php echo $facebook->facebook_id;?>" class="syndi_data_list <?php echo $class;?>">
					<ul>
						<li>
							<label><?php echo JText::_('FACEBOOK_NAME');?></label>
							<span><?php echo $facebook->name;?></span>
						</li>
						<li>
							<label><?php echo JText::_('FACEBOOK_FEEDURL');?></label>
							<span><a href="<?php echo $facebook->feedURL;?>" target="_blank"><?php echo $facebook->feedURL;?></a></span>
						</li>
						<li>
							<label><?php echo JText::_('FACEBOOK_HEADER');?></label>
							<span><?php echo $facebook->header;?></span>
						</li>
						<li>
							<label><?php echo JText::_('FACEBOOK_COLORSCHEME');?></label>
							<span><?php echo $facebook->colorscheme;?></span>
						</li>
					</ul>
					<div name="syndi_data_list_serialize" style="display: none;"><?php echo json_encode($facebook);?></div>
					<input type="hidden" name="ordering[]" value="<?php echo $facebook->facebook_id;?>"/>
					<a href="#" class="syndi_list_edit options"><?php echo JText::_('LIST_EDIT');?></a>
					<a href="#" class="syndi_list_delete options"><?php echo JText::_('LIST_DELETE');?></a>
				</div>
		<?php
			}
		}
		?>
		<input type="hidden" name="typetab" value="facebook"/>
		<input type="hidden" name="tab_id" value="<?php echo $facebook->tab_id;?>"/>
</fieldset>
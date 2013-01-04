<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
?>
<fieldset id="syndi_image_list" class="syndi_list sortable">
		<?php		
		if(empty($this->syndiTab)) {
			echo JText::_('IMAGE_FORM_NO_IMAGES');
		} else {
			foreach($this->syndiTab as $key=>$image) {
				$class 	= ($key%2 == 0) ? "even" : "odd";
			
		?>
				<div id="image_<?php echo $image->image_id;?>" class="syndi_data_list <?php echo $class;?>">
					<div class="syndi_left">
						<img src="<?php echo $image->image;?>" class="image_preview"/>
					</div>
					<div class="syndi_right">
						<label><?php echo JText::_('IMAGE_CLICK_URL');?></label>
						<span><a href="<?php echo $image->clickURL;?>" target="_blank"><?php echo $image->clickURL;;?></a></span>
					</div>
					<div name="syndi_data_list_serialize" style="display: none;"><?php echo json_encode($image);?></div>
					<input type="hidden" name="ordering[]" value="<?php echo $image->image_id;?>"/>
					<a href="#" class="syndi_list_edit options"><?php echo JText::_('LIST_EDIT');?></a>
					<a href="#" class="syndi_list_delete options"><?php echo JText::_('LIST_DELETE');?></a>
				</div>
		<?php
			}
		}
		?>
		<input type="hidden" name="typetab" value="image"/>
</fieldset>
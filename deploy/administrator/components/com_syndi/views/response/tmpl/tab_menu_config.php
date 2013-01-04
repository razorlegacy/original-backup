<?php 
	defined('_JEXEC') or die();
	
	$tab_bg		= ($this->tabObj->tab_bg)? $this->tabObj->tab_bg: "components/com_syndi/assets/images/preview_tab.png";
?>	
	<h3><a href="#"><?php echo JText::_('TAB_CONFIG_BG');?></a></h3>
	<div class="syndi_tab_form">
		<div class="upload_image">
			<img src="<?php echo $tab_bg;?>" rel="components/com_syndi/assets/images/preview_tab.png" id="tab_image_preview"/>
			<input type="file" name="tab_bg_upload" id="tab_config_bg_<?php echo $this->tabObj->tab_id;?>"/>
			<input type="button" class="upload_image_clear" name="image_upload_clear" value="<?php echo JText::_('IMAGE_UPLOAD_CLEAR');?>"/>
			<input type="hidden" name="tab_bg" id="tab_bg"/>
		</div>
		<input type="button" id="tab_bg_add" name="tab_bg_add" value="<?php echo JText::_('FORM_SUBMIT');?>"/>
	</div>
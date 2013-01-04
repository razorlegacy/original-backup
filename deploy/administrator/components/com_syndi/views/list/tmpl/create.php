<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
  	$user 		=& JFactory::getUser();	
?>
	<script type="text/javascript">
		$j(function() {
			syndiCreate.form();
		});
	</script>
	<div id="syndi_create">
	    <form action="index.php" method="POST" name="adminForm" id="adminForm" enctype="multipart/form-data">
			<fieldset class="syndi_fieldset">
				<legend><?php echo JText::_('CREATE_LEGEND');?></legend>
	       		<div id="syndi_tab_left">
					<ul id="" class="">
						<li>
							<label><?php echo JText::_('CREATE_NAME');?></label>
							<input type="text" name="syndi_name" id="syndi_name" class="required" placeholder="Name of Syndi" value="<?php echo $this->syndi->syndi_name;?>"/></li>
						<li>
							<label><?php echo JText::_('CREATE_UPLOAD_BG');?></label>
							<input type="file" name="image_upload" id="image_upload"/>
						</li>
						<li>
							<label><?php echo JText::_('CREATE_MANAGER');?></label>
							<?php echo $this->userObj->userDropDown(1, $this->syndi->manager, $user, 'manager');?>
						</li>
					</ul>
				</div>
				<div id="syndi_tab_right">
					<img src="<?php if($this->syndi->syndi_bg) echo '/assets/components/com_syndi/'.$this->syndi->sid.'/'.$this->syndi->syndi_bg; else echo 'components/com_syndi/assets/images/preview_syndi.png';?>" rel="components/com_syndi/assets/images/syndi_image.png" class="image_preview" id="syndi_image"/>
				</div>
				<input type="button" id="syndi_add" name="syndi_add" value="<?php echo JText::_('CREATE_SUBMIT');?>"/>
			</fieldset>
			<input type="hidden" name="syndi_bg" id="syndi_bg" value="<?php echo $this->syndi->syndi_bg;?>"/>
			<input type="hidden" name="config" value='<?php echo $this->syndi->config;?>'/>
			<input type="hidden" name="option" value="<?php echo JRequest::getVar( 'option' );?>"/>
			<input type="hidden" name="sid" value="<?php echo $this->syndi->sid; ?>"/>  
			<input type="hidden" name="task" value="saveSyndiConfig"/>
	    </form>
	</div>
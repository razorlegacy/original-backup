<?php 
	defined('_JEXEC') or die();
	$syndiTemplate      = new syndiTemplate();
	$syndiModel			= &$this->getModel('syndi');
?>
<div id="tabs">	
	<?php
		$this->setLayout('tabs');
		echo $this->loadTemplate();

		foreach($this->tabsObj as $tab) {
			$syndiTab		= $syndiModel->loadListTab($tab->typetab, $tab->tab_id);
			
			$this->assignRef('tabObj', $tab);
			$this->assignRef('syndiTab', $syndiTab);
			$this->assignRef('tab_id',$tab->tab_id);
						
	?>
		<div id="<?php echo $tab->alias.'_'.$tab->tab_id;?>">
			<form id="syndi_form">
				<div id="syndi_tab_left" class="accordion">
					<?php
						//Load Template
						$this->setLayout($tab->typetab.'_form');
						echo $this->loadTemplate();
						
						$this->setLayout('tab_menu_config');
						echo $this->loadTemplate();
					?>
				</div>
				<div id="syndi_tab_right">
				<?php
					//Load List
					$this->setLayout($tab->typetab.'_list');
					echo $this->loadTemplate();
				?>
				</div>
				<input type="hidden" id="typetab" name="typetab" value="<?php echo $tab->typetab;?>"/>
				<input type="hidden" name="tab_id" id="tab_id" value="<?php echo $tab->tab_id;?>"/>
				<input type="hidden" name="sid" id="sid" value="<?php echo $tab->sid;?>"/>
				<input type="hidden" id="task" name="task" value="saveForm"/>
			</form>
		</div>
	<?php
		}
	?>
	<div id="syndi_add_tab">
		<div class="spacer syndi_left">&nbsp;</div>
		<form name="adminForm" id="adminForm" class="syndi_right">
			<fieldset class="syndi_fieldset">
				<legend>Add New Tab</legend>
				<ul id="" class="">
					<li>
						<label><?php echo JText::_('TAB_NAME');?></label>
						<input type="text" name="title" class="required" id="tabsTitle" placeholder="Tab Name" value=""/>
					</li>
					<li>
						<label><?php echo JText::_('TAB_TYPE');?></label>
						<?php echo $syndiTemplate->_createTabsSelect('typetab');?>
					</li>
					<li>
						<label><?php echo JText::_('TAB_BG');?></label>
						<div id="tab_upload">
							<img src="components/com_syndi/assets/images/preview_tab.png" rel="components/com_syndi/assets/images/preview_tab.png" id="tab_image_preview"/>
							<input type="file" name="tab_bg_upload" id="tab_bg_upload"/>
							<input type="button" class="upload_image_clear" name="image_upload_clear" value="<?php echo JText::_('IMAGE_UPLOAD_CLEAR');?>"/>
							<input type="hidden" name="tab_bg" id="tab_bg"/>
						</div>
					</li>
				</ul>
				<input type="hidden" name="option" value="<?php echo JRequest::getVar( 'option' );?>"/>
				<input type="hidden" name="sid" id="sid" value="<?php echo $this->syndi->sid; ?>"/>
				<input type="hidden" name="task" value="addTab"/>
				<input type="button" name="new_tab" id="new_tab" value="<?php echo JText::_('TAB_ADD');?>"/>
			</fieldset>	
		</form>	
	</div>
</div>
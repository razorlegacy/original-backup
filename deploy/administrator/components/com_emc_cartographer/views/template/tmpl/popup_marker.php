<?php defined('_JEXEC') or die('Restricted access');?>
<?php
	$configObj				= json_decode($this->cartographerObj['config']->content);
	$assetsURL				= '/assets/components/com_emc_cartographer/'.$this->cartographerObj['config']->id.'/';
?>
	<h2><?php echo JText::_('MARKER_HEADER');?></h2>
	<div id="popup_marker_icons" class="evolve-absolute evolve-config-group">
		<h3><?php echo JText::_('MARKER_HEADER_ICONS');?></h3>
		<div id="marker_upload_default" class="evolve-absolute">
			<?php
			$this->assignRef('thumbnail', $configObj->icon);
			$this->setLayout('marker_upload');
			echo $this->loadTemplate();
			?>
			<label id="" class="evolve-buttons-title"><?php echo JText::_('MARKER_UPLOAD_TITLE');?></label>
		</div>
		<div id="marker_upload_hover" class="evolve-absolute">
			<?php
			$this->assignRef('thumbnail', $configObj->icon_hover);
			$this->setLayout('marker_upload');
			echo $this->loadTemplate();
			?>
			<label id="" class="evolve-buttons-title"><?php echo JText::_('MARKER_UPLOAD_HOVER_TITLE');?></label>
		</div>
	</div>
	<form id="popup_marker_form" class="evolve-preview-source evolve-config" onsubmit="return false">
		<div id="popup_marker_content" class="evolve-config-group">
			<h3><?php echo JText::_('MARKER_HEADER_TITLE');?></h3>
			<input type="text" name="title" id="marker_title" class="evolve-required" placeholder="<?php echo JText::_('MARKER_TITLE_PLACEHOLDER');?>" title="<?php echo JText::_('REQUIRED');?>"/>
			<h3><?php echo JText::_('MARKER_HEADER_DESCRIPTION');?></h3>
			<textarea name="content" id="marker_text" class="evolve-tinymce" name="content"></textarea>
		</div>
		<div id="popup_marker_config" class="evolve-config-group evolve-relative">
			<h3><?php echo JText::_('MARKER_HEADER_SETTINGS');?></h3>
			<ul class="evolve-disable-list-style">
				<li>
					<label><?php echo JText::_('POPUP_MARKER_LINK_OVERRIDE');?></label>
					<select name="tooltip_link_override">
						<option value="0">No</option>
						<option value="1">Yes</option>
					</select>
				</li>
				<li>
					<label><?php echo JText::_('POPUP_MARKER_SIZE_TITLE');?></label>
					<select name="tooltip_size_type">
						<option value="default"><?php echo JText::_('POPUP_MARKER_SIZE_DEFAULT');?></option>
						<option value="full"><?php echo JText::_('POPUP_MARKER_SIZE_FULL');?></option>
						<option value="custom"><?php echo JText::_('POPUP_MARKER_SIZE_CUSTOM');?></option>
					</select>
				</li>
			</ul>
			<div id="tooltip_size_custom" class="evolve-hidden evolve-absolute">
				<ul class="evolve-disable-list-style">
					<li>
						<label><?php echo JText::_('POPUP_MARKER_SIZE_WIDTH');?></label>
						<input type="text" name="tooltip_width_value"/> px
					</li>
					<li>
						<label><?php echo JText::_('POPUP_MARKER_SIZE_HEIGHT');?></label>
						<input type="text" name="tooltip_height_value"/> px
					</li>
				</ul>
			</div>
		</div>
		<input type="hidden" name="icon"/>
		<input type="hidden" name="icon_hover"/>
		<input type="hidden" name="image_key" value=""/>
	
		<div class="evolve-buttons-confirm">
			<?php
			echo evolveUi::dialogButton('56', JText::_('BUTTON_CANCEL'), 'popup_close', 'evolve-bg-primary');
			echo evolveUi::dialogButton('44', JText::_('BUTTON_SAVE'), 'marker_save', 'evolve-bg-primary');
			?>
		</div>
	</form>
<?php defined('_JEXEC') or die('Restricted access');?>

<?php
	$configObj				= json_decode($this->cartographerObj['config']->content);
	
?>
	<style type="text/css">
		#cartographer_tooltip_preview {
			border: 1px solid <?php echo $configObj->popup_border_hex;?>;
			background-color: <?php echo $configObj->popup_bg_hex;?>;
			color: <?php echo $configObj->popup_text_hex;?>;
		}
		
		#cartographer_tooltip_preview h1,
		#cartographer_tooltip_preview h2,
		#cartographer_tooltip_preview h3,
		#cartographer_tooltip_preview h4,
		#cartographer_tooltip_preview h5,
		#cartographer_tooltip_preview h6 {
			color: <?php echo $configObj->popup_title_hex;?>;
		}
		
		#cartographer_tooltip_preview a {
			font-weight: bold;
			color: <?php echo $configObj->popup_link_hex;?>;
		}
		
		#cartographer_setup_css { 
			width: 750px;
			height: 400px;
		}
		
		.ui-tooltip {
			max-width: 780px;
		}
		
		.css_buttons {
			float: right;
		}
		
	</style>
	<h2><?php echo JText::_('STYLES_HEADER');?></h2>
	
	<div id="marker_upload" class="evolve-relative evolve-config-group">
		<h3><?php echo JText::_('STYLES_HEADER_ICONS');?></h3>
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
	<form id="save_style_form" class="evolve-preview-source evolve-form evolve-config" onsubmit="return false">
		<input type="hidden" name="icon" value="<?php echo $configObj->icon;?>"/>
		<input type="hidden" name="icon_hover" value="<?php echo $configObj->icon_hover;?>"/>
		<input type="hidden" name="image_key" value="icon,icon_hover"/>
		<div class="evolve-config-group">
			<h3><?php echo JText::_('STYLES_HEADER_OPTIONS');?></h3>
			<ul class="evolve-disable-list-style">
				<li>
					<label class=""><?php echo JText::_('STYLES_POPUP_TRIGGER');?></label>
					<select name="tooltip_trigger">
						<?php
						$tooltipTriggers	= array('click'=>'Click', 'hover'=>'Roll-over');
						foreach($tooltipTriggers as $key=>$value) {
							$selected	= ($configObj->tooltip_trigger == $key)? " selected='selected'": "";
						?>
							<option value="<?php echo $key;?>"<?php echo $selected;?>><?php echo $value;?></option>
						<?php
						}
						?>
					</select>
				</li>
				<li>
					<label class=""><?php echo JText::_('STYLES_POPUP_STYLE');?></label>
					<select name="tooltip_style">
						<?php
						$tooltipStyles	= array('custom'=>'Custom', 'craveonline'=>'CraveOnline', 'momtastic'=>'Momtastic', 'ringtv'=>'RingTV', 'superherohype'=>'SuperHeroHype', 'thefashionspot'=>'TheFashionSpot', 'wrestlezone'=>'WrestleZone');
						
						foreach($tooltipStyles as $key=>$value) {
							$selected	= ($key == $configObj->tooltip_style)? " selected='selected'": "";
						?>
							<option value="<?php echo $key;?>"<?php echo $selected;?>><?php echo $value;?></option>
						<?php
						}
						?>
					</select>
				</li>
			</ul>
			<div id="cartographer_tooltip_preview" class="evolve-shadow">
				<h4><?php echo JText::_('STYLES_PREVIEW_TITLE');?></h4>
				<p><?php echo JText::_('STYLES_PREVIEW_CONTENT');?></p>
				<a><?php echo JText::_('STYLES_PREVIEW_Link');?></a>
			</div>
		</div>	
		<div class="evolve-config-group">
			<h3><?php echo JText::_('STYLES_HEADER_COLOR_CUSTOMIZE');?></h3>
			<ul class="evolve-disable-list-style">
				<li>
					<label class=""><?php echo JText::_('STYLES_POPUP_BORDER_HEX');?></label>
					<input type="text" name="popup_border_hex" class="evolve-miniColors" value="<?php echo $configObj->popup_border_hex;?>"/>
				</li>
				<li>
					<label class=""><?php echo JText::_('STYLES_POPUP_BG_HEX');?></label>
					<input type="text" name="popup_bg_hex" class="evolve-miniColors" value="<?php echo $configObj->popup_bg_hex;?>"/>
				</li>
				<li>
					<label class=""><?php echo JText::_('STYLES_POPUP_TITLE_HEX');?></label>
					<input type="text" name="popup_title_hex" class="evolve-miniColors" value="<?php echo $configObj->popup_title_hex;?>"/>
				</li>
				<li>
					<label class=""><?php echo JText::_('STYLES_POPUP_TEXT_HEX');?></label>
					<input type="text" name="popup_text_hex" class="evolve-miniColors" value="<?php echo $configObj->popup_text_hex;?>"/>
				</li>
				<li>
					<label class=""><?php echo JText::_('STYLES_POPUP_LINK_HEX');?></label>
					<input type="text" name="popup_link_hex" class="evolve-miniColors" value="<?php echo $configObj->popup_link_hex;?>"/>
				</li>
			</ul>
		</div>
		
		<div class="evolve-buttons-confirm">
			<?php
			echo evolveUi::dialogButton('56', JText::_('BUTTON_CANCEL'), 'styles_cancel', 'evolve-bg-primary');
			echo evolveUi::dialogButton('44', JText::_('BUTTON_SAVE'), 'styles_save', 'evolve-bg-primary');
			?>
		</div>
	</form>
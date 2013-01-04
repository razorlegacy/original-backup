<?php defined('_JEXEC') or die('Restricted access');?>

<?php
	$configObj				= json_decode($this->cartographerObj['config']->content);
?>
	<h2><?php echo JText::_('OPTIONS_HEADER');?></h2>
	<form id="save_settings_form" class="evolve-preview-source" onsubmit="return false">
	<ul class="evolve-disable-list-style">
		<li>
			<label class=""><?php echo JText::_('OPTIONS_NAME');?></label>
			<input type="text" name="name" class="evolve-required" placeholder="<?php echo JText::_('OPTIONS_NAME_PLACEHOLDER');?>" value="<?php echo $this->cartographerObj['config']->name;?>"/>
		</li>
		<li>
			<label class=""><?php echo JText::_('OPTIONS_GA');?></label>
			<input type="text" name="ga" placeholder="<?php echo JText::_('OPTIONS_GA_PLACEHOLDER');?>" value="<?php echo $configObj->ga;?>"/>
		</li>
		<li>
			<label class=""><?php echo JText::_('OPTIONS_CSS');?></label>
			<input type="text" name="css_modal" readonly="readonly" placeholder="<?php echo JText::_('OPTIONS_CSS_PLACEHOLDER');?>"/>
			<div id="css_modal" class="evolve-hidden">
				<textarea name="setup_css" id="cartographer_setup_css"><?php echo $configObj->css;?></textarea>
				<div class="css_buttons">
				<?php 
				echo evolveUi::dialogButton('56', JText::_('BUTTON_CANCEL'), 'css_cancel', 'evolve-bg-primary');
				echo evolveUi::dialogButton('44', JText::_('BUTTON_SAVE'), 'css_save', 'evolve-bg-primary');
				?>
				</div>
			</div>
			<input type="hidden" name="css" id="css" value="<?php echo $configObj->css;?>"/>
		</li>
	</ul>
	
	
	<div class="evolve-buttons-confirm">
		<?php
		echo evolveUi::dialogButton('56', JText::_('BUTTON_CANCEL'), 'settings_cancel', 'evolve-bg-primary');
		echo evolveUi::dialogButton('44', JText::_('BUTTON_SAVE'), 'settings_save', 'evolve-bg-primary');
		?>
	</div>
	</form>
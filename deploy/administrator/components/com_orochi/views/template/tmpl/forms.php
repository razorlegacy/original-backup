<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
    
    $orochiTemplate			= new orochiTemplate();

?>
	<div class="orochi_type_buttons">
		<a href="#" class="button orochi-button orochi-bg-secondary active orochi-tips" title="<?php echo JText::_('TYPE_250_TIP');?>" name="orochi_type_250">
			<span class="icon icon84"></span>
			<span class="label"><?php echo JText::_('TYPE_250');?></span>
		</a>
		<a href="#" class="button orochi-button orochi-bg-secondary orochi-tips" title="<?php echo JText::_('TYPE_600_TIP');?>" name="orochi_type_600">
			<span class="icon icon84"></span>
			<span class="label"><?php echo JText::_('TYPE_600');?></span>
		</a>
		<a href="#" class="button orochi-button orochi-bg-secondary orochi-tips" title="<?php echo JText::_('TYPE_BOTH_TIP');?>" name="orochi_type_both">
			<span class="icon icon84"></span>
			<span class="label"><?php echo JText::_('TYPE_BOTH');?></span>
		</a>
	</div>
	<div id="orochi_forms_config" class="orochi-border orochi-bg-secondary">
		<?php
			$this->setLayout('forms_config');
			echo $this->loadTemplate();
		?>
	</div>
	<div class="orochi-hidden">
		<div id="orochi_forms_menu" class="orochi-bg-primary">
			<?php
				$this->setLayout('forms_menu');
				echo $this->loadTemplate();
			?>
		</div>	
		<div id="orochi_forms_edit" class="">
			<div id="orochi_forms_content" class="inline orochi-border orochi-bg-secondary"></div>
			<div id="orochi_forms_groups" class="inline">
				<div id="orochi_forms_groups_content" class="orochi-border orochi-scrollable orochi-bg-primary"></div>
			</div>
		</div>
		<div id="orochi_forms_confirm" class="orochi-bg-primary orochi-border orochi-shadow">
			<form>
				<div id="forms_confirm_message"></div>
				<input type="hidden" name="deleteType" value=""/>
				<input type="hidden" name="id" value=""/>
				
				<div class="orochi_submit_buttons">
					<a href="#" class="button orochi-button orochi-bg-secondary" name="forms_confirm_no">
						<span class="icon icon56"></span>
						<span class="label"><?php echo JText::_('CONFIRM_NO');?></span>
					</a>
					<a href="#" class="button orochi-button orochi-bg-secondary" name="forms_confirm_yes">
						<span class="icon icon44"></span>
						<span class="label"><?php echo JText::_('CONFIRM_YES');?></span>
					</a>
				</div>
			</form>
		</div>
	</div>
<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
    
    $orochiTemplate		= new orochiTemplate();
?>
	<div id="orochi_type_pager" class="orochi-border orochi-bg-primary orochi-notched-tabs">
		<ul id="" class="list-inline"><!--
		<?php
			$cnt	= 0;
			foreach($orochiTemplate->tabsType as $key=>$type) {
				$lastItem	= ($cnt == count($orochiTemplate->tabsType) - 1)? "list-last": "";
		?>
				--><li id="add_type_<?php echo $key;?>" class="<?php echo $lastItem;?> orochi-bg-primary orochi-tips" title="<?php echo $type;?>" >
					<a href="#orochi_content_<?php echo strtolower($key);?>" class="icons_type" style="background-position: <?php echo $cnt*(-32);?>px 0">
						<span><?php echo $type;?></span>
					</a>
				</li><!--
		<?php
				$cnt++;
			}
		?>
		--></ul>			
	</div>
	<?php
	foreach($orochiTemplate->tabsType as $key=>$type) {
	?>
		<div id="orochi_content_<?php echo strtolower($key);?>" class="">
			<form id="orochi_content_form_<?php echo strtolower($key);?>" name="orochi_content_form" class="orochi-form">
			<?php	
				$this->setLayout('add_'.strtolower($key));
				echo $this->loadTemplate();
			?>
				<input type="hidden" name="id"/>
				<input type="hidden" value="<?php echo strtolower($key);?>" name="type">
				<div class="orochi_submit_buttons">
					<a href="#" class="button orochi-button orochi-bg-primary" name="form_reset">
						<span class="icon icon188"></span>
						<span class="label"><?php echo JText::_('FORM_RESET');?></span>
					</a>
					<a href="#" class="button orochi-button orochi-bg-primary" name="form_add">
						<span class="icon icon44"></span>
						<span class="label"><?php echo JText::_('FORM_SUBMIT');?></span>
					</a>
				</div>
			</form>
		</div>
	<?php
	}
	?>	
<?php defined('_JEXEC') or die('Restricted access');?>
<?php
	$this->assignRef('configObj', $this->cartographerObj['config']);
	$this->_addPath( 'template', JPATH_COMPONENT_ADMINISTRATOR . DS . 'views' . DS . 'template' . DS . 'tmpl' );
	$this->_addPath( 'template', JPATH_COMPONENT_SITE . DS . 'views' . DS . 'template' . DS . 'tmpl' );
	
	$baseLink = 'http://'.emcHostName.'/index.php?option=com_emc_cartographer&view=display&format=raw&id='.$this->cartographerObj['config']->id;
	//print_r($this->cartographerObj['data'][0]->marker[0]->content);
?>
	<link rel="stylesheet" type="text/css" href="http://<?php echo emcHostName;?>/index.php?option=com_emc_cartographer&view=template&layout=css&format=raw&id=<?php echo $this->cartographerObj['config']->id;?>" />
	
	<script type="text/javascript">
		$j(function() {cartographerMain.init();});
	</script>
	<form action="index.php" method="POST" name="adminForm" id="adminForm">
		<input type="hidden" name="cartographer_id" value="<?php echo $this->cartographerObj['config']->id;?>"/>
		<input type="hidden" name="group_id" value="<?php echo $this->cartographerObj['groups'][0]->id;?>"/>
		<input type="hidden" name="option" value="com_emc_cartographer"/>
		<input type="hidden" name="task" value="cancel"/>
	</form>
	
	<div id="evolve-toolbar" class="evolve-border evolve-shadow evolve-bg-secondary">
		<h2 id="cartographer_toolbar_title" class="evolve-inline evolve-inline"><?php echo $this->cartographerObj['config']->name;?></h2>
		<div id="cartographer_toolbar_link" class="evolve-inline"></div>
		<!-- <input type="text" id="cartographer_toolbar_link" class="evolve-inline" value="<?php echo JRoute::_($baseLink);?>" readonly="readonly"/> -->
		<div id="cartographer_toolbar_buttons" class="evolve-inline">
		<?php
			echo evolveUi::dialogButton('105', JText::_('TOOLBAR_HELP'), 'toolbar_help', 'evolve-bg-primary');
			echo evolveUi::dialogButton('198', JText::_('TOOLBAR_PREVIEW'), 'toolbar_preview', 'evolve-bg-primary');
			echo evolveUi::dialogButton('44', JText::_('TOOLBAR_EXIT'), 'toolbar_exit', 'evolve-bg-primary');
		?>
		</div>
	</div>

	<div id="cartographer_wrapper">
		<div id="cartographer_dashboard" class="">
		
			<div id="cartographer_styles" class="evolve-buttons evolve-inline evolve-shadow evolve-border evolve-absolute">
				<label class="evolve-buttons-title"><?php echo JText::_('DASHBOARD_STYLES');?></label>
			</div>
			<div id="cartographer_add_marker" class="evolve-buttons evolve-inline evolve-shadow evolve-border evolve-absolute">
				<label class="evolve-buttons-title"><?php echo JText::_('DASHBOARD_MARKER');?></label>
			</div>
			
			<div id="cartographer_groups" class="evolve-buttons evolve-inline evolve-shadow evolve-border evolve-absolute">
				<label class="evolve-buttons-title"><?php echo JText::_('DASHBOARD_GROUP');?></label>
			</div>
			
			<!-- cartographer_options-->
			<div id="cartographer_settings" class="evolve-buttons evolve-inline evolve-shadow evolve-border evolve-absolute">
				<label class="evolve-buttons-title"><?php echo JText::_('DASHBOARD_SETTINGS');?></label>
			</div>
			
			<div class="evolve-hidden">
				<div id="popup_styles" class="">
					<?php 
						$this->setLayout('styles');
						echo $this->loadTemplate();
					?>
				</div>
				<div id="popup_marker" class="evolve-relative">
					<?php
						$this->setLayout('popup_marker');
						echo $this->loadTemplate();
					?>
				</div>
				
				<div id="popup_group" class="evolve-relative">
					<?php
						$this->setLayout('popup_group');
						echo $this->loadTemplate();
					?>
				</div>
				
				<div id="popup_settings" class="evolve-form evolve-config">
					<?php
						$this->setLayout('settings');
						echo $this->loadTemplate();
					?>
				</div>
			</div>		
		</div>
		
		<div id="cartographer_workspace" class="evolve-shadow evolve-inline">
			<?php 
				for($i=0; $i < sizeof($this->cartographerObj['groups']); $i++) {
					
					$this->assignRef('groupObj', $this->cartographerObj['groups'][$i]);
					$this->setLayout('workspace');
					echo $this->loadTemplate();
				}
			?>
		</div>
<!--
		<div id="cartographer_layers" class="evolve-inline evolve-relative">
			<?php
			//$this->setLayout('layers');
			//echo $this->loadTemplate();
			?>
		</div>
-->
	
	</div>
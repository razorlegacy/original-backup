<?php defined('_JEXEC') or die('Restricted access');?>
<?php
	$this->_addPath( 'template', JPATH_COMPONENT_ADMINISTRATOR . DS . 'views' . DS . 'template' . DS . 'tmpl' );
	//$this->_addPath( 'template', JPATH_COMPONENT_SITE . DS . 'views' . DS . 'template' . DS . 'tmpl' );
	
	$originConfigObj		= $this->originObj['config'];
	$originContentObj		= $this->originObj['content'];
	$configObj				= json_decode($originConfigObj->config);
	$baseUrl				= "/assets/components/com_emc_origin/{$originConfigObj->id}/";
	
	
	$bgHex					= !empty($configObj->bgHex)? $configObj->bgHex: '';
	$bgDefault				= !empty($configObj->bgDefault)? "background: {$bgHex} url({$baseUrl}{$configObj->bgDefault}) no-repeat top center;": '';
	$bgExpand				= !empty($configObj->bgExpand)? "background: {$bgHex} url({$baseUrl}{$configObj->bgExpand}) no-repeat top center;": '';
	//$bgDefault			= "background: transparent url(/assets/components/com_emc_origin/{$originConfigObj->id}/{$bgDefault}) no-repeat 0 0;";
	//$bgExpand				= "background: transparent url(/assets/components/com_emc_origin/{$originConfigObj->id}/{$bgExpand}) no-repeat 0 0;";
	
	$this->assignRef('originConfigObj', $originConfigObj);
	
	//TEMP: MOBILE SUPPORT
	switch($configObj->type) {
		case 'meridian':
			$jtext_toolpad_expand	= 'Mobile View';
			break;
		default:
			$jtext_toolpad_expand	= JText::_('TOOLPAD_EXPAND');
			break;
	}
?>
	<script type="text/javascript">
		$j(function(){
			originMain.init();
			//evolveJS.notification('Updated', 'Content positioning updated');
			<?php
			//Trigger BG upload option
			if(empty($bgDefault)) {
			?>
			originMain.modal($j(this), 'settings', 'settings');
			<?php
			}
			?>
		});
	</script>
	<form action="index.php" method="POST" name="adminForm" id="adminForm">
		<input type="hidden" name="origin_id" value="<?php echo $this->originObj['config']->id;?>"/>
		<input type="hidden" name="option" value="com_emc_origin"/>
		<input type="hidden" name="sid" value=""/>
		<input type="hidden" name="task" value="cancel"/>
	</form>
	
	<div id="evolve-toolbar" class="evolve-border evolve-shadow evolve-bg-secondary">
		<h2 id="origin_toolbar_title" class="evolve-inline evolve-inline">
			<?php 
				echo $this->originObj['config']->name;
				if($configObj->status === 'inactive') echo '[inactive]';
			?>
		</h2>
		<div id="origin_toolbar_buttons" class="evolve-inline">
		<?php
			echo evolveUi::dialogButton('105', JText::_('TOOLBAR_HELP'), 'toolbar_help', 'evolve-bg-primary');
			//echo evolveUi::dialogButton('119', JText::_('TOOLBAR_LINK'), 'toolbar_link', 'evolve-bg-primary');
			
			//http://{$_SERVER['HTTP_HOST']}/index.php?option=com_emc_origin&view=preview&format=raw&id={$origin->id}&auto=0&close=0&hover=.3&cache=".rand();
		?>
			<a name="toolbar_preview" class="evolve-ui-button evolve-bg-primary" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/index.php?option=com_emc_origin&format=raw&view=preview&id=<?php echo $this->originObj['config']->id;?>&auto=0&close=0&hover=0&cache=<?php echo rand();?>" target="_blank">
				<span class="evolve-ui-icon evolve-ui-icon198"></span>
				<span class="evolve-ui-label"><?php echo JText::_('TOOLBAR_PREVIEW');?></span>
			</a>
		<?php	
			echo evolveUi::dialogButton('119', JText::_('LIST_EMBED'), 'origin_list_embed', 'origin_list_embed evolve-bg-primary');
			echo evolveUi::dialogButton('44', JText::_('TOOLBAR_EXIT'), 'toolbar_exit', 'evolve-bg-primary');
		?>
		</div>
	</div>

	<div id="origin_wrapper" class="evolve-relative evolve-shadow evolve-border origin_<?php echo $configObj->type;?> evolve-bg-tertiary">
		
		<div class="origin-toolpad-bg">
			<div id="origin_schedule">
				<div class="origin_schedule_create evolve-bg-primary evolve-inline"></div>
				<?php
				//echo evolveUi::dialogButton('33', '', 'origin_schedule_create', 'evolve-bg-primary origin_schedule_add');
				foreach($originContentObj as $key=>$scheduleObj) {
					$startDate = $endDate = '';
					if($key == 0) {
						$dateRange	= 'Default';
					} else {
						$startDate	= ($scheduleObj->start_date)? date('n/j/Y', strtotime($scheduleObj->start_date)): 'N/A';
						$endDate	= ($scheduleObj->end_date)? date('n/j/Y', strtotime($scheduleObj->end_date)): 'N/A';
						$dateRange	= $startDate.' - '.$endDate;
					}
					echo evolveUi::dialogButton('33', $dateRange, 'origin_schedule_'.$scheduleObj->id, 'evolve-bg-primary origin_schedule_tab', array('id'=>$scheduleObj->id, 'startDate'=>$startDate, 'endDate'=>$endDate));
										
				}
				?>	
			</div>
			<div id="origin_workspace_wrapper">
				<div id="origin_toolpad_right" class="">
				<?php
				foreach($originContentObj as $key=>$scheduleObj) {
				?>
					<div id="origin_schedule_<?php echo $scheduleObj->id;?>" class="origin_workspace evolve-hidden" data-id="<?php echo $scheduleObj->id;?>">
						<div class="workspace_default evolve-hidden" style="<?php echo $bgDefault;?>">
							<div class="origin_template evolve-relative" style="<?php echo '';?>">
								<?php
									$this->assignRef('contentObj', $scheduleObj->content['default']);
									$this->setLayout('workspace');
									echo $this->loadTemplate();
								?>
							</div>
						</div>
						<div class="workspace_expand evolve-hidden" style="<?php echo $bgExpand;?>">
							<div class="origin_template evolve-relative" style="<?php echo '';?>">
								<?php
									$this->assignRef('contentObj', $scheduleObj->content['expand']);
									$this->setLayout('workspace');
									echo $this->loadTemplate();
								?>
							</div>
						</div>
					</div>
				<?php
				}
				?>
				</div>
				<div id="origin_toolpad_left" class="">
					<?php
					$this->setLayout('toolpad');
					echo $this->loadTemplate();
					?>
					
					<div id="toolpad_options" class="evolve-absolute">
						<div class="origin_toolpad_view">
							<div class="origin_view_default origin_toolpad_icon evolve-bg-primary" data-type="default"></div>
							<label class="evolve-ios-label"><?php echo JText::_('TOOLPAD_DEFAULT');?></label>
						</div>
						<div class="origin_toolpad_view">
							<div class="origin_view_expand origin_toolpad_icon evolve-bg-primary" data-type="expand"></div>
							<label class="evolve-ios-label"><?php echo $jtext_toolpad_expand;?></label>
						</div>
						<div class="origin_button_settings origin_toolpad_icon evolve-bg-primary"></div>
						<label class="evolve-ios-label"><?php echo JText::_('TOOLPAD_SETTINGS');?></label>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>
	<div class="evolve-hidden">
	<?php
	
		$this->setLayout('contextmenu');
		echo $this->loadTemplate();
		
		$this->setLayout('modal');
		echo $this->loadTemplate();
	?>
	</div>
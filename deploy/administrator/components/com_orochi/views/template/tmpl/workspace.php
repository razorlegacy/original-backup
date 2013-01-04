<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
    $orochiTemplate		= new orochiTemplate();
    $baseLink			= 'http://'.$_SERVER["HTTP_HOST"].'/index.php?option=com_orochi&view=display&format=raw&id='.$this->orochi->id;
?>
	<script type="text/javascript">
		$j(function() {
			emcOrochiTemplate.css($j.parseJSON('<?php echo addslashes($this->orochi->content);?>'));
			emcOrochi.groups($j.parseJSON('<?php echo addslashes($this->orochi->content);?>'));
			<?php if(!$this->orochiMenu) {?>
				//orochiWorkspace.tabs_modal_auto();
			<?php }?>
		});
		var groupObj	= new Array();
	</script>
	<div id="orochi_workspace_250_wrapper" class="orochi_workspace_wrapper inline">
		<input type="text" class="orochi-tips orochi_trafficking" value="<?php echo JRoute::_($baseLink.'&type=250');?>" readonly="readonly" title="<?php echo JText::_('TRAFFICKING_LINK_TIP');?>"/>
		<div id="orochi_workspace_250" class="orochi-shadow emcOrochi_250">
			<?php
				$type	= "250";
				$this->assignRef('menu', $this->orochiMenu);
				$this->assignRef('type', $type);
				$this->setLayout('workspace_unit');
				echo $this->loadTemplate();
			?>
		</div>
	</div>
	<div id="orochi_workspace_600_wrapper" class="orochi_workspace_wrapper inline">
		<input type="text" class="orochi-tips orochi_trafficking" value="<?php echo JRoute::_($baseLink.'&type=600');?>" readonly="readonly" title="<?php echo JText::_('TRAFFICKING_LINK_TIP');?>"/>
		<div id="orochi_workspace_600" class="orochi-shadow emcOrochi_600">
			<?php
				$type	= "600";
				$this->assignRef('menu', $this->orochiMenu);
				$this->assignRef('type', $type);
				$this->setLayout('workspace_unit');
				echo $this->loadTemplate();
			?>
		</div>
	</div>
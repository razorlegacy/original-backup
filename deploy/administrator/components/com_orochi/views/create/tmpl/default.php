<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
	
	//$config = json_decode($this->orochi->config);
	
	$this->_addPath( 'template', JPATH_COMPONENT_ADMINISTRATOR . DS . 'views' . DS . 'template' . DS . 'tmpl' );
	//$orochiModel		= &$this->getModel('syndi');
	
	$orochiTemplate				= new orochiTemplate();
	$orochiBreadcrumbs			= array("setup", "content", "config", "preview");
?>
	<script type="text/javascript">
		$j(function() {
			orochiHelp.init();
			orochiCreate.form();
			orochiLayout.init();
		});
	</script>
	<form action="index.php" method="POST" name="adminForm" id="adminForm">
		<input type="hidden" name="option" value="com_orochi"/>
		<input type="hidden" name="task" value="cancel"/>
	</form>
	
	<div id="evolve-toolbar" class="evolve-border evolve-bg-tertiary evolve-relative evolve-shadow">
		<div id="evolve-toolbar-title" class="evolve-inline"><?php echo JText::_('TOOLBAR_TITLE');?></div>
		<div id="evolve-toolbar-buttons" class="evolve-inline">
		<?php
			echo evolveUi::dialogButton('105', JText::_('TOOLBAR_HELP'), 'toolbar_help', 'evolve-bg-primary');
			echo evolveUi::dialogButton('44', JText::_('TOOLBAR_EXIT'), 'toolbar_exit', 'evolve-bg-primary');
		?>
		</div>
	</div>

	<div id="orochi" class="orochi-half">
		<input type="hidden" id="orochi_id" value="<?php echo $this->orochi->id;?>"/>
		<div id="orochi_forms" class="inline">
			<?php 
				$this->setLayout('forms');
				echo $this->loadTemplate();
			?>
		</div><!--
		--><div id="orochi_workspace" class="inline orochi-workspace-half">
			<?php 
				$this->setLayout('workspace');
				echo $this->loadTemplate();
			?>
		</div>
	</div>
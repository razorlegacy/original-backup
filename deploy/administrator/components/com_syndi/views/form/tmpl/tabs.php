<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
	
	$this->_addPath( 'template', JPATH_COMPONENT_ADMINISTRATOR . DS . 'views' . DS . 'response' . DS . 'tmpl' );
	$syndiModel			= &$this->getModel('syndi');
?>
	<script type="text/javascript">
		$j(function() {
			syndiTabs.init();
			syndiConfig.init();
		});
	</script>

	<div id="syndi_tab_add" class="">
		<div id="syndi_tab_wrapper">
			<?php
				$this->setLayout('tab_full');
				echo $this->loadTemplate();
			?>
		</div>
	</div>
	<div id="syndi_tab_preview" class="">
		<div id="syndi_preview_tab">
			<ul>
				<li><a href="#preview">Preview</a></li>
				<li class="tab-config"><a href="#config">Config</a></li>
			</ul>
			<div id="preview">
				<iframe id="syndi_iframe" src="/index.php?option=com_syndi&view=display&format=raw&sid=<?php echo $this->syndi->sid;?>" frameborder="0" width="100%" height="250px" title="/index.php?option=com_syndi&view=display&format=raw&sid=<?php echo $this->syndi->sid;?>" scrolling="no" marginheight="0" class="preview_top"></iframe>
			</div>
			<div id="config">
				<?php
				$this->setLayout('config');
				echo $this->loadTemplate();
				?>		
			</div>
		</div>
	</div>
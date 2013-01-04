<?php defined('_JEXEC') or die('Restricted access');?>
<?php
	$this->_addPath( 'template', JPATH_COMPONENT_SITE . DS . 'views' . DS . 'cartographer' . DS . 'tmpl' );
	$groupContent	= json_decode($this->groupObj->content);
?>

	<div id="emcCartographer_markers_<?php echo $this->groupObj->id;?>" class="emcCartographer_layer_marker" style="width:<?php echo $groupContent->bg_width;?>px;height:<?php echo $groupContent->bg_height;?>px;" data-id="<?php echo $this->groupObj->id;?>">
			
		<?php
			foreach($this->groupObj->marker as $key=>$value) {
			
				$this->assignRef('icon_default', $this->configObj->icon);
				$this->assignRef('icon_hover', $this->configObj->icon_hover);
			
			
				$this->assignRef('markerObj', $value);
				$this->setLayout('marker');
				echo $this->loadTemplate();
			}
		?>
	</div>
	<div id="emcCartographer_map_<?php echo $this->groupObj->id;?>" class="emcCartographer_layer_map">
		<?php
			$this->setLayout('map');
			echo $this->loadTemplate();
		?>
	</div>
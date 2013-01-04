<?php defined('_JEXEC') or die('Restricted access');?>
<?php
	$this->_addPath( 'template', JPATH_COMPONENT_SITE . DS . 'views' . DS . 'template' . DS . 'tmpl' );
	$originHelper	= new originHelper();

	foreach($this->contentObj as $keyC=>$content) {
		$contentObj		= json_decode($content->content);
		$configObj		= json_decode($content->config);
		
		//Conditional for auto-sized units
		if(!empty($contentObj->imageDefault) || !empty($contentObj->swfObject)) {
			switch($configObj->type) {
				case 'flash':
					$filename	= $contentObj->swfObject;
					break;
				case 'image':
					$filename	= $contentObj->imageDefault;
					break;
			}
			$dimensions	= getimagesize('../assets/components/com_emc_origin/'.$contentObj->oid.'/'.$filename);
			$width		= $dimensions[0];
			$height		= $dimensions[1] + 20;
			$disable	= 'origin_toolpad_disable';
		} else {
			$width		= $configObj->width;
			$height 	= $configObj->height;
			$disable	= '';
		}
			
		$zIndex			= (isset($configObj->zIndex)? $configObj->zIndex: ($content->id + 7000));
		$color			= $originHelper->originTypeColor($configObj->type);
		$style			= " style='top:{$configObj->coordY}px;left:{$configObj->coordX}px;z-index:{$zIndex};width:{$width}px;height:{$height}px'";
		
		?>
		<div class="evolve-absolute origin_toolpad_icon origin_toolpad_<?php echo $configObj->type;?> origin-bg-<?php echo $color;?> <?php echo $disable;?>"<?php echo $style;?> data-type="<?php echo $configObj->type;?>" data-id="<?php echo $content->id;?>" data-content='<?php echo $content->content;?>'>
			<div style="width:100%;height:100%;position:absolute"></div>
			<?php
			$this->assignRef('contentObj', $contentObj);
			$this->setLayout('content-'.$configObj->type);
			echo $this->loadTemplate();
			?>
		</div>
	<?php
	}
			
?>
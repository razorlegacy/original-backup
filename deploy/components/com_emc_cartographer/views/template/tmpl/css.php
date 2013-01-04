<?php defined('_JEXEC') or die('Restricted access');?>
<?php
	$document       =& JFactory::getDocument();
	$document->setMimeEncoding('text/css');

	$configObj						= json_decode($this->cartographerObj['config']->content);
	$contentObj						= $this->cartographerObj['groups'];
	$tooltipSize					= array();
	$tooltipSize['default']			= .5;
	$tooltipSize['full']			= .8;
	$tooltipSize['title']			= 50;

	echo $configObj->css;
	
	switch($configObj->tooltip_style) {
		case "craveonline":		$headerFont		= "font-family: Cantarell,Arial,sans-serif;";
								$contentFont	= "font-family: Cantarell,Arial,sans-serif;";
								break;
		default:
		case "momtastic":	
		case 'ringtv':	
		case 'superherohype':	$headerFont		= "font-family: Arial,Helvetica,sans;";
								$contentFont	= "font-family: Arial,Helvetica,sans;";
								break;
		case "thefashionspot":	
		case "wrestlezone":		$headerFont		= "font-family: Georgia,serif;";
								$contentFont	= "font-family: Arial,Helvetica,sans;";
								break;
	}
	?>
	#emcCartographer_main {
		<?php echo $contentFont;?>
	}
	.emcCartographer_tooltip {
		border: 1px solid <?php echo $configObj->popup_border_hex;?>;
		background-color: <?php echo $configObj->popup_bg_hex;?>;
		color: <?php echo $configObj->popup_text_hex;?>;
	}
	
	.emcCartographer_tooltip h1,
	.emcCartographer_tooltip h2,
	.emcCartographer_tooltip h3,
	.emcCartographer_tooltip h4,
	.emcCartographer_tooltip h5,
	.emcCartographer_tooltip h6 {
		<?php echo $headerFont;?>
		color: <?php echo $configObj->popup_title_hex;?>;
		margin: 0;
	}
	
	.emcCartographer_tooltip a {
		color: <?php echo $configObj->popup_link_hex;?>;
	}
		
	<?php
	foreach($contentObj as $group) {
		$gid			= $group->id;
		$groupHeight	= json_decode($group->content)->bg_height;
		$groupWidth		= json_decode($group->content)->bg_width;
		
		foreach($group->marker as $marker) {
			$markerId	= $marker->id;
			$marker		= json_decode($marker->content);
			
			switch($marker->tooltip_size_type) {
				case 'default':		?>
									#ui-tooltip-emcCartographer_tooltip_<?php echo $markerId;?> {
										max-width: <?php echo round($groupWidth * $tooltipSize['default']);?>px !important;
										max-height: <?php echo round($groupHeight * $tooltipSize['default']);?>px !important;
									}
									#ui-tooltip-emcCartographer_tooltip_<?php echo $markerId;?> .ui-tooltip-content {
										max-height: <?php echo round($groupHeight * $tooltipSize['default'] - $tooltipSize['title']);?>px;
									}
									<?php
									break;
				case 'full':		?>
									#ui-tooltip-emcCartographer_tooltip_<?php echo $markerId;?> {
										max-width: <?php echo round($groupWidth * $tooltipSize['full']);?>px !important;
										max-height: <?php echo round($groupHeight * $tooltipSize['full']);?>px !important;
									}
									#ui-tooltip-emcCartographer_tooltip_<?php echo $markerId;?> .ui-tooltip-content {
										max-height: <?php echo round($groupHeight * $tooltipSize['full'] - $tooltipSize['title']);?>px;
									}
									<?php
									break;
				case 'custom':		$customWidth	= ($marker->tooltip_width_value)? $marker->tooltip_width_value: $groupWidth * $tooltipSize['default'];
									$customHeight	= ($marker->tooltip_height_value)? $marker->tooltip_height_value: $groupHeight * $tooltipSize['default'];
									?>
									#ui-tooltip-emcCartographer_tooltip_<?php echo $markerId;?> {
										width: <?php echo $customWidth;?>px !important;
										height: <?php echo $customHeight + 35;?>px !important;
									}
									#ui-tooltip-emcCartographer_tooltip_<?php echo $markerId;?> .ui-tooltip-content {
										max-height: <?php echo $customHeight + 5;?>px;
									}
									<?php
									break;
			}
		}
	}
	?>

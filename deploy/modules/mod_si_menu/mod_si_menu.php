<?php defined('_JEXEC') or die('Restricted access');?>
<?php
	//Grab module config
	$menu	= $params->get('menu');

	switch($menu) {
	
		case "craveonline": 	$triggerID 		= 1024;
								$showTrigger 	= true;
								break;
								
		case "gamerevolution":	$triggerID		= 4540;
								$showTrigger	= true;
								break;
								
		default:				$showTrigger 	= false;
								break;
	}


	$add_to_head 	= &JFactory::getDocument();
	$add_to_head->addStyleSheet('/modules/mod_si_menu/tmpl/css/menu_'.$menu.'.css');
	$add_to_head->addFavicon('http://cdn.assets.craveonline.com/_favicons/'.$menu.'.ico', "image/x-icon", "shortcut icon");	
	
	if($showTrigger) {
		$trigger 	= "getTrigger({$triggerID},true);";
		$add_to_head->addScript('http://cdn.triggertag.gorillanation.com/js/triggertag.js');	
		$add_to_head->addScriptDeclaration($trigger);
	}
	
	require_once(JModuleHelper::getLayoutPath('mod_si_menu', $menu));
?>

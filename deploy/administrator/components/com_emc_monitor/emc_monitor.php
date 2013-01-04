<?php
	// no direct access
    defined( '_JEXEC' ) or die( 'Restricted access' );
	$document =& JFactory::getDocument();
	
	$document->addScript('/libraries/evolve/js/jquery/jquery1.8.0.min.js');
	$document->addScript('/libraries/evolve/js/jqueryui/jquery-ui.min.js');
	$document->addScript('/libraries/evolve/js/angularjs/angular.min.js');
	$document->addScript('/libraries/evolve/js/angularjs/angular-resource.min.js');
	$document->addScript('/libraries/evolve/js/angularui/angular-ui.min.js');
	
	$document->addScript('/libraries/evolve/js/evolve/evolveJS.js');
	
	$document->addStyleSheet('/libraries/evolve/css/angularui/angular-ui.min.css');
	
	require_once (JPATH_COMPONENT.DS."classes".DS."ga_api.php");
    require_once( JPATH_COMPONENT.DS.'monitorController.php' );
    
    $controller   = new monitorController();
    $controller->execute(JRequest::getVar('task'));
    $controller->redirect();
?>
<?php
	// no direct access
    defined( '_JEXEC' ) or die( 'Restricted access' );
	$document =& JFactory::getDocument();
	
	jimport('evolve.classes.evolveUserHelper');
	jimport('evolve.classes.evolveUi');
	jimport('evolve.classes.azureUi');
	
	//JS Files
	$document->addScript('/libraries/evolve/js/evolve/evolveJS.js');
	$document->addScript('/libraries/evolve/js/jqueryui/jquery-ui-1.9.0.min.js');
	$document->addScript('/libraries/evolve/js/jqueryui/jquery.ui.touch.min.js');
	$document->addScript('/libraries/evolve/js/angularui/angular-ui.min.js');
	$document->addScript('/libraries/evolve/js/codemirror/codemirror.js');
	$document->addScript('/libraries/evolve/js/codemirror/htmlmixed.js');
	$document->addScript('/libraries/evolve/js/codemirror/css.js');
	$document->addScript('/libraries/evolve/js/codemirror/xml.js');
	$document->addScript('/libraries/evolve/js/codemirror/javascript.js');
	
	$document->addScript('components/com_emc_origin/assets/js/origin.min.js');
	//$document->addScript('/libraries/evolve/js/ajaxFileUploader/jquery.fileupload.js');
	
	$document->addScript('/components/com_emc_origin/assets/js/origin.js');
	$document->addScript('/components/com_emc_origin/assets/js/origin-dev.js');
	
	$document->addStyleSheet('/libraries/evolve/css/angularui/angular-ui.min.css');
	$document->addStyleSheet('/libraries/evolve/css/codemirror/codemirror.css');
	$document->addStyleSheet('/libraries/evolve/css/codemirror/night.css');
	$document->addStyleSheet('components/com_emc_origin/assets/css/originAzure.css');
	
	//Frontend piggyback
	//$document->addStyleSheet('/components/com_emc_origin/assets/css/emcOrigin.css');
	
	require_once (JPATH_COMPONENT.DS."classes".DS."originHelper.class.php");
    require_once( JPATH_COMPONENT.DS.'originController.php' );
    
    $controller   = new originController();
    $controller->execute(JRequest::getVar('task'));
    $controller->redirect();
?>
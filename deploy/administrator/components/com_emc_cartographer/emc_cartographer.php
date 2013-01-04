<?php
	// no direct access
    defined( '_JEXEC' ) or die( 'Restricted access' );
	$document =& JFactory::getDocument();
	
	jimport('evolve.classes.evolveHelper');
	jimport('evolve.classes.evolveUserHelper');
	new evolveHelper;
	jimport('evolve.classes.evolveUi');
	
	//JS Files
	//$document->addScript('');
	$document->addScript('/libraries/evolve/js/jquery/jquery1.7.1.min.js');
	$document->addScript('/libraries/evolve/js/jqueryui/jquery-ui.min.js');
	$document->addScript('/libraries/evolve/js/swfObject/swfobject.js');
	
	//$document->addScript('/libraries/evolve/js/ajaxFileUploader/application.js');
	$document->addScript('/libraries/evolve/js/ajaxFileUploader/jquery.fileupload.js');
	$document->addScript('/libraries/evolve/js/ajaxFileUploader/jquery.iframe-transport.js');
	
	$document->addScript('/libraries/evolve/js/qtip/qtip.min.js');
	$document->addScript('/libraries/evolve/js/tiny_mce/tiny_mce.js');
	$document->addScript('/libraries/evolve/js/evolve/evolveJS.js');
	$document->addScript('/libraries/evolve/js/minicolors/miniColors.js');
	$document->addScript('/libraries/evolve/js/slimscroll/slimScroll.min.js');
	$document->addScript('/libraries/evolve/js/tablesorter/tablesorter.min.js');
	$document->addScript('/libraries/evolve/js/cookie/jquery.cookie.min.js');
	$document->addScript('components/com_emc_cartographer/assets/js/cartographer.js');

	//CSS Files
	//$document->addStyleSheet('');
	$document->addStyleSheet('/libraries/evolve/css/evolve/evolve-ui.css');
	$document->addStyleSheet('/libraries/evolve/css/evolve/evolve-ui-buttons.css');
	$document->addStyleSheet('/libraries/evolve/css/jqueryui/jquery.ui.base.min.css');
	$document->addStyleSheet('/libraries/evolve/css/qtip/qtip.min.css');
	$document->addStyleSheet('/libraries/evolve/css/minicolors/miniColors.css');
	$document->addStyleSheet('components/com_emc_cartographer/assets/css/cartographer.css');
	
	//Frontend Piggyback
	$document->addStyleSheet('/components/com_emc_cartographer/assets/css/emcCartographer.css');
	$document->addStyleSheet('/components/com_emc_cartographer/assets/css/emcCartographer-ie.css');
	$document->addScript('/components/com_emc_cartographer/assets/js/emcCartographer-dev.js');
	
	require_once (JPATH_COMPONENT.DS."classes".DS."cartographerTemplate.class.php");
    require_once( JPATH_COMPONENT.DS.'cartographerController.php' );
    
    $controller   = new cartographerController();
    $controller->execute(JRequest::getVar('task'));
    $controller->redirect();
?>
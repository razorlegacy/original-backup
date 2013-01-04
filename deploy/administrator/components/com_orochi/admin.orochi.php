 <?php
    // no direct access
    defined( '_JEXEC' ) or die( 'Restricted access' );

	//Load userHelper Library
	jimport('evolve.userHelper');
	jimport('evolve.classes.evolveUserHelper');
	jimport('evolve.classes.evolveUi');
	
	$document =& JFactory::getDocument();
	$document->addScript('components/com_orochi/assets/js/orochi.plugins.js');
	$document->addScript('components/com_orochi/assets/js/orochi.js');
	$document->addScript('components/com_orochi/assets/js/orochi.layout.js');
	
	//$document->addScript('/components/com_orochi/assets/orochi/js/websvc_orochi.js');
	$document->addScript('/components/com_orochi/assets/orochi/js/websvc_orochi-dev.js');
	
	$document->addScript('/libraries/evolve/js/qtip/qtip.min.js');
	$document->addScript('/libraries/evolve/js/tablesorter/tablesorter.min.js');
	$document->addScript('/libraries/evolve/js/evolve/evolveJS.js');
	$document->addScript('/libraries/evolve/assets/js/websvcHelper.js');
	$document->addScript('/libraries/evolve/assets/js/colorbox.min.js');
	$document->addScript('/libraries/evolve/assets/js/uploadify.js');
	//$document->addScript('/libraries/evolve/assets/js/plupload.full.js');
	$document->addScript('/libraries/evolve/assets/js/miniColors.js');
	
	
	$document->addStyleSheet('/libraries/evolve/css/qtip/qtip.min.css');
	$document->addStyleSheet('/libraries/evolve/css/evolve/evolve-ui.css');
	$document->addStyleSheet('/libraries/evolve/css/evolve/evolve-ui-buttons.css');
	
	$document->addStyleSheet('components/com_orochi/assets/css/orochi.css');
	$document->addStyleSheet('/components/com_orochi/assets/orochi/css/websvc_orochi.css');
	
	//$document->addStyleSheet('/libraries/evolve/assets/css/uploadify.css');
	$document->addStyleSheet('/libraries/evolve/assets/css/miniColors.css');
	$document->addStyleSheet('/libraries/evolve/assets/css/colorbox.white.css');
	$document->addStyleSheet('/libraries/evolve/assets/css/ui.icons.css');
	
	require_once (JPATH_COMPONENT.DS."classes".DS."orochiTemplate.class.php");
	
    // Require the controller
    require_once( JPATH_COMPONENT.DS.'orochiController.php' );

    // Create the controller
    $controller   = new orochiController();

    // Perform the Request task
    $controller->execute( JRequest::getVar( 'task' ) );

    // Redirect if set by the controller
    $controller->redirect();
    
    ?>
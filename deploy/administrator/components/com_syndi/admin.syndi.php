 <?php
    // no direct access
    defined( '_JEXEC' ) or die( 'Restricted access' );

	//Load userHelper Library
	jimport('evolve.userHelper');
	
	//Load userHelper Library
	jimport('evolve.evolveHelper');
	
	$document =& JFactory::getDocument();
	$document->addScript('components/com_syndi/assets/js/syndi.plugins.js');
	$document->addScript('components/com_syndi/assets/js/syndi.js');
    $document->addScript('/libraries/evolve/assets/js/uploadify.js');

	$document->addStyleSheet('/libraries/evolve/assets/css/uploadify.css');
	$document->addStyleSheet('components/com_syndi/assets/css/syndi.css');
	$document->addStyleSheet('components/com_syndi/assets/css/colorbox.css');
	$document->addStyleSheet('components/com_syndi/assets/css/flick.css');
	
	require_once (JPATH_COMPONENT.DS."classes".DS."syndiTemplate.class.php");

    // Require the controller
    require_once( JPATH_COMPONENT.DS.'syndiController.php' );

    // Create the controller
    $controller   = new SyndiController();

    // Perform the Request task
    $controller->execute( JRequest::getVar( 'task' ) );

    // Redirect if set by the controller
    $controller->redirect();
    
    ?>
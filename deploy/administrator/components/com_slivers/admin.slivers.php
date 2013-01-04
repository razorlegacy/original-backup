<?php

/**
 * Entry point for administrator part of Slivers component
 *
 *
 * @package SliversAdmin
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
// Require the controller
require_once( JPATH_COMPONENT.DS.'sliversController.php' );
// Create the controller
$controller   = new SliversController();

$auth =& JFactory::getACL();

$auth->addACL('com_slivers', 'viewAlterOtherSlivers', 'users', 'super administrator');
$auth->addACL('com_slivers', 'viewAlterOtherSlivers', 'users', 'administrator');

$document =& JFactory::getDocument();
$base = JURI::base(true).'/components/'.JRequest::getVar( 'option' ).'/';
if($document->getType() == 'html') {
	$document->addCustomTag('<!--[if lte IE 8]><link href="/administrator/components/com_slivers/css/ie.css" rel="stylesheet" type="text/css" /><![endif]-->');
}

$document->addScript('http://code.jquery.com/jquery-1.6.2.min.js');
$document->addScript('https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js');
$document->addStyleSheet($base."js/jquery-ui-1.8.9.custom/css/ui-lightness/jquery-ui-1.8.9.custom.css");


$document->addScript($base.'js/posabsolute-jQuery-Validation-Engine-f1719b5/js/languages/jquery.validationEngine-en.js');
$document->addScript($base.'js/posabsolute-jQuery-Validation-Engine-f1719b5/js/jquery.validationEngine.js');
$document->addStyleSheet($base.'js/posabsolute-jQuery-Validation-Engine-f1719b5/css/validationEngine.jquery.css');


$document->addScript($base.'js/snikch-jquery-placeholder-plugin-449e8f8/src/jquery.placeholder.js');
$document->addScript($base."js/spin.min.js");
$document->addScript($base."js/jquery.colorbox-min.js");
$document->addScript($base."js/jquery.tipTip.js");
$document->addStyleSheet($base."js/tipTip.css");

$document->addScript($base."js/slivers.js");
$document->addStyleSheet($base.'css/slivers.css');
$document->addStyleSheet($base.'css/colorbox.css');

// Perform the Request task
$controller->execute( JRequest::getVar( 'task' ) );
// Redirect if set by the controller
$controller->redirect();


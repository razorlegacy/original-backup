<?php

/**
 * Entry point for administrator part of coloring books component
 * 
 *
 * @package ColoringBooksAdmin
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
// Require the controller
require_once( JPATH_COMPONENT.DS.'coloringbooksController.php' );
// Create the controller
$controller   = new ColoringBooksController();

$auth =& JFactory::getACL();

$auth->addACL('com_coloringbooks', 'viewAlterOtherBooks', 'users', 'super administrator');
$auth->addACL('com_coloringbooks', 'viewAlterOtherBooks', 'users', 'administrator');

// Perform the Request task
$controller->execute( JRequest::getVar( 'task' ) );
// Redirect if set by the controller
$controller->redirect();
?>

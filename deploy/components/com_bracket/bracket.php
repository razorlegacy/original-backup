<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Require the controller
require_once( JPATH_COMPONENT.DS.'bracketController.php' );

// Create the controller
$controller = new BracketController();

// Perform the Request task
$controller->execute( JRequest::getVar( 'task' ) ); 

// Redirect if set by the controller
$controller->redirect();
?>
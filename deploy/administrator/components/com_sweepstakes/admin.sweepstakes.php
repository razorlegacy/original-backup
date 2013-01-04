<?php
defined('_JEXEC') or die();
$document = &JFactory::getDocument();

//Include user Helper
jimport('evolve.userHelper');
//require_once(JPATH_COMPONENT.DS."classes".DS."userHelper.class.php");


$document->addStyleSheet('components/com_sweepstakes/css/styles.css');

//Include Controller
require_once(JPATH_COMPONENT.DS."SweepstakesController.php");

//Create Controller
$controller		= new SweepstakesController();

//Request
$controller->execute(JRequest::getVar('task'));

//Redirect
$controller->redirect();

?>
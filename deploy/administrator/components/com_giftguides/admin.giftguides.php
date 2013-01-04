<?php
defined('_JEXEC') or die();
/*
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
*/

$document =& JFactory::getDocument();
$document->addStyleSheet('components'.DS.'com_giftguides'.DS.'css'.DS.'giftguides.css');

//Include user Helper
jimport('evolve.userHelper');
//require_once(JPATH_COMPONENT.DS."classes".DS."userHelper.class.php");

//Include Controller
require_once(JPATH_COMPONENT.DS."GiftGuidesController.php");

//Create Controller
$controller		= new GiftGuidesController();

//Request
$controller->execute(JRequest::getVar('task'));

//Redirect
$controller->redirect();

?>
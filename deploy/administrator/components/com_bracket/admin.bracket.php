<?php
defined('_JEXEC') or die();
$document = &JFactory::getDocument();

require_once JPATH_COMPONENT . DS . 'controller.php';

//Create Controller
$controller = new BracketController();

//Request
$controller->execute(JRequest::getVar('task'));

//Redirect
$controller->redirect();

?>
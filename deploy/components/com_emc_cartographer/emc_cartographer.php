<?php
defined('_JEXEC') or die();

$document = &JFactory::getDocument();

require_once(JPATH_COMPONENT.DS.'cartographerController.php');

$controller     = new cartographerController();
$controller->execute(JRequest::getVar('task'));
$controller->redirect();

?>
<?php
defined('_JEXEC') or die();

$document = &JFactory::getDocument();

require_once(JPATH_COMPONENT.DS.'SyndiController.php');

$controller     = new SyndiController();
$controller->execute(JRequest::getVar('task'));
$controller->redirect();

?>
<?php
defined('_JEXEC') or die();

$document = &JFactory::getDocument();

require_once(JPATH_COMPONENT.DS.'originController.php');

$controller     = new originController();
$controller->execute(JRequest::getVar('task'));
$controller->redirect();

?>
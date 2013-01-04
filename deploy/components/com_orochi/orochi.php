<?php
defined('_JEXEC') or die();

$document = &JFactory::getDocument();

require_once(JPATH_COMPONENT.DS.'OrochiController.php');

$controller     = new OrochiController();
$controller->execute(JRequest::getVar('task'));
$controller->redirect();

?>
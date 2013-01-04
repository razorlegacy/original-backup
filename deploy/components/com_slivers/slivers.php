<?php
/**
 * Entry point for public interface to slivers component
 *
 * @package Slivers
 */

defined('_JEXEC') or die();

require_once(JPATH_COMPONENT.DS.'SliversController.php');

$controller	= new SliversController();
$controller->execute(JRequest::getVar('task'));
$controller->redirect();


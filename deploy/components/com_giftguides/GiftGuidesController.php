<?php
defined('_JEXEC') or die();

jimport("joomla.application.component.controller");

class GiftGuidesController extends JController {

	function display() {
		$viewName		= JRequest::getVar('view', 'xml');
		$viewLayout		= JRequest::getVar('layout', 'default');
		$gid			= JRequest::getVar('gid', '', 'get', 'int');
		$view			=& $this->getView($viewName, 'html');
		
		//load model
		$view->setModel($this->getModel('giftguides'), true);
		
		$view->setLayout($viewLayout);
		$view->display($gid);
	}
}
?>
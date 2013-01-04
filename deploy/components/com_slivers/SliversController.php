<?php
defined('_JEXEC') or die();

jimport("joomla.application.component.controller");

/**
 * Controller for front-end interface to Slivers component
 *
 * @package Slivers
 */
class SliversController extends JController {
	function display() {
		$viewName = JRequest::getVar('view', 'api');
		$viewLayout = JRequest::getVar('layout', 'default');
		$viewType = JRequest::getVar('format', 'raw');
		$id = JRequest::getVar('id', '', 'get', 'int');
		$ct = JRequest::getVar('ct', '#', 'get');
		$da = JRequest::getVar('da', false, 'get');
		$da = $da === 'false' ? false : $da;
		$da = (bool) $da;
		$view =& $this->getView($viewName, $viewType);

		//load model
		$view->setModel($this->getModel('slivers'), true);
		$view->setModel($this->getModel('scheduledImages'));
		$view->setModel($this->getModel('videos'));
		$view->setModel($this->getModel('buttons'));

		$view->setLayout($viewLayout);
		$view->display($id,$ct,$da);
	}
}


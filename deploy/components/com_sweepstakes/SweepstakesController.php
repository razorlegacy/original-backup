<?php
defined('_JEXEC') or die();

jimport("joomla.application.component.controller");

require_once("helper/formHelper.class.php");

class SweepstakesController extends JController {	
	/**
	* Display view for sweepstake listing
	*/
	function display() {
		$viewName		= JRequest::getVar('view', 'sweepstake');
		$viewLayout		= JRequest::getVar('layout', 'default');
		$sid			= JRequest::getVar('sid', '', 'get','int');
		$view			=& $this->getView($viewName, 'html');

		//get/create model
		if($model =& $this->getModel('sweepstake')) {
			$view->setModel($model, true);
		}
		
		$view->setLayout($viewLayout);
		$view->displaySweeps($sid);
	}
	
	/**
	* Save frontend user sweepstake entry
	*/
	function entrant_save() {
		$post	= JRequest::get('post');
		$post	= (empty($post)) ? JRequest::get('get') : JRequest::get('post');
		
		$sid		= JRequest::getVar('sid');
		$json		= JRequest::getVar('jsonCB');
		
		//Sent it through the validator
		$model		=& $this->getModel('sweepstake');
		$validate	= $model->validateEntrant($post, $sid);
	
		//if validation passes, save, then respond with XML
		if(empty($validate)) {		
			$entrantID = $model->saveEntrant($sid);
			$confirmationCode = $model->getConfirmationCode($entrantID);
		}
		
		$viewLayout		= JRequest::getVar('layout', 'default');
		$view			= (empty($json)) ? $this->getView('response', 'html') : $this->getView('responsejsonp', 'html');
		
		$view->setLayout($viewLayout);
		//$view->response($validate, $sid);
		$view->response($validate, $sid, $confirmationCode);
	}	
}
?>
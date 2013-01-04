<?php

defined('_JEXEC') or die();

jimport('joomla.application.component.controller');

class SweepstakesController extends JController {

	/**
	* Controller view display
	*/
	function display() {
		
		//default view (2nd arg)
		$viewName	= JRequest::getVar('view', 'list');
		
		//Set default view layout/template
		$viewLayout	= JRequest::getVar('layout', 'listlayout');
		
		$view =& $this->getView($viewName);
		
		//Get/Create model
		if($model =& $this->getModel('sweeps')) {
			//push model into the view
			$view->setModel($model, true);
		}
		
		if($model =& $this->getModel('entrants')) {
			$view->setModel($model);
		}
		
		$view->setLayout($viewLayout);
		$view->display();
	}
	
	/**
	* Displays entrants
	*/
	function displayEntrant() {
		//$cids	= JRequest::getVar('cid', null, 'default', 'array');
		
		$sid	= JRequest::getVar('sid');
		
		if($sid == null) {
			JError::raiseError(500, 'sid parameter missing');
		}
		
		//$sid	= (int)$cids[0];
		$view	=& $this->getView('entrants');
		
		if($model =& $this->getModel('entrants')) {
			$view->setModel($model, true);
		}
		
		if($model =& $this->getModel('sweeps')) {
			$view->setModel($model);
		}
		
		$view->displayEntrantList($sid);
	}
	
/*
	function randomExcel() {
		$test	= JRequest::getVar('random', null, 'default', 'array');
		
		print_r($test);
	}
*/
	
	/**
	* Generic view displayer (WIP)
	*/
	function displayView() {
		$sid	= JRequest::getVar('sid');
		$view	= JRequest::getVar('view');
		
		if($sid	== null) {
			JError::raiseError(500, 'sid parameter missing');
		}
		
		//$view		=& $this->getView('random', 'html');
		
		if($model =& $this->getModel('entrants')) {
			$view->setModel($model, true);
		}
		
		if($model =& $this->getModel('sweeps')) {
			$view->setModel($model);
		}
				
		$view->setLayout('default');
		//$view->displayEntrantRandom($sid);
		
	}
		
	/**
	* Excel output for a given sweepstake ID
	*/
	function displayExcel() {
		$sid		= JRequest::getVar('sid');
		
		if($sid	== null) {
			JError::raiseError(500, 'sid parameter missing');
		}
		
		$view		=& $this->getView('excel', 'html');
		
		if($model =& $this->getModel('entrants')) {
			$view->setModel($model, true);
		}
		
		if($model =& $this->getModel('sweeps')) {
			$view->setModel($model);
		}
				
		$view->setLayout('default');
		$view->displayEntrantExcel($sid);
	}
	
	/**
	* Random entrant selector
	*/
	function displayRandom() {
		$sid		= JRequest::getVar('sid');
		
		if($sid	== null) {
			JError::raiseError(500, 'sid parameter missing');
		}
		
		$view		=& $this->getView('random', 'html');
		
		if($model =& $this->getModel('entrants')) {
			$view->setModel($model, true);
		}
		
		if($model =& $this->getModel('sweeps')) {
			$view->setModel($model);
		}
				
		$view->setLayout('default');
		$view->displayEntrantRandom($sid);
	}
	
	/**
	* Display Excel of current random selection
	*/
	function displayRandomExcel() {
		$arrayIDs	= JRequest::getVar('uid');
		$sid		= JRequest::getVar('sid');
		
		$view		=& $this->getView('randomexcel', 'html');
		
		if($model =& $this->getModel('entrants')) {
			$view->setModel($model, true);
		}
		
		if($model =& $this->getModel('sweeps')) {
			$view->setModel($model);
		}
				
		$view->setLayout('default');
		$view->displayRandomExcel($sid, $arrayIDs);
	}
	
	/**
	* Edit sweepstake
	*/
	function edit() {
		//getVar(PARAMETER_NAME, DEFAULT_VALUE, HASH, TYPE)
		//DEFAULT_VALUE - looks in GET, POST then FILE
		//HASH - where to read parameter from
		
		//Read cid as array
		$cids	= JRequest::getVar('cid', null, 'default', 'array');
	
		if($cids == null) {
			JError::raiseError(500, 'cid parameter missing from request');
		}
		
		//Grabs first ID
		$sweepstakesId 	= (int)$cids[0];
		
		$view	=& $this->getView('sweepstakesForm');
		
		//Get/Create model
		if($model	=& $this->getModel('sweeps')) {
			$view->setModel($model, true);
		}
		
		if($model	=& $this->getModel('entrants')) {
			$view->setModel($model);
		}
		
		$view->setLayout('sweepstakesformlayout');
		$view->displayEdit($sweepstakesId);
	}
	
	/**
	* Create new sweepstake
	*/
	function add() {
		$view	=& $this->getView('sweepstakesForm');
		$model	=& $this->getModel('sweeps');
		
		if(!$model) {
			JError::raiseError(500, 'Model named sweepstakes not found');
		}
		$view->setModel($model, true);
		$view->setLayout('sweepstakesformlayout');
		$view->displayAdd();
	}
	
	
	/**
	* Removes sweepstake and corresponding entrants
	*/
	function remove() {
		$type		= JRequest::getVar('removeType');
		$arrayIDs	= JRequest::getVar('cid', null, 'default', 'array');
			
		if($arrayIDs == null) {
			JError::raiseError(500, "id parameter missing from request");
		}
		
		switch ($type) {
		
			case "sweepstakes":	$modelSweeps	=& $this->getModel("sweeps");
								$modelSweeps->deleteSweepstake($arrayIDs);
								
								$modelEntrants	=& $this->getModel("entrants");
								$modelEntrants->deleteEntrants($arrayIDs);
								
								$redirectTo	= JRoute::_("index.php?option=".JRequest::getVar('option'));
								$this->setRedirect($redirectTo, "Sweepstake(s) removed");
								break;
								
			case "entrants":	$sid		= JRequest::getVar('sid');
								$modelEntrants	=& $this->getModel("entrants");
								$modelEntrants->deleteEntrant($arrayIDs);
								
								//Sanity check: If last entrant, kick to Sweepstakes Main Page
								if($modelEntrants->getEntrants($sid) == false) {
									$redirectTo	= JRoute::_('index.php?option='.JRequest::getVar('option'));
									$this->setRedirect($redirectTo, "Entrants(s) removed");
								} else {
									$task	= "displayEntrant";
									//&task=displayEntrant&sid=15&hidemainmenu=1
									$redirectTo	= JRoute::_('index.php?option='.JRequest::getVar('option').'&task='.$task.'&sid='.$sid, false);
									$this->setRedirect($redirectTo, "Entrants(s) removed");
								}
								break;
		
		}
	}	
	
	/**
	* Save sweepstake
	*/
	//CLEAN UP THIS FUNCTION?
	function save() {
		$sweepstake		= JRequest::get("POST", JREQUEST_ALLOWHTML);
		
		foreach($sweepstake['field']['type'] as $key=>$value) {
			$sweepstake['field']['type'][$key] = $value."_".$key;
		}
		
		//serialize field array
		$sweep_fields	= serialize($sweepstake['field']);
		
		//Remove unserialized fields
		unset($sweepstake['field']);
		
		//Push em back in
		$sweepstake['fields']	= $sweep_fields;
		
		$model			=& $this->getModel("sweeps");
		$model->saveSweepstake($sweepstake);
		
		$redirectTo		= JRoute::_("index.php?option=".JRequest::getVar('option')."&task=display", false);
		$this->setRedirect($redirectTo, "Sweepstake Updated");
	}
	
	/**
	* Joomla toolbar cancel redirect
	*/
	function cancel() {
		$redirectTo		= JRoute::_('index.php?option='.JRequest::getVar('option'));
		$this->setRedirect($redirectTo,'Cancelled');
	}
}




	/*
//CURRENTLY UNUSED
function publish() {
		$arrayIDs		= JRequest::getVar('cid', null, 'default', 'array');
		
		if($arrayIDs == null) {
			JError::raiseError(500, "cid parameter missing");
		}
		
		$model			=& $this->getModel("sweeps");
		$model->publishSweepstake($arrayIDs, 1);
		
		$redirectTo		= JRoute::_('index.php?option='.JRequest::getVar('option'));
		$this->setRedirect($redirectTo,'Publish status updated');
	}
	
	function unpublish() {
		$arrayIDs		= JRequest::getVar('cid', null, 'default', 'array');
		
		if($arrayIDs == null) {
			JError::raiseError(500, "cid parameter missing");
		}
		
		$model			=& $this->getModel("sweeps");
		$model->publishSweepstake($arrayIDs, 0);
		
		$redirectTo		= JRoute::_('index.php?option='.JRequest::getVar('option'));
		$this->setRedirect($redirectTo,'Publish status updated');
	}
*/
?>
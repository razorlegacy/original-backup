<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.view');

class OriginViewJson extends JView {

/*
    function display() {
	    $originModel		=& $this->getModel('query');
		$origin				= $originModel->getOriginRow($id);
		$originObj			= $originModel->getOriginObj($origin);
		
		$this->assignRef('originObj', $originObj);
			
		parent::display();
    }
*/

	function displayAssets($id) {
		$this->assignRef('id', $id);
		parent::display();	
	}
	
	function displayList() {
		$model 	= $this->getModel('query');
		$origin = $model->getOriginList();
		$this->assignRef('origin', $origin);
		parent::display();
	}
	
	function displayOrigin($id) {
		$model	= $this->getModel('query');
		$origin	= $model->getOrigin($id);
		$this->assignRef('origin', $origin);
		parent::display();
	}
	
	function displaySpringboard() {
		parent::display();
	}
}
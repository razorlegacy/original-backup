<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.view');

class OriginViewJson extends JView {

    function display($id) {
		$originModel		=& $this->getModel('query');
		$origin				= $originModel->getOriginRow($id);
		$originObj			= $originModel->getOriginObj($origin);
		
		$this->assignRef('originObj', $originObj);
			
		parent::display();
    }
    
    function displayJson($id) {
    	$originModel	= &$this->getModel('query');
    	$origin 		= $originModel->getOrigin($id);
    	$this->assignRef('origin', $origin);
    	parent::display();
    }
    
/*
    function displayList() {
		$model 	= $this->getModel('query');
		$origin = $model->getOrigin();
		$this->assignRef('origin', $origin);
		parent::display();
	}
*/
}
?>
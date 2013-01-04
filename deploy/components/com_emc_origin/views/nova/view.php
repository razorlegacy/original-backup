<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.view');

class OriginViewNova extends JView {

    function display($id) {
		$originModel		=& $this->getModel('query');
		$origin				= $originModel->getOriginRow($id);
		$originObj			= $originModel->getOriginObj($origin);
		
		$this->assignRef('originObj', $originObj);
			
		parent::display();
    }
}
?>
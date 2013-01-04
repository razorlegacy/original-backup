<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.view');

class OriginViewAd extends JView {

    function display($id) {
    	$originModel	= &$this->getModel('query');
    	$originConfig	= $originModel->getOriginRow($id);
    	$this->assignRef('originConfig', $originConfig);
/*
		$originModel	= &$this->getModel('query');
    	$origin 		= $originModel->getOrigin($id);
    	$this->assignRef('origin', $origin);
*/
		parent::display();
    }
}
?>
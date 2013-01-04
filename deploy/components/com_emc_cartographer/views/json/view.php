<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.view');

class CartographerViewJson extends JView {

    function display() {
		$id	= JRequest::getVar('id', null, 'default', 'int');
		
	    $cartographerModel      =& $this->getModel('query');
        $cartographer           = $cartographerModel->getCartographerRow($id);
		$cartographerObj		= $cartographerModel->getCartographerObj($cartographer);
			
        $this->assignRef('cartographerObj', $cartographerObj);
		
        parent::display();
    }
}
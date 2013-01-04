<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.view');

class CartographerViewDisplay extends JView {

    function display($id) {
		$cartographerModel       =& $this->getModel('query');
		$cartographer 				 =	$cartographerModel->getCartographerRow($id);
		$cartographerObj = $cartographerModel->getCartographerObj($cartographer);
		
		$this->assignRef('cartographerObj', $cartographerObj);
			
		parent::display();
    }
}
?>
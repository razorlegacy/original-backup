<?php
    defined( '_JEXEC' ) or die( 'Restricted access' );
    jimport( 'joomla.application.component.view');

    class CartographerViewWorkspace extends JView
    {                		
		function display() {	
			$model = $this->getModel('query');
			$cartographer = $model->getCartographer();
			
			$this->assignRef('cartographer', $cartographer);
			
           parent::display();
		}
		
		/**
        * Edits a pre-existing cartographer record
        **/
        function editCartographerDisplay($cartographer) {
			$cartographerModel       =& $this->getModel('query');
			$cartographerObj = $cartographerModel->getCartographerObj($cartographer);
			
			$this->assignRef('cartographerObj', $cartographerObj);

			parent::display();
		}
    }
?>	
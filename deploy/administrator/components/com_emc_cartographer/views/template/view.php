<?php
    defined( '_JEXEC' ) or die( 'Restricted access' );
    jimport( 'joomla.application.component.view');

    class CartographerViewTemplate extends JView
    {                		
		function display() {	
			parent::display();
		}
		
		function response($template) {
			$this->assignRef('template', $template);
			parent::display();
		}
    }
?>	
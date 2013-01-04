<?php
    defined( '_JEXEC' ) or die( 'Restricted access' );
    jimport( 'joomla.application.component.view');

    class OriginViewTemplate extends JView
    {                		
		function display() {	
			parent::display();
		}
		
		function email($post, $origin) {
			$this->assignRef('emailObj', $post);
			$this->assignRef('originObj', $origin);
			parent::display();
		}
		
		function response($template) {
			$this->assignRef('template', $template);
			parent::display();
		}
    }
?>	
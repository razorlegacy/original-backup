<?php
    defined( '_JEXEC' ) or die( 'Restricted access' );
    jimport( 'joomla.application.component.view');

    class OriginViewWorkspace extends JView
    {                		
		function display() {	
			//$model = $this->getModel('query');
			//$origin = $model->getOrigin();
			
			//$this->assignRef('origin', $origin);
			
           parent::display();
		}
		
		
		/**
		* Edit
		**/
		function editDisplay($id) {
/*
			$originModel    = &$this->getModel('query');
			$originObj 		= $originModel->getOriginObj($origin);
			
			$this->assignRef('originObj', $originObj);
*/
			$this->assignRef('id', $id);
			parent::display();
		}
		
		
		/**
        * Edits a pre-existing origin record
        **/
        function editOriginDisplay($origin) {
			$originModel       =& $this->getModel('query');
			$originObj = $originModel->getOriginObj($origin);
			
			$this->assignRef('originObj', $originObj);
//print_r($originObj);			
parent::display();
		}
    }
?>	
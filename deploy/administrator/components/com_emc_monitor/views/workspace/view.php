<?php
    defined( '_JEXEC' ) or die( 'Restricted access' );
    jimport( 'joomla.application.component.view');

    class MonitorViewWorkspace extends JView
    {                		
		function display() {
			$model = $this->getModel('query');
			$monitor = $model->getMonitor();
			
			$this->assignRef('monitor', $monitor);
			
           parent::display();
		}
		
		/*function editDisplay($monitor) {
			$model 	= $this->getModel('query');
			$monitor = $model->getCategoryData($monitor);
			
			$this->assignRef('monitor', $monitor);
			parent::display();
		}*/
		function editDisplay() {
			
			parent::display();
		}
	
    }
?>	
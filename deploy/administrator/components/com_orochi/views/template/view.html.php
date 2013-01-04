<?php
    // no direct access

    defined( '_JEXEC' ) or die( 'Restricted access' );

    jimport( 'joomla.application.component.view');


    class OrochiViewTemplate extends JView
    {                		
		function display() {	
			parent::display();
		}
		
		function refreshList($orochi) {
			$model			= & $this->getModel('orochi');
			$orochiContent	= $model->getContentGroups($orochi['id']);
			$orochiGroup	= $orochi['gid'];
			
			$this->assignRef('orochiContent', $orochiContent);
			$this->assignRef('orochiGroup', $orochiGroup);
			parent::display();
		}
    }
?>	
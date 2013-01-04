<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.view');

class OrochiViewJsonp extends JView {

    function display($id) {
           
            $orochiModel    =& $this->getModel('orochi');
            $orochi             = $orochiModel->loadOrochi($id);
			
            $this->assignRef('orochiModel', $orochiModel);
            $this->assignRef('orochi', $orochi);
			                             
            parent::display();
    }
}
?>
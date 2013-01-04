<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.view');

class OrochiViewDisplay extends JView {

    function display($id) {
    
    	$orochiModel       =& $this->getModel('orochi');
        $orochi             = $orochiModel->loadOrochi($id);
		//$orochiMenus         = $orochiModel->loadOrochiMenu($id);
       
        $this->assignRef('orochi', $orochi);
    
		parent::display();
    }
}
?>
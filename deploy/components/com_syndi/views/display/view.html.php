<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.view');

class SyndiViewDisplay extends JView {

    function display($sid) {
    
    	$syndiModel       =& $this->getModel('syndi');
        $syndi             = $syndiModel->loadSyndi($sid);
		$syndiTabs         = $syndiModel->loadSyndiTabs($sid);
       
        $this->assignRef('syndi', $syndi);
    
		parent::display();
    }
}
?>
<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.view');

class SyndiViewJsonp extends JView {

    function display($sid) {
           
            $syndiModel       =& $this->getModel('syndi');
            $syndi             = $syndiModel->loadSyndi($sid);
			$syndiTabs         = $syndiModel->loadSyndiTabs($sid);
           
            $this->assignRef('syndiModel', $syndiModel);
            $this->assignRef('syndi', $syndi);
			$this->assignRef('syndiTabs', $syndiTabs);
                                         
            parent::display();
    }
}
?>
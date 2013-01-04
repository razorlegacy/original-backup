<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.view');

class OriginViewComponents extends JView {

    function display($id, $oid, $sid) {
    	$this->assignRef('id', $id);
    	$this->assignRef('oid', $oid);
    	$this->assignRef('sid', $sid);

    	parent::display();
    }
}
?>
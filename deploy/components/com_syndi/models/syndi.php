<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class SyndiModelSyndi extends JModel {
        public $_syndiDB     = null;

        function __construct() {
                parent::__construct();
        
				$this->_syndiDB    = $this->getDBO();
        }
       
        function loadSyndi($sid) {
       
                $query          = "SELECT *
                                                FROM #__syndi
                                                WHERE sid = {$sid}";
                $this->_syndiDB->setQuery($query);
               
                return $this->_syndiDB->loadObject();
        }
        
		function loadSyndiTabs($sid) {
       
                $query          = "SELECT *
                                                FROM #__syndi_tabs
                                                WHERE sid = {$sid} 
                                                ORDER BY COALESCE(tab_order, '999999') ASC";
                $this->_syndiDB->setQuery($query);
               
                return $this->_syndiDB->loadObjectList();
        }
        
        function loadTabsJSON($sid) {
        	$query		= "SELECT * 
        					FROM #__syndi_tabs 
        					WHERE sid = '{$sid}' 
        					ORDER BY COALESCE(tab_order, '999999') ASC";
        	$this->_syndiDB->setQuery($query);
        	$tabObj		= $this->_syndiDB->loadObjectList();
        	
        	$jsonObj	= array();
        	
        	foreach($tabObj as $value) {
        		if(sizeof($this->_contentLoad($value)) > 0) {
        			$value->content		= $this->_contentLoad($value);
					array_push($jsonObj, $value);
				}
        	}
        	
        	return $jsonObj;
        }
        
        function _contentLoad($tabObj) {
        	$query		= "SELECT * 
        					FROM #__syndi_{$tabObj->typetab} 
        					WHERE tab_id = '{$tabObj->tab_id}' 
        					ORDER BY COALESCE(ordering, '999999') ASC";
        	$this->_syndiDB->setQuery($query);
        	return $this->_syndiDB->loadObjectList();
        }
}
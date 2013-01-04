<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class OrochiModelOrochi extends JModel {
        public $_orochiDB     = null;

        function __construct() {
                parent::__construct();
        
				$this->_orochiDB    = $this->getDBO();
        }
       
        function loadOrochi($id) {
       
                $query          = "SELECT *
                                                FROM #__orochi
                                                WHERE id = {$id}";
                $this->_orochiDB->setQuery($query);
               
                return $this->_orochiDB->loadObject();
        }
        
	    function loadMenuJSON($id) {
        	$query		= "SELECT * 
        					FROM #__orochi_menu
        					WHERE oid = '{$id}' 
        					ORDER BY -ordering DESC";
        	$this->_orochiDB->setQuery($query);
        	$menuObj		= $this->_orochiDB->loadObjectList();
        	
        	foreach($menuObj as $key=>$value) {
        		$mid						= $value->id;
        		$menuObj[$key]->group		= ($this->loadGroupsJSON($mid))? $this->loadGroupsJSON($mid): '';
        	}
        	
        	
        	return $menuObj;
        }	
		
		function loadGroupsJSON($mid) {
        	$query		= "SELECT * 
        					FROM #__orochi_groups
        					WHERE mid = '{$mid}' 
        					ORDER BY -ordering DESC";
        	$this->_orochiDB->setQuery($query);
        	$groupObj		= $this->_orochiDB->loadObjectList();
        	
        	foreach($groupObj as $key=>$value) {
        		$gid		= $value->id;
        		$groupObj[$key]->content	= ($this->_contentLoad($gid))? $this->_contentLoad($gid): '';
        	}
        	
        	return $groupObj;
        }

		function _contentLoad($gid) {
        	$query		= "SELECT * 
        					FROM #__orochi_content
        					WHERE gid = '{$gid}' 
        					ORDER BY -ordering DESC";
        	$this->_orochiDB->setQuery($query);
        	return $this->_orochiDB->loadObjectList();
        }		
}
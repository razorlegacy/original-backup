<?php

defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class SweepstakesModelSweeps extends JModel {

	var $_total = null;
	var $_pagination = null;

	function __construct() {
		parent::__construct();
		
        global $mainframe, $option;
        
        $filter_order     = $mainframe->getUserStateFromRequest($option.'filter_order', 'filter_order', 'id', 'cmd');
        $filter_order_Dir = $mainframe->getUserStateFromRequest($option.'filter_order_Dir', 'filter_order_Dir', 'desc', 'word');
        
        $this->setState('filter_order', $filter_order);
        $this->setState('filter_order_Dir', $filter_order_Dir);
        
         //Get User limiter (if available)
        $this->setState('showUsers', JRequest::getVar('showUsers')); 
        
        // Get pagination request variables
        $limit 		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
        $limitstart = JRequest::getVar('limitstart', 0, '', 'int');
 
        // In case limit has been changed, adjust it
        $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
 
        $this->setState('limit', $limit);
        $this->setState('limitstart', $limitstart);
	}
	
	/**
	* Base function for MySQL queries
	* @param int $sid Sweepstake ID
	* @return string Returns a query string
	*/
	function _buildQuery($uid='') {
		if(empty($uid)) {
			$query = " SELECT * FROM #__sweeps ";
		} else {
			$query = " SELECT * FROM #__sweeps WHERE author='{$uid}' ";
		}
		
        return $query;
	}

	/**
	* Pagination: returns row count
	* @param string $query Query string
	* @return int Row count
	*/
	function _getListCount($query) {
		$this->_db->setQuery($query);
		$this->_db->query();
		return $this->_db->getNumRows();
	}
	
	/**
	* Pagination: Helper for MySQL query with limits
	* @param string $query Query string
	* @param int $limitstart Limit starting value
	* @param int $limit Limit ending point
	* @return mixed Query result stored in object
	*/
	function &_getList($query, $limitstart=0, $limit=0) {
		$this->_db->setQuery($query, $limitstart, $limit);
		$result = $this->_db->loadObjectList();
		return $result;
	}
	
	/**
	* Pagination: Gets total rows from a sweepstake ID
	* @param int $sid Sweepstake ID
	* @return int Total row count
	*/
	function getTotal() {
		// Load the content if it doesn't already exist
		if (empty($this->_total)) {
			$query 			= $this->_buildQuery();
			$this->_total 	= $this->_getListCount($query);    
		}
		return $this->_total;
	}
	
	/**
	* Pagination: Creates pagination footer - Only one called directly
	* @param int $sid Sweepstakes ID
	* @return mixed Pagination footer
	*/
	function getPagination() {
		//Load the content if it doesn't already exist
		if (empty($this->_pagination)) {
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
			}
		return $this->_pagination;
	}

	/**
	* Gets a list of all sweepstakes with support for sorting
	* @return mixed Object of sweepstake listing
	*/
	function getSweeps($uid = '') {
		global $mainframe, $option;
		
		$orderby 			= '';
        $filter_order     	= $this->getState('filter_order');
        $filter_order_Dir 	= $this->getState('filter_order_Dir');

        if($uid == '' && $this->getState('showUsers') != "null") {
        	$uid			= $this->getState('showUsers');
		}
		
		if(!empty($filter_order) && !empty($filter_order_Dir) ){
                $orderby 	= ' ORDER BY '.$filter_order.' '.$filter_order_Dir;
        }
		
		$db 				= $this->getDBO();
		$db->setQuery($this->_buildQuery($uid).$orderby, $this->getState('limitstart'), $this->getState('limit'));
		
		//Loads results into array of objects
		$sweeps				= $db->loadObjectList();
		
		if($sweeps == null) {
			//JError::raiseError(500, "Error reading DB");
		} else {
			return $sweeps;
		}
	}
	
	/**
	* Loads one sweepstake
	* @param int $id sweepstake ID
	* @return object Object of sweepstake columns
	*/
	function getSweepstake($id) {
		$db		= $this->getDBO();
		$query	= "SELECT * 
					FROM #__sweeps 
					WHERE id = {$id}";
		$db->setQuery($query);
		$sweepstake	= $db->loadObject();
				
		if($sweepstake == null) {
			JError::raiseError(500, "Sweepstake ID:".$id." not found");
		} else {
			return $sweepstake;
		}
	}
	
	/**
	* Retreives fields from a sweepstake ID
	* @param int $sid sweepstake ID
	* @return array Unserialized array of fields
	*/
	function getFields($sid) {
		$db		= $this->getDBO();
		$query	= "SELECT fields 
					FROM #__sweeps 
					WHERE id='{$sid}'";
		$db->setQuery($query);
		$fields	= $db->loadObject();
		
		if($fields == null) {
			JError::raiseError(500, "Sweepstake ID:".$sid." not found");
		}
		
		return unserialize($fields->fields);
	}
	
	/**
	* Saves sweepstake (backend)
	* @param int $sweepstake sweepstake ID (provided by Joomla)
	*/
	function saveSweepstake($sweepstake) {
		$sweepsTableRow	=& $this->getTable("sweeps");
		
		if(!$sweepsTableRow->bind($sweepstake)) {
			JError::raiseError(500, "Error Binding Data");
		}
		
		//Validity check
		if(!$sweepsTableRow->check()) {
			JError::raiseError(500, "Invalid Data");
		}
		
		//Insert/update DB
		if(!$sweepsTableRow->store()) {
			$errorMessage	= $sweepsTableRow->getError();
			JError::raiseError(500, "Error Binding Data:".$errorMessage);
		}
	}
	
	/**
	* Sweepstake batch delete
	* @param array $arrayIDs array of sweepstake IDs
	*/
	function deleteSweepstake($arrayIDs) {
		$query 	= "DELETE FROM #__sweeps WHERE id IN (".implode(',', $arrayIDs).")";
		$db		= $this->getDBO();
		$db->setQuery($query);
		if(!$db->query()) {
			$errorMessage	= $this->getDBO()->getErrorMsg();
			JError::raiseError(500, "Error deleting sweepstake: ".$errorMessage);
		}
	}
	
	/**
	* UNUSED: Publish sweepstake (change flag)
	*/
	function publishSweepstake($arrayIDs, $status) {
		$sweepsTableRow	=& $this->getTable("sweeps");

		if(!$sweepsTableRow->publish($arrayIDs, $status)) {
			$errorMessage	= $sweepsTableRow->getError();
			JError::raiseError(500, $errorMessage);
		}
	}
	
	/**
	* ???
	*/
	function getNewSweepstake() {
		$sweepsTableRow	=& $this->getTable('sweeps');
		$sweepsTableRow->id	= 0;
		//Add rest of columns?
		return $sweepsTableRow;
	}
}

?>
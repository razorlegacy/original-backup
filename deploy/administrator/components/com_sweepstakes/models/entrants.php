<?php

defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class SweepstakesModelEntrants extends JModel {

	var $_total 		= null;
	var $_pagination 	= null;
	
	function __construct() {
		parent::__construct();
		
        global $mainframe, $option;
 
        // Get pagination request variables
        $limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
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
	function _buildQuery($sid) {
		$query = "SELECT * FROM #__sweeps_entrants WHERE sid='{$sid}' ORDER BY timestamp DESC";
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
	function getTotal($sid) {
		// Load the content if it doesn't already exist
		if (empty($this->_total)) {
			$query 			= $this->_buildQuery($sid);
			$this->_total 	= $this->_getListCount($query);    
		}
		return $this->_total;
	}
	
	/**
	* Pagination: Creates pagination footer - Only one called directly
	* @param int $sid Sweepstakes ID
	* @return mixed Pagination footer
	*/
	function getPagination($sid) {
		//Load the content if it doesn't already exist
		if (empty($this->_pagination)) {
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination($this->getTotal($sid), $this->getState('limitstart'), $this->getState('limit') );
		}
		return $this->_pagination;
	}
	
	/**
	* Returns entrant count for a specific sweepstake ID
	* @param int $sid Sweepstakes ID
	* @return int Entrant count number
	*/
	function getEntrantCount($sid) {
		$db		= $this->getDBO();
		$query	= "SELECT COUNT(uid) 
					FROM #__sweeps_entrants 
					WHERE sid = {$sid}";
		$db->setQuery($query);
		$entrantCnt	= $db->loadResult();
		
		return $entrantCnt;
	}

	/**
	* Gets a list of all entrants for a given sweepstake
	* @param int $sid Sweepstakes ID
	* @param bool $bypassLimit Gets results disregarding pagination limits
	* @return object Object of entrants
	*/
	function getEntrants($sid, $bypassLimit=false) {
		$db			= $this->getDBO();
		$query		= $this->_buildQuery($sid);
		
		if(!$bypassLimit) {
			$db->setQuery($query, $this->getState('limitstart'), $this->getState('limit'));
		} else {
			$db->setQuery($query);
		}
		$entrants	= $db->loadObjectList();
		
		if($entrants == null) {
			//redirect back to home with error	
			//JError::raiseError(500, "Entrants for sweepstake ID:".$sid." not found");
			return false;
		} else {
			return $entrants;
		}
	}
	
	/**
	* Gets a random selection of entrants for a given sweepstake
	* Does this by pulling an 
	*/
	function getEntrantsRandom($sid, $limit="1") {
		$db			= $this->getDBO();
		$query_id	= "SELECT uid  
						FROM #__sweeps_entrants 
						WHERE sid='{$sid}' ";
		$db->setQuery($query_id);
		$id_array	= $db->loadResultArray();
		
		//Edge Condition: user requested limit has to be within bounds
		if($limit > sizeof($id_array)) {
			$limit = sizeof($id_array);
		}
		
		$rand_array 			= array();
		$rand_array_keys		= array();
		
		//Edge condition: array_rand with one value returns value, not an array
		if($limit > 1) {
			$rand_array_keys	= array_rand($id_array, $limit);
		} else {
			$rand_array_keys	= array(array_rand($id_array, $limit));
		}
		
		//Grr.. Translate $rand_array keys to actual values
		foreach($rand_array_keys as $value) {
			array_push($rand_array, $id_array[$value]);
		}
		
		return $rand_array;
		
		/*
$query_rand	= "SELECT * 
						FROM #__sweeps_entrants 
						WHERE uid IN (".implode(',', $rand_array).")";
		$db->setQuery($query_rand);
		$rand_rows	= $db->loadObjectList();

		return $rand_rows;
*/
	}
	
	/**
	* Pulls full entrant data from ID
	* @param array $arrayIDs Array of entrant IDs
	* @return object Entrant Object
	*/
	function getEntrantsById($arrayIDs) {
		$db					= $this->getDBO();
		$query_entrant		= "SELECT * 
								FROM #__sweeps_entrants 
								WHERE uid IN (".implode(',', $arrayIDs).")";
		$db->setQuery($query_entrant);
		$entrant_rows		= $db->loadObjectList();
		
		return $entrant_rows;
	}
	
	/**
	* Batch removes entrants by sweepstake
	* @param array $arrayIDs Array of sweepstake IDs
	*/
	function deleteEntrants($arrayIDs) {
		$query	= "DELETE FROM #__sweeps_entrants WHERE sid IN (".implode(',', $arrayIDs).")";
		$db		= $this->getDBO();
		$db->setQuery($query);
		if(!$db->query()) {
			$errorMessage	= $this->getDBO()->getErrorMsg();
			JError::raiseError(500, "Error deleting entrants: ".$errorMessage);
		}
	}
	
	/**
	* Batch removes entrants by user id
	* @param array $arrayIDs Array of user IDs
	*/
	function deleteEntrant($arrayIDs) {
		$query	= "DELETE FROM #__sweeps_entrants WHERE uid IN (".implode(',', $arrayIDs).")";
		$db		= $this->getDBO();
		$db->setQuery($query);
		if(!$db->query()) {
			$errorMessage	= $this->getDBO()->getErrorMsg();
			JError::raiseError(500, "Error deleting entrants: ".$errorMessage);
		}
	}
}
?>
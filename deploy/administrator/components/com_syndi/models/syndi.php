    <?php

    //No direct acesss
    defined('_JEXEC') or die();

    jimport('joomla.application.component.model');

    class SyndiModelSyndi extends JModel {
	
			public $_syndiDB   = null;
			
			var $_total			= null;
			var $_pagination	= null;
			
			function __construct() {
				parent::__construct();
				
				$this->_syndiDB		= $this->getDBO();
				
				
				//Pagination support
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
					$query 			= $this->_buildListQuery();
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

		/*
		* Function that returns the syndi list
		* @param string $uid
		*/
		function getSyndi($uid = '') {
			$query		= "SELECT * FROM #__syndi";
			$query		.= (empty($uid)) ? "": " WHERE manager='{$uid}'";
			$query		.= " ORDER BY sid DESC";
			
			 $this->_syndiDB->setQuery($query);
		     $syndi = $this->_syndiDB->loadObjectList();
		      
		     return $syndi;
		}
           
           
		/**
		* Function that loads all tabs of a single syndi
		*/
		function loadTabs($syndiId) {
			$query		= "SELECT * 
							FROM #__syndi_tabs 
							WHERE sid = '{$syndiId}' 
							ORDER BY COALESCE(tab_order, '999999') ASC";
			$this->_syndiDB->setQuery($query);
			
			return $this->_syndiDB->loadObjectList();
		}
		
		/*
		* Function that returns the list of one single tab
		*/
		function loadListTab($type, $tabId) {
			$query		= "SELECT * 
							FROM #__syndi_{$type} 
							WHERE tab_id = '{$tabId}' 
							ORDER BY COALESCE(ordering, '999999') ASC";
			$this->_syndiDB->setQuery($query);
			
			return $this->_syndiDB->loadObjectList();
		}   
		 
		 /**
		 * Pulls an individual Syndi record
		 */
		 function getSyndiRow($id) {
     
                 $query = 'SELECT * FROM #__syndi'.
							   ' WHERE sid='.$id;
				 
				 $this->_syndiDB->setQuery($query);

                 $syndi = $this->_syndiDB->loadObject();

                if ($syndi === null)
                       JError::raiseError(500, 'Syndi with ID: '.$id.' not found.' .$query);
                else   
						return $syndi;

           }

		   
		    function deleteRow($table, $id) {
				$table	=& $this->getTable($table);
				$table->delete($id);
		   }
		   
	}
	?>
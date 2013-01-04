    <?php

    //No direct acesss
    defined('_JEXEC') or die();

    jimport('joomla.application.component.model');

    class OrochiModelOrochi extends JModel {
	
			public $_orochiDB   = null;
			
			var $_total				= null;
			var $_pagination	= null;
			
			function __construct() {
				parent::__construct();
				
				$this->_orochiDB		= $this->getDBO();
				
				
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
		/*	function _getListCount($query) {
				$this->_db->setQuery($query);
				$this->_db->query();
				return $this->_db->getNumRows();
			}*/
			
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
			* Pagination: Gets total rows from a orochi ID
			* @param int $oid orochi ID
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
			* @param int $sid orochi ID
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
		* Function that returns the orochi list
		* @param string $uid
		*/
		function getOrochi($uid = '') {
			$query		= "SELECT * FROM #__orochi";
			$query		.= (empty($uid)) ? "": " WHERE manager='{$uid}'";
			$query		.= " ORDER BY id DESC";
			
			 $this->_orochiDB->setQuery($query);
		     $orochi 		= $this->_orochiDB->loadObjectList();
		      
		     return $orochi;
		}
		
		 /**
		 * Pulls an individual Orochi record
		 *NEEDED?
		 */
		 function getOrochiRow($id) {
     
                 $query = 'SELECT * FROM #__orochi'.
							   ' WHERE id='.$id;
				 
				 $this->_orochiDB->setQuery($query);

                 $orochi = $this->_orochiDB->loadObject();

				return $orochi;

           }
		   
		/*
		* Function that returns the orochi groups/menu list
		*/
		function getOrochiGM($oId, $option) {
			$query		= "SELECT * FROM #__orochi_{$option}";
			$query		.=" WHERE oid='{$oId}'";
			$query		.= " ORDER BY -ordering DESC";
			
			 $this->_orochiDB->setQuery($query);
		     $list 		= $this->_orochiDB->loadObjectList();
		      
		     return $list;
		}
		
		/*
		* Function that returns the content list of a given id
		*/
		function getGeneric($table, $column, $id) {
			$query		= "SELECT * FROM #__orochi_{$table}";
			$query		.=" WHERE {$column}='{$id}'";
			$query		.= " ORDER BY -ordering DESC";
			
			$this->_orochiDB->setQuery($query);
		    $rows 	= $this->_orochiDB->loadObjectList();
		     
		    return $rows;
		}
	
		/*
		* Function that returns the groups with the associated content
		* NEEDED?
		*/
		function getContentGroups($oId) {
			$arGroups = array();
			$arGroup = array();
			$groups = $this->getOrochiGM($oId, 'groups');
			foreach($groups as $group) {
				$arGroup['group'] = $group;
				//$content = $this->getContent($group->id);
				$content = $this->getGeneric('content', 'gid', $group->id);
				$arGroup['content'] = $content;
				
				$arGroups[] = json_encode($arGroup);
			}
			
			return $arGroups;
		}
			
		/**
		*	Pulls all the groups of a single menu
		* NEEDED?
		*/
		function getGroupsByMenu($menuId) {
			$menu = $this->getGeneric('menu', 'id', $menuId);
			$content = json_decode($menu[content]);
			$groups = json_decode($content[groups]);
			$arGroups = array();
			foreach($groups as $key->$value) {
				$arGroups[] = $this->getGeneric('groups', 'id', $value);
			}
			return $arGroups;
		}
		
		/**
		* Pulls a menu by type (300x250 or 300x600 unit)
		* NEEDED?
		**/
		function getMenu($oid, $type) {
			$query		= "SELECT * FROM #__orochi_menu";
			$query		.= " WHERE type='{$type}'";
			$query		.= " ORDER BY ordering ASC";
			
			$this->_orochiDB->setQuery($query);
			return $this->_orochiDB->loadObjectList();
		}
		
    }
	?>
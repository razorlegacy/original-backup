    <?php

    //No direct acesss
    defined('_JEXEC') or die();

    jimport('joomla.application.component.model');

    class CartographerModelQuery extends JModel {
	
		public $_cartographerDB   = null;
			
		function __construct() {
			parent::__construct();
			
			$this->_cartographerDB		= $this->getDBO();
		}

		/*
		* Function that returns the cartographer list
		* @param string $uid
		*/
		function getCartographer() {
			$query		= "SELECT *, #__emc_cartographer.id as id FROM #__emc_cartographer";
			$query		.= " LEFT JOIN #__emc_cartographer_groups";
			$query		.= " ON #__emc_cartographer.id = #__emc_cartographer_groups.cid";
			$query		.= " GROUP BY #__emc_cartographer.id";
			$query		.= " ORDER BY #__emc_cartographer.id DESC";
			
			$this->_cartographerDB->setQuery($query);
		    $cartographer 		= $this->_cartographerDB->loadObjectList();
		      
		    return $cartographer;
		}
		
		 /**
		 * Pulls an individual Cartographer record
		 */
		 function getCartographerRow($id) {
                 $query = 'SELECT * FROM #__emc_cartographer'.
							   ' WHERE id='.$id;
	
				 $this->_cartographerDB->setQuery($query);

                 $cartographer = $this->_cartographerDB->loadObject();

				return $cartographer;

        }
		   
		/*
		* Function that returns the content list of a given id and table
		*/
		function getGeneric($table, $column, $id) {
			$query		= "SELECT * FROM #__emc_cartographer_{$table}";
			$query		.=" WHERE {$column}='{$id}'";
			$query		.= " ORDER BY -ordering DESC";
			
			$this->_cartographerDB->setQuery($query);
		    $rows 	= $this->_cartographerDB->loadObjectList();
		     
		    return $rows;
		}
		

		function getCartographerObj($cartographer){
			$json  = array(
					"config"=>$cartographer,
					"groups"=>$this->getCartographerGroups($cartographer->id)
			);
			
			return $json;
		}
		
		function getCartographerGroups($cid) {		
			$query		= "SELECT * 
							FROM #__emc_cartographer_groups 
							WHERE cid = '{$cid}' 
							ORDER BY -ordering DESC";
			$this->_cartographerDB->setQuery($query);
			$groupObj			= $this->_cartographerDB->loadObjectList();
			
			foreach($groupObj as $key=>$value) {
				$groupObj[$key]->marker		= $this->getCartographerMarkers($value->id);
			}
        	
        	return $groupObj;	
		}
		
		function getCartographerMarkers($gid) {
			$query		= "SELECT * 
        					FROM #__emc_cartographer_markers
        					WHERE gid = '{$gid}' ";
        	$this->_cartographerDB->setQuery($query);
        	$markerObj		= $this->_cartographerDB->loadObjectList();
            
        	return $markerObj;
		}
    }
	?>
<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class CartographerModelQuery extends JModel {
        public $_cartographerDB     = null;

        function __construct() {
			parent::__construct();
			$this->_cartographerDB    = $this->getDBO();
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
		
		function loadGroupJSON($cid) {
        	$query		= "SELECT * 
        					FROM #__emc_cartographer_groups
        					WHERE cid = '{$cid}' 
        					ORDER BY COALESCE(ordering, '999999') ASC";
        	$this->_cartographerDB->setQuery($query);
        	$groupObj		= $this->_cartographerDB->loadObjectList();
        	
			foreach($groupObj as $key=>$value) {
				$gid						= $value->id;
				$groupObj[$key]->marker		= ($this->loadMarkersJSON($gid))? $this->loadMarkersJSON($gid): '';
			}
        	
        	return $groupObj;
        }	
		
		function loadMarkersJSON($gid) {
        	$query		= "SELECT * 
        					FROM #__emc_cartographer_markers
        					WHERE gid = '{$gid}' ";
        	$this->_cartographerDB->setQuery($query);
        	$markerObj		= $this->_cartographerDB->loadObjectList();
            
        	return $markerObj;
        }
}
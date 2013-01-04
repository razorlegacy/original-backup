    <?php

    //No direct acesss
    defined('_JEXEC') or die();

    jimport('joomla.application.component.model');


    class CartographerModelSave extends JModel {
	
		public $_cartographerDB   = null;
		
		function __construct() {
			parent::__construct();
			
			$this->_cartographerDB		= $this->getDBO();
		}
		
		/**
		* Creates folders
		*/
		function _createAssetsFolder($id) {
			$dir	= "../assets/components/com_emc_cartographer/{$id}";
			
			if(!is_dir($dir)) {
				mkdir($dir, 0777, true);
			}
		}
		
		/**
		* this function removes a directory and its contents.
		* use with careful, no undo!
		*/
		function _removeRecursive($dir) {
		    $files = scandir($dir);
		    array_shift($files);    // remove '.' from array
		    array_shift($files);    // remove '..' from array
		    
		    foreach ($files as $file) {
		        $file = $dir . '/' . $file;
		        if (is_dir($file)) {
		            $this->_removeRecursive($file);
		            rmdir($file);
		        } else {
		            unlink($file);
		        }
		    }
		    rmdir($dir);
		}
		
		/**
	   	* Saves a cartographer
	   	*/
	   function saveCartographer($cartographer) { 
			foreach ($cartographer as $key => $value) {
				$cartographer[$key] = $value;
			}
			
			$cartographerTableRow =& $this->getTable('cartographer');
		   	$cartographerTableRow->save($cartographer);
		   
			$this->_createAssetsFolder($cartographerTableRow->id);
			
		    return $cartographerTableRow;
	   }
						
		/**
		* Generic Save Function
		*/
		function saveGeneric($post, $table) {
			$table		=& $this->getTable($table);
			$table->save($post);
		
			//Update modified_by field
			$this->saveModified_by($post['cid']);
			
			return $table->id;
		}
		
		/**
		* Updates the user who last modified the cartographer
		*/
		function saveModified_by($cid) {
			$user 		=& JFactory::getUser();	
			$cartographer['id'] = $cid;
			$cartographer['modified_by'] = $user->id;
			$cartographerTableRow =& $this->getTable('cartographer');
		   	$cartographerTableRow->save($cartographer);
		}
				
		/*
		* Deletes the content of a given id and table
		*/
		function deleteGeneric($table, $column, $id) {
			$query		= "DELETE FROM #__emc_cartographer_{$table}";
			$query		.=" WHERE {$column}='{$id}'";
			
			$this->_cartographerDB->setQuery($query);
			$this->_cartographerDB->query();
		}
		
		/*
		* Deletes a cartographer
		*/
		function deleteCartographer($id) {
			//Delete a cartographer
			$query 	= "DELETE FROM #__emc_cartographer WHERE id IN (".implode(',', $id).")";
			$this->_cartographerDB->setQuery($query);
			$this->_cartographerDB->query();
			
			foreach($id as $cid) {
				//Delete groups
				$this->deleteGeneric('groups', 'cid', $cid);
				
				//Delete markers (this is gonna change if we remove cid from markers table)
				$this->deleteGeneric('markers', 'cid', $cid);
				
				$this->_removeRecursive("../assets/components/com_emc_cartographer/{$cid}");
			}
		}
		
		/*
		* Deletes a group
		*/		
		function deleteGroup($id) {
			//Delete group
			$this->deleteRow('groups',$id);
			
			//Delete associated group markers
			$query	= "DELETE FROM #__emc_cartographer_markers WHERE gid='{$id}'";
			$this->_cartographerDB->setQuery($query);
			$this->_cartographerDB->query();
		}
		
		/**
		* Generic save ordering
		*/
		function saveOrdering($post) {
			$table		=& $this->getTable($post['type']);
			foreach($post['ordering'] as $order=>$content_id) {
				if($content_id) {
					$orderArray					= array();
					$orderArray['id']			= $content_id;
					$orderArray['ordering']	= $order + 1;
					$table->save($orderArray);
				}
			}
		 }
		
	}
    <?php

    //No direct acesss
    defined('_JEXEC') or die();

    jimport('joomla.application.component.model');


    class OrochiModelSave extends JModel {
	
		public $_orochiDB   = null;
		
		function __construct() {
			parent::__construct();
			
			$this->_orochiDB		= $this->getDBO();
		}
		
				/**
		* Creates folders
		*/
		function _createAssetsFolder($id) {
			$dir	= "../assets/components/com_orochi/{$id}";
			
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
		* Generic Save Function
		*/
		
		function saveGeneric($post, $table) {
			$table		=& $this->getTable($table);
			$table->save($post);
			
			return $table->id;
		}
				
		/**
	   	* Saves Orochi
	   	*/
	   function saveOrochi($orochi) {
			foreach ($orochi as $key => $value) {
				$orochi[$key] = $value;
				/*if($key!='config') {
					$orochi[$key] = $value;
				}*/
			}
			
			$orochiTableRow =& $this->getTable('orochi');
		   	$orochiTableRow->save($orochi);
		   
			$this->_createAssetsFolder($orochiTableRow->id);
			
		    return $orochiTableRow->id;
	   }
	   		   
	   /**
		* Generic Orochi content save function
		*/
		function saveForm($post) {
			/*foreach ($post as $key => $value) {
					$post[$key] = mysql_real_escape_string($value);
			}*/
			//$post['embed_code'] = json_encode($post['embed_code']);
			//$post = rawurldecode($post);
			//print_r($post['embed']);
			print_r($post);
			$contentTable		=& $this->getTable('content');
			$contentTable->save($post);
		}
		
		/**
	   	* Saves/Update the group list in menu
	   	*/
	   /*function saveGroupList($menuObj, $groupId) {
			//get actual group list
			$content = json_decode($menu->content);
			
			//update list
			if( !in_array($groupId,$content['groups']) ) {
				$content['groups'][] = $groupId;
				$content = json_encode($content);
				
				$query		= "UPDATE FROM #__orochi_menu";
				$query		.=" SET content={$content} WHERE id='{$menuObj->id}'";
				
				$this->_orochiDB->setQuery($query);
				$this->_orochiDB->query();
			}
		}*/
				
		/*
		* Deletes a row of a specific table
		*/		
		function deleteRow($table, $id) {
				$table	=& $this->getTable($table);
				$table->delete($id);
		}
		
		/*
		* Function that returns the content list of a given id <-????
		*/
		function deleteGeneric($table, $column, $id) {
			$query		= "DELETE FROM #__orochi_{$table}";
			$query		.=" WHERE {$column}='{$id}'";
			
			$this->_orochiDB->setQuery($query);
			$this->_orochiDB->query();
		}
		
		/*
		* Deletes an orochi
		*/
		function deleteOrochi($id) {
			//Delete orochi
			$query 	= "DELETE FROM #__orochi WHERE id IN (".implode(',', $id).")";
			
			$this->_orochiDB->setQuery($query);
			$this->_orochiDB->query();
			
			foreach($id as $oid) {
				//Delete menus
				$this->deleteGeneric('menu', 'oid', $oid);
				
				//Delete groups
				$this->deleteGeneric('groups', 'oid', $oid);
				
				//Delete content
				$this->deleteGeneric('content', 'oid', $oid);
				
				$this->_removeRecursive("../assets/components/com_orochi/{$oid}");
			}

		}
		
		/*
		* Deletes a group
		*/		
		function deleteGroup($id) {
			//Delete group
			$this->deleteRow('groups',$id);
			
			//Delete associated group contents
			$query	= "DELETE FROM #__orochi_content WHERE gid='{$id}'";
			$this->_orochiDB->setQuery($query);
			$this->_orochiDB->query();
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
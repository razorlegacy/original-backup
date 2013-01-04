    <?php

    //No direct acesss
    defined('_JEXEC') or die();

    jimport('joomla.application.component.model');


    class SyndiModelSave extends JModel {
	
		public $_syndiDB   = null;
		
		function __construct() {
			parent::__construct();
			
			$this->_syndiDB		= $this->getDBO();
		}
				
		/**
	   	* Saves Syndi  
	   	*/
	   function saveSyndi($syndi) {
			foreach ($syndi as $key => $value) {
				if($key!='config') {
					$syndi[$key] = $value;
				}
			}
					
			$syndiTableRow =& $this->getTable('syndi');
		   	$syndiTableRow->save($syndi);
		   	
		   	
		   if(!$syndi['bypass']) {
			   	$this->_createAssetsFolder($syndiTableRow->sid);
			   	
			   	if($syndi['syndi_bg']) {
			   		$filename	= basename($syndi['syndi_bg']);
			   		$temp		= "../".$syndi['syndi_bg'];
			   		$final		= "../assets/components/com_syndi/{$syndiTableRow->sid}/".$filename;
			   		rename($temp, $final);
			   	}
			   	$syndi['syndi_bg']			= $filename;
			   	$syndi['sid']				= $syndiTableRow->sid;
			   	$syndiTableRow->save($syndi);
			}		   	
		   	return $syndiTableRow->sid;
	   }
	   
	   
		/**
		* Generic Syndi save function
		*/
		function saveForm($post) {
			foreach ($post as $key => $value) {
				if($key!='twitter_config') {
					$post[$key] = $value;
				}
			}
			$syndiTable		=& $this->getTable($post['typetab']);
			$syndiTable->save($post);
		}
		
		/**
		* Generic save ordering
		*/
		function saveOrdering($post) {
			$table		=& $this->getTable($post['typetab']);
			
			foreach($post['ordering'] as $order=>$list_id) {
				$orderArray							= array();
				$orderArray[$post['typetab'].'_id']	= $list_id;
				$orderArray['ordering']				= $order + 1;
				$table->save($orderArray);
			}
		 }
		
			/**
			* New tab creation, includes folder creation
			**/						 
		 function saveTab($post) {
			foreach ($post as $key => $value) {
					$post[$key] = $value;
			}
			$table	=& $this->getTable('tabs');
			$table->save($post);
			
			$this->_createAssetsFolder($post['sid'], $table->tab_id);
			
			return $table->tab_id;
		 }
		 /*
		 * Save the new order of the tabs
		 */
		 function saveTabsOrder($post) {
			$table		=& $this->getTable('tabs');
			
			foreach($post['tab_id'] as $order=>$tab_id) {
				$orderArray					= array();
				$orderArray['tab_id']		= $tab_id;
				$orderArray['tab_order']	= $order + 1;
				
				$table->save($orderArray);
			}
		 }
		 
		 
		 /**
		 * Deletes a tab with associated records and files
		 **/
		 function deleteTab($post) {
		 //NEEDS TO DELETE ASSOCIATED RECORDS
		 	$dir		= "../assets/components/com_syndi/{$post['sid']}/{$post['tab_id']}";
		 
			$table		=& $this->getTable('tabs');
			$table->delete($post['tab_id']);
			
			//Delete associated tab records
			$query_content		= "DELETE FROM #__syndi_{$post['typetab']} 
										WHERE tab_id = '{$post['tab_id']}'";
										
			$this->_syndiDB->setQuery($query_content);
			$this->_syndiDB->query();
			
			$this->_removeRecursive($dir);
			
		 }
				 
		 function deleteSyndi($sid) {
		 	//Get relational tabs
		 	$query_tabs		= "SELECT tab_id, sid, typetab 
		 						FROM #__syndi_tabs 
		 						WHERE sid IN (".implode(',', $sid).")";
		 	$this->_syndiDB->setQuery($query_tabs);
		 	$tabsObj		= $this->_syndiDB->loadObjectList();
		 		 	
		 	//Delete primary
			$query_syndi 	= "DELETE FROM #__syndi WHERE sid IN (".implode(',', $sid).")";
			$this->_syndiDB->setQuery($query_syndi);
			$this->_syndiDB->query();


			//Delete tabs
			$query_tabs		= "DELETE FROM #__syndi_tabs WHERE sid IN (".implode(',', $sid).")";
			$this->_syndiDB->setQuery($query_tabs);
			$this->_syndiDB->query();
			
			//Delete associated tabs
			foreach($tabsObj as $value) {
				$query_content		= "DELETE FROM #__syndi_{$value->typetab} 
										WHERE tab_id = '{$value->tab_id}'";
				$this->_syndiDB->setQuery($query_content);
				$this->_syndiDB->query();
			}
			
			foreach($sid as $value) {
				$this->_removeRecursive("../assets/components/com_syndi/{$value}");
			}


         }
		 
		 
		/**
		* Creates folders
		*/
		function _createAssetsFolder($sid, $tabId = "") {
			$tabId	= !empty($tabId) ? "/{$tabId}": "";
			$dir	= "../assets/components/com_syndi/{$sid}{$tabId}";
			
			if(!is_dir($dir)) {
				mkdir($dir, 0777, true);
			}
		}
		
		/**
		* Copies product images
		*/
		function _copyAssets($sourceGid, $sourceCid, $targetGid, $targetCid) {
			$source		= "../assets/components/com_syndi/{$sourceGid}/{$sourceCid}";
			$target		= "../assets/components/com_syndi/{$targetGid}/{$targetCid}";
			
			$this->_copyRecursive($source, $target);
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
		* Recursive copy for files inside a folder
		*/
		function _copyRecursive($src, $dst) {
		    $dir = opendir($src);
		    @mkdir($dst);
		    while(false !== ( $file = readdir($dir)) ) {
		        if (( $file != '.' ) && ( $file != '..' )) {
		            if ( is_dir($src . '/' . $file) ) {
		                recurse_copy($src . '/' . $file,$dst . '/' . $file);
		            }
		            else {
		                copy($src . '/' . $file,$dst . '/' . $file);
		            }
		        }
		    }
		    closedir($dir);
		} 
			
	}
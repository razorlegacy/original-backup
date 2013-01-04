    <?php

    //No direct acesss
    defined('_JEXEC') or die();

    jimport('joomla.application.component.model');


    class OriginModelSave extends JModel {
	
		public $_originDB   = null;
		
		function __construct() {
			parent::__construct();
			
			$this->_originDB		= $this->getDBO();
		}
		
		/**
		* Creates folders
		*/
		function _createAssetsFolder($id) {
			$dir	= "../assets/components/com_emc_origin/{$id}";
			
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
		*	Copy directory from source to destination
		**/
		function copy_directory( $source, $destination ) {
			if ( is_dir( $source ) ) {
				@mkdir( $destination );
				$directory = dir( $source );
				while ( FALSE !== ( $readdirectory = $directory->read() ) ) {
					if ( $readdirectory == '.' || $readdirectory == '..' ) {
						continue;
					}
					$PathDir = $source . '/' . $readdirectory; 
					if ( is_dir( $PathDir ) ) {
						copy_directory( $PathDir, $destination . '/' . $readdirectory );
						continue;
					}
					copy( $PathDir, $destination . '/' . $readdirectory );
				}
		 
				$directory->close();
			}else {
				copy( $source, $destination );
			}
		}
		
		
		/**
	   	* Saves an origin
	   	*/
	   function saveOrigin($origin) { 
			foreach ($origin as $key => $value) {
				$origin[$key] = $value;
			}
			
			$originTableRow =& $this->getTable('origin');
		   	$originTableRow->save($origin);
			
			//Create folder
			$this->_createAssetsFolder($originTableRow->id);
			return $originTableRow;
	   }
						
		/**
		* Generic Save Function
		*/
		function saveGeneric($post, $table) {
			$table		=& $this->getTable($table);
			$table->save($post);
		
			//Update modified_by field
			$this->saveModified_by($post['oid']);
			
			return $table->id;
		}
		
		/*
		* Deletes the content of a given id and table
		*/
		function deleteGeneric($table, $column, $id) {
			$query		= "DELETE FROM #__emc_origin_{$table}";
			$query		.=" WHERE {$column}='{$id}'";
			
			$this->_originDB->setQuery($query);
			$this->_originDB->query();
		}
		
		/*
		* Deletes an origin
		*/
		function deleteOrigin($id) {
			//Delete an origin
			$query 	= "DELETE FROM #__emc_origin WHERE id IN (".implode(',', $id).")";
			$this->_originDB->setQuery($query);
			$this->_originDB->query();
			
			foreach($id as $oid) {
				//Delete schedule
				$this->deleteGeneric('schedule', 'oid', $oid);
							
				//Delete content
				$this->deleteGeneric('content', 'oid', $oid);
				
				$this->_removeRecursive("../assets/components/com_emc_origin/{$oid}");
			}
		}
		
		/**
		* Updates the user who last modified the origin
		*/
		function saveModified_by($id) {
			$user 					=& JFactory::getUser();	
			$origin['id'] 			= $id;
			$origin['modified_by'] 	= $user->id;
			$origin['modify_date']	= date('Y-m-d H:i:s');
			$originTableRow =& $this->getTable('origin');
		   	$originTableRow->save($origin);
		}
				
		function cloneContent($old_sid, $new_sid) {
			$query          = "INSERT INTO  #__emc_origin_content (oid, sid, content, config, state) 
								SELECT oid, {$new_sid}, content, config, state FROM  #__emc_origin_content
								WHERE sid = '{$old_sid}'" ;
            $this->_originDB->setQuery($query);
            $this->_originDB->query();
            return $table->id;
    	}
		
		/**
		*	Duplicate an origin
		**/
		function cloneOrigin($oid) {
			$query		= "SELECT name, config FROM  #__emc_origin
								WHERE id = '{$oid}'";
			$this->_originDB->setQuery($query);
			$data = $this->_originDB->loadRow();  
			$config = json_decode($data[1]);
			$name = $data[0]." [COPY]";
			$config->name = $config->name." [COPY]";
			$config = json_encode($config);
						
			$query          = "INSERT INTO  #__emc_origin (name, config, manager, modified_by, create_date, modify_date) 
								SELECT '{$name}', '{$config}', manager, modified_by, create_date, modify_date FROM  #__emc_origin
								WHERE id = '{$oid}'" ;
            $this->_originDB->setQuery($query);
            $this->_originDB->query();
			$new_oid = $this->_originDB->insertid();
			
			//Create folder
			$this->_createAssetsFolder($new_oid);
			//Copy all images to the new folder
			$this->copy_directory("../assets/components/com_emc_origin/{$oid}/","../assets/components/com_emc_origin/{$new_oid}/");
			
			$this->cloneSchedule($oid, $new_oid);
		}
		
		/**
		*	Clone the schedules of a specific origin
		**/
		function cloneSchedule($old_oid, $new_oid) {
			$query          = "INSERT INTO  #__emc_origin_schedule (oid, start_date, end_date) 
								SELECT {$new_oid}, start_date, end_date FROM  #__emc_origin_schedule
								WHERE oid = '{$old_oid}'" ;
			$this->_originDB->setQuery($query);
            $this->_originDB->query();
			
			$query		= "SELECT id FROM  #__emc_origin_schedule
								WHERE oid = '{$old_oid}'";
			$this->_originDB->setQuery($query);
			$old_sid = $this->_originDB->loadResultArray();  
			
			$query		= "SELECT id FROM  #__emc_origin_schedule
								WHERE oid = '{$new_oid}'";
			$this->_originDB->setQuery($query);
			$new_sid = $this->_originDB->loadResultArray();  
			
			$sid = array_combine($old_sid,$new_sid);
			
			foreach($sid as $key=>$value) {
				$this->cloneContents($new_oid, $key, $value);
			}
    	}
		
		/**
		*	Clone the contents of a specific schedule with a new origin Id
		**/
		function cloneContents($new_oid, $old_sid, $new_sid) {
			$query          = "INSERT INTO  #__emc_origin_content (oid, sid, content, config, state) 
								SELECT {$new_oid}, {$new_sid}, content, config, state FROM  #__emc_origin_content
								WHERE sid = '{$old_sid}'" ;
            $this->_originDB->setQuery($query);
            $this->_originDB->query();
			$contentId = $this->_originDB->insertid();
			
            return $contentId;
    	}
		
							
	}
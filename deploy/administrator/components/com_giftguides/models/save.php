<?php

defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class GiftGuidesModelSave extends JModel {

	public $_ggDB	= null;

	function __construct() {
		parent::__construct();
        //global $mainframe, $option;
        
        $this->_ggDB 		= $this->getDBO();
	}
	
	function _folderName($filename) {	
		return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($filename, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
		//return strtolower(str_replace(' ', '_', $filename));
	}
	
	/**
	* Creates an alias and checks existance in database and saves
	**/
	function saveAlias($table, $field, $alias, $gid, $pid) {
		
		//Sanitize alias
		$alias	= $this->_folderName($alias);
	
		$query	= "SELECT COUNT(id) as count   
					FROM #__giftguides_{$table} 
					WHERE {$field} = '{$alias}' 
					AND gid = '{$gid}'";
					
		$this->_ggDB->setQuery($query);
		
		$result	= $this->_ggDB->loadObject();
		
		if($result->count > 0) {
			$alias = $alias."_".$pid;
		} else {
			$alias = $alias;
		}
		
		//return $alias;
		//Generate associative array
		$aliasArray['id'] 		= $pid;
		$aliasArray['alias']	= $alias;
		
		$giftguideTable		=& $this->getTable($table);
		$giftguideTable->save($aliasArray);
		
	}

	/**
	* @return int Gift Guide ID
	**/
	function saveGiftGuides($post) {
		foreach ($post as $key => $value) {
			$post[$key] = mysql_real_escape_string($value);
		}
		
		//Super Banner ad tag check
		if($post['banner_option'] == 1) {
			$post['super_banner']			= '[ADTAG]';
			$post['super_banner_static']	= '[ADTAG]';
		}
						
		$giftguideTable		=& $this->getTable('giftguides');
		$giftguideTable->save($post);
		$this->_createAssetsFolder($giftguideTable->id);
		
		return $giftguideTable->id;
	}
	
	/**
	*
	**/
	function saveProduct($post) {
	
		foreach ($post as $key => $value) {
			$post[$key] = mysql_real_escape_string($value);
		}
	
		$table		=& $this->getTable('product');
		$table->save($post);
		return $table->id;
	}
	
	/**
	*
	**/
	function saveProductOrder($post) {
		//print_r($post['id']);
		//construct new order array
		
		$table		=& $this->getTable('product');
		
		foreach($post['id'] as $order=>$pid) {
			//$orderArray[$order+1]	= $pid
			$orderArray						= array();
			$orderArray['id']				= $pid;
			$orderArray['product_order']	= $order+1;
			
			$table->save($orderArray);
		}
	}
	
	/**
	*
	**/
	function deleteGeneric($primary, $table, $gid) {
		$table		=& $this->getTable($table);
		$table->delete($primary);
		
		//Delete folder/files
		switch($table) {
			case "category":	
								$this->_removeRecursive($path);	
								break;
			case "product":		
								break;
		}
		
	}
	
	/**
	*
	**/
	function deleteGiftGuide($ids) {
		//Remove Gift Guide
		$query 	= "DELETE FROM 
					#__giftguides 
					WHERE id IN (".implode(',', $ids).")";
		$this->_ggDB->setQuery($query);
			
		if(!$this->_ggDB->query()) {
			JError::raiseError(500, 'Error deleting gift guides: '.$this->_ggDB->getErrorMsg());
		}
		
		//Nuke folders
		foreach($ids as $value) {
			$dir_giftguide	= "../assets/components/com_giftguides/{$value}";
			$this->_removeRecursive($dir_giftguide);
		}
		
	}

	/**
	* Bulk remove categories
	**/
	function deleteCategoryBulk($field, $id) {
		$query	= "DELETE FROM 
					#__giftguides_category 
					WHERE {$field} IN (".implode(',', $id).")";
		$this->_ggDB->setQuery($query);
		
		if(!$this->_ggDB->query()) {
			JError::raiseError(500, 'Error deleting categories: '.$this->_ggDB->getErrorMsg());
		}
	}
	
	/**
	* Bulk remove products
	**/
	function deleteProductsBulk($field, $id) {
		$query	= "DELETE FROM 
					#__giftguides_product 
					WHERE {$field} IN (".implode(',', $id).")";
		
		$this->_ggDB->setQuery($query);
		
		if(!$this->_ggDB->query()) {
			JError::raiseError(500, 'Error deleting products: '.$this->_ggDB->getErrorMsg());
		}
	}
	
	/**
	* Save featured product
	* @return int product insert ID
	**/
	function saveFeatured($post) {
		$categoryTable		=& $this->getTable('category');
		$categoryTable->save($post);
		return $categoryTable->id;
	}
	
	/**
	* Creates new Gift Guide Category and corresponding assets folder
	* @return int Category primary key value
	*/
	function saveCategory($post) {
		//Construct category alias
		$post['alias']	= $this->_folderName($post['category_name']);
			
		foreach ($post as $key => $value) {
			$post[$key] = mysql_real_escape_string($value);
		}
	
		$categoryTable		=& $this->getTable('category');
		$categoryTable->save($post);
		
		$this->_createAssetsFolder($post['folder_name'], $categoryTable->id);
		
		return $categoryTable->id;
	}
	
	/**
	* Saves category order
	*/
	function saveCategoryOrder($post) {
		$table		=& $this->getTable('category');
		
		foreach($post['cid'] as $order=>$cid) {
			$orderArray						= array();
			$orderArray['id']				= $cid;
			$orderArray['category_order']	= $order+1;
			
			$table->save($orderArray);
		}
	}
	
	/**
	* Duplicates Gift Guide along with assets folders
	*/
	function copyGiftGuide($gid) {
		$table		=& $this->getTable('giftguides');
		$query		= "INSERT INTO #__giftguides (giftguide_name, 
													author, 
													published, 
													facebook_icon, 
													facebook_title, 
													facebook_description,
													email_title,
													email_description,
													twitter_description,
													super_banner,
													js_fadeIn,
													js_fadeOut,
													js_modal_template,
													js_modal_width,
													js_modal_height) 
						SELECT CONCAT(giftguide_name, '[COPY]'), 
								author, 
								published, 
								facebook_icon, 
								facebook_title, 
								facebook_description,
								email_title,
								email_description,
								twitter_description,
								super_banner,
								js_fadeIn,
								js_fadeOut,
								js_modal_template,
								js_modal_width,
								js_modal_height 
						FROM #__giftguides 
						WHERE id = '{$gid}'";
						
		$this->_ggDB->setQuery($query);

		if(!$this->_ggDB->query()) {
			JError::raiseError(500, 'Error(1) copying gift guide(s): '.$this->_ggDB->getErrorMsg());
		}
		$newGid	= $this->_ggDB->insertid();
		$this->_createAssetsFolder($newGid);
		
		
		//Load corresponding categories
		$queryCategory	= "SELECT * 
							FROM #__giftguides_category 
							WHERE gid = '{$gid}'";
		$this->_ggDB->setQuery($queryCategory);
		$this->_ggDB->query();
		$resultCategory	= $this->_ggDB->loadObjectList();
		
		foreach($resultCategory as $row) {
			$queryNewCategory	= "INSERT INTO 
									#__giftguides_category (gid, category_name, alias, featured, tracking_pixel, category_order) 
									VALUES ('{$newGid}', '{$row->category_name}', '{$row->alias}', '{$row->featured}', '{$row->tracking_pixel}', '{$row->category_order}')";
			$this->_ggDB->setQuery($queryNewCategory);
			$this->_ggDB->query();
			$newCid	= $this->_ggDB->insertid();
			$this->_createAssetsFolder($newGid, $newCid);
			
			//Copy new products
			$queryNewProduct	= "INSERT INTO #__giftguides_product (gid, cid, title, alias, description, price, url, img_large, product_order) 
									SELECT '{$newGid}', '{$newCid}', title, alias, description, price, url, REPLACE(img_large, '/com_giftguides/{$gid}/{$row->id}/', '/com_giftguides/{$newGid}/{$newCid}/'), product_order 
									FROM #__giftguides_product 
									WHERE cid = '{$row->id}'";
			$this->_ggDB->setQuery($queryNewProduct);
			$this->_ggDB->query();
			$this->_copyAssets($gid, $row->id, $newGid, $newCid);
		}		
	}
	
	/**
	* Creates folders
	*/
	function _createAssetsFolder($gid, $cid = '') {
		$cid	= !empty($cid) ? "/{$cid}": "";
		$dir	= "../assets/components/com_giftguides/{$gid}{$cid}";
		
		if(!is_dir($dir)) {
			mkdir($dir, 0777, true);
		}
	}
	
	/**
	* Copies product images
	*/
	function _copyAssets($sourceGid, $sourceCid, $targetGid, $targetCid) {
		$source		= "../assets/components/com_giftguides/{$sourceGid}/{$sourceCid}";
		$target		= "../assets/components/com_giftguides/{$targetGid}/{$targetCid}";
		
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
?>
<?php
//No direct acesss
defined('_JEXEC') or die();
jimport('joomla.application.component.model');
// http://valums.com/ajax-upload/
require_once (JPATH_COMPONENT.DS."classes".DS.'qquploader.php');

/**
 * Model for Coloring books. Smushes coloring book and page together into one class. 
 * Probably not ok but for now it will do.
 *
 * @package ColoringBooksAdmin
 */
class ColoringBooksModelColoringBooks extends JModel {
 private $base_file_path;
 private $base_uri =  "/assets/components/com_coloringbooks";

	/**
	* Delete a file or recursively delete a directory. Intended to be used when deleting images.
	*
	* @param string $str Path to file or directory
	* @return bool
	* @access private
	*/
	private function recursiveDelete($str){
		if(is_file($str)){
			return unlink($str);
		}
		elseif(is_dir($str)){
			$scan = glob(rtrim($str,'/').'/*');
			foreach($scan as $index=>$path){
				$this->recursiveDelete($path);
			}
			return rmdir($str);
		}
	} 
 	/**
	* Constructor
	*
	*/
	function __construct(){
		parent::__construct();
		$this->base_file_path    = JPATH_ROOT.DS."assets".DS.'components'.DS."com_coloringbooks";
		//temp
	}
 
 	/**
	* Returns an array all coloring books the user has access to as generic objects.
	*
	* @return array an array of generic coloring book objects
	*/
	function getColoringBooks(){
		$db =& $this->getDBO();
		$user =& JFactory::getUser();
		if($user->authorize('com_coloringbooks', 'viewAlterOtherBooks')){
			$db->setQuery('SELECT pc.*,u.name owner from #__com_coloringbooks pc LEFT JOIN #__users u ON u.id=pc.owner');
		}else{
			$db->setQuery('SELECT * from #__com_coloringbooks WHERE owner='.$db->getEscaped($user->id));
		}
			$coloringBooks = $db->loadObjectList();

		if ($coloringBooks === null)
			JError::raiseError(500, 'Error reading db '.$db->getErrorMsg());

		return $coloringBooks;
	}

	/**
	* Returns an array all coloring books the user has access to as generic objects.
	*
	* @param int $id id of the coloringBook
	* @return object coloring book object
	*/
	function getColoringBook($id){
		$id = intval($id);
		if($id < 1) JError::raiseError(500, "invalid book_id");
		$query = ' SELECT * FROM #__com_coloringbooks '.
							' WHERE id = '.$id;
		$db =& $this->getDBO();
		$db->setQuery($query);
		$coloringBook = $db->loadObject();          

		if ($coloringBook === null)
			JError::raiseError(500, 'coloringBook with ID: '.$id.' not found.');

		$pages = $this->getPages($id);
		//echo get_class($coloringBook);
		$prop = 'pages';
		$coloringBook->$prop = $pages;
		return $coloringBook;
	}

	/**
	* Get pages for a coloring book
	*
	* @param int $book_id id of the coloringBook
	* @return array array of page objects
	*/
	function getPages($book_id){
		$db =& $this->getDBO();

		$book_id = intval($book_id);

		$sql = "SELECT * from #__com_coloringbooks_pages WHERE book_id = %d ORDER BY COALESCE(`order`,999999) ASC";
		$sql = sprintf($sql,$book_id);

		$db->setQuery($sql);

		$pages = $db->loadObjectList();

		if ($db->getErrorNum() !== 0)
			JError::raiseError(500, 'Error reading db:'.$db->getErrorMsg().' '.$sql);
							
		return $pages;
	}
 
	/**
	* Saves the provided coloring book properties
	*
	* @param array $coloringBook hash with coloring book properties
	* @return TableColoringBooks The table object for the properties just entered
	*/
	function saveColoringBook($coloringBook){
		//Parameter not necessary because our model is named GreetingsModelGreetings (used to ilustrate that you can specify an alternative name to the JTable extending class) 
		$coloringBookTableRow =& $this->getTable('coloringBooks'); 

		$coloringBook['creator'] = JFactory::getUser()->id;
		// Insert/update this record in the db
		if (!$coloringBookTableRow->save($coloringBook)) {
			$errorMessage = $coloringBookTableRow->getError();
			JError::raiseError(500, 'Error binding data: '.$errorMessage);
		}
		//If we get here and with no raiseErrors, then everything went well
		return $coloringBookTableRow;
	}

	/**
	* returns an empty coloring book
	*
	* @return TableColoringBooks a coloringBooks Table object with default properties
	*/
	function getNewColoringBook(){
		$coloringBookTableRow =& $this->getTable('coloringBooks');
		$coloringBookTableRow->id = 0;
		$coloringBookTableRow->name = '';
		
		$prop = 'pages';
		$coloringBookTableRow->set($prop,array());
		return $coloringBookTableRow;
	}
	
	/**
	* Saves the provided coloring book properties
	*
	* @param array $arrayIDs a list of coloring book ids (int) to delete
	*/	 
	function deleteColoringBooks($arrayIDs){
		$query = "DELETE FROM #__com_coloringbooks WHERE id IN (".implode(',', $arrayIDs).")";
		$db = $this->getDBO();
		$db->setQuery($query);
		if (!$db->query()){
			$errorMessage = $this->getDBO()->getErrorMsg();
			JError::raiseError(500, 'Error deleting coloringBooks: '.$errorMessage);  
		}

// 		$query = "DELETE FROM #__com_coloringbooks_pages WHERE book_id IN (".implode(',', $arrayIDs).")";
// 		$db = $this->getDBO();
// 		$db->setQuery($query);
// 		if (!$db->query()){
// 			$errorMessage = $this->getDBO()->getErrorMsg();
// 			JError::raiseError(500, 'Error deleting coloringBooks: '.$errorMessage);  
// 		}
		
		foreach($arrayIDs as $book_id){
			if(is_dir($this->base_file_path.DS.$book_id.DS)) $this->recursiveDelete($this->base_file_path.DS.$book_id.DS);
		}
	}
	 
	/**
	* Stores an uploaded image on the hd and makes an entry in the db
	*
	* @param int $book_id The id of the coloring book to add this image to.
	* @return array $result status of the upload. Note this will almost always be success as errors will almost all be catastrophic.
	*/	 
	function savePage($book_id) {
		if(!is_int($book_id)) JError::raiseError(500,"Invalid book id");
		$savePath = $this->base_file_path.DS.$book_id.DS;
		if(!file_exists($savePath)) {
			if(!mkdir($savePath, 0755)) JError::raiseError(500,"Unable to create parent category directory");
			if(!mkdir($savePath.'thumbs'.DS, 0755)) JError::raiseError(500,"Unable to create thumbnail directory");
		}
		
		// list of valid extensions, ex. array("jpeg", "xml", "bmp")
		$allowedExtensions = array('png');
		// max file size in bytes
		$sizeLimit = 2 * 1024 * 1024;

		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
		$result = $uploader->handleUpload($savePath);
		
		if(isset($result) && array_key_exists('success',$result) && $result['success']){
		//create thumbnail from original
			$file = $savePath.$result['filename'];
			
			$width = 100;
			$height = 100;
			
			list($width_orig,$height_orig) = getimagesize($file);
			$ratio_orig = $width_orig/$height_orig;
			
			if ($width/$height > $ratio_orig) {
				$width = $height*$ratio_orig;
			} else {
				$height = $width/$ratio_orig;
			}
			
			// Resample
			$image_p = imagecreatetruecolor($width, $height);
			imagealphablending($image_p,false);
			imagesavealpha($image_p, true);
			$image = imagecreatefrompng($file);
			if(!imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig))
				JError::raiseError(500,'Error creating thumbnail');
			
				// Output
			if(!imagepng($image_p, $savePath.'thumbs'.DS.$result['filename'], 9))
				JError::raiseError(500,'Error creating thumbnail2');
			imagedestroy($image_p);
			imagedestroy($image);
		
		
			$pageTableRow =& $this->getTable('pages'); 
					 
			$page['uri'] = $result['uri'] = $this->base_uri.'/'.$book_id.'/'.$result['filename'];
			$page['uri_thumb'] = $result['uri_thumb'] = $this->base_uri.'/'.$book_id.'/thumbs/'.$result['filename'];
			$page['book_id'] = $book_id;

			if (!$pageTableRow->save($page)) 
				JError::raiseError(500, 'Error saving file information');              
			$result['id'] = $pageTableRow->id;
			
		}
		return $result;
		//If we get here and with no raiseErrors, then everything went well
	}
	
	/**
	* Updates the order property to be the order that the pages were passed in.
	*
	* @param array $pages array of page ids 
	*/
	function updatePageOrder($pages){
		$pageTableRow =& $this->getTable('pages'); 
		// if(!$pageTableRow) JError::raiseError(500,'error finding table.');

		foreach($pages as $order=>$id){
			$pagesEntries['id'] = $id;
			$pagesEntries['order'] = $order + 1;
			// Insert/update this record in the db
			if (!$pageTableRow->save($pagesEntries)) {
				$errorMessage = $pageTableRow->getError();
				JError::raiseError(500, 'Error binding data: '.$errorMessage);                           
			}
		}

		
	}
	
	/**
	* deletes a coloring book page from the db and the image/thumbnail from the hd.
	*
	* @param int $pageID
	*/
	function deletePage($pageID){
		$pageRow = $this->getTable('pages');
		$pageRow->load($pageID);
		$pathinfo = pathinfo($pageRow->uri);
		if($pageRow->delete()){
			$cbase = $this->base_file_path.DS.$pageRow->book_id.DS;
			if(unlink($cbase.$pathinfo['basename']) && unlink($cbase.'thumbs'.DS.$pathinfo['basename'])) return true;
		}
		JError::raiseError(500,"Could not delete page :".$pageRow->getError());
		
	}
	

	
}
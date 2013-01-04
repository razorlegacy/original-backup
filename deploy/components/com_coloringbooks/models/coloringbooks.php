<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

/**
 * Coloring books model
 * @package ColoringBooks 
 */

class ColoringBooksModelColoringBooks extends JModel {
	public $_db	= null;

	function __construct() {
		parent::__construct();
        $this->_db 		= $this->getDBO();
	}
	
	/**
	* Returns an array all coloring books the user has access to as generic objects.
	*
	* @param int $id id of the coloringBook
	* @return object coloring book object
	*/
	function getColoringBook($id,$fetchpages = true){
		$id = intval($id);
		if($id < 1) JError::raiseError(500, "invalid book_id");
		$query = ' SELECT * FROM #__com_coloringbooks '.
							' WHERE id = '.$id;
		$this->_db->setQuery($query);
		$coloringBook = $this->_db->loadObject();          

		if ($coloringBook === null)
			JError::raiseError(500, 'coloringBook with ID: '.$id.' not found.');
		if($fetchpages){
			$pages = $this->getPages($id);
			//echo get_class($coloringBook);
			$prop = 'pages';
			$coloringBook->$prop = $pages;
		}
		return $coloringBook;
	}

	/**
	* Get pages for a coloring book
	*
	* @param int $book_id id of the coloringBook
	* @return array array of page objects
	*/
	function getPages($book_id){

		$book_id = intval($book_id);

		$sql = "SELECT * from #__com_coloringbooks_pages WHERE book_id = %d ORDER BY COALESCE(`order`,999999) ASC";
		$sql = sprintf($sql,$book_id);

		$this->_db->setQuery($sql);

		$pages = $this->_db->loadObjectList();

		if ($this->_db->getErrorNum() !== 0)
			JError::raiseError(500, 'Error reading db:'.$this->_db->getErrorMsg().' '.$sql);
							
		return $pages;
	}
}
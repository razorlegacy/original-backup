<?php
defined('_JEXEC') or die('Restricted Access');

/**
 * Table Pages class. Represents the db version of pages - images
 *
 * @package ColoringBooksAdmin
 */
class TablePages extends JTable {
	public $id = null;
	public $uri = null;
	public $uri_thumb = null;
	public $book_id = null;
	public $order = null;

	function TablePages(&$db){
		parent::__construct('#__com_coloringbooks_pages', 'id', $db);
	}
}
?>

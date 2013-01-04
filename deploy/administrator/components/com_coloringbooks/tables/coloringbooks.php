<?php
defined('_JEXEC') or die('Restricted Access');

/**
 * Table class representing Coloring Books
 * 
 * @package    ColoringBooksAdmin
 */
class TableColoringBooks extends JTable {
	public $id = null;
	public $name = null;
	public $owner = null;
	public $embed_width = 0;
	public $embed_height = 0;
	public $swf_uri = null;
	public $email_enabled = false;

	function TableColoringBooks(&$db){
		parent::__construct('#__com_coloringbooks', 'id', $db);
	}

 /**
	* overrides the psuedo abstract check method 
	* @return bool True on valid false on invalid
	*/	
	public function check(){
		if($this->name) return true;
		return false;
	}
}
?>

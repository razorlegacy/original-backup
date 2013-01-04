<?php
defined('_JEXEC') or die();

/**
* Table: GiftGuide Category Table
* @staticvar int $id
* @staticvar int $gid
* @staticvar int $name
*/
class TableCategory extends JTable {
	//Column names for #__giftguides_category
	public $id					= null;
	public $gid					= null;
	public $category_name		= null;
	public $alias				= null;
	public $featured			= null;
	public $tracking_pixel		= null;
	public $category_order		= null;
	
	function __construct(&$db) {
		parent::__construct('#__giftguides_category', 'id', $db);
	}
}

?>
<?php
defined('_JEXEC') or die();

/**
* Table: Primary Gift Guide table
* @staticvar int $id
* @staticvar int $gid
* @staticvar int $cid
* @staticvar int $featured	
* @staticvar int $title		
* @staticvar int $alias		
* @staticvar int $description
* @staticvar int $price
* @staticvar int $url
* @staticvar int $img_large
* @staticvar int $img_thumb
*/
class TableProduct extends JTable {
	//Column names for #__giftguides_product
	public $id				= null;
	public $gid				= null;
	public $cid				= null;
	public $title			= null;
	public $alias			= null;
	public $description		= null;
	public $price			= null;
	public $url				= null;
	public $img_large		= null;
	public $product_order	= null;
	
	function __construct(&$db) {
		parent::__construct('#__giftguides_product', 'id', $db);
	}
}

?>
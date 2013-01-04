<?php
defined('_JEXEC') or die();

/**
* Table: Primary Gift Guide table
* @staticvar int $gid
* @staticvar int $name
* @staticvar int $author
* @staticvar int $published
* @staticvar int $timestamp
*/
class TableGiftGuides extends JTable {
	//Column names for #__giftguides
	public $id						= null;
	public $giftguide_name			= null;
	public $author					= null;
	public $timestamp				= null;
	public $facebook_icon			= null;
	public $facebook_title			= null;
	public $facebook_description	= null;
	public $email_header			= null;
	public $email_title				= null;
	public $email_description		= null;
	public $twitter_description		= null;
	public $super_banner			= null;
	public $super_banner_static		= null;
	public $js_fadeIn				= null;
	public $js_fadeOut				= null;
	public $js_modal_template		= null;
	public $js_modal_width			= null;
	public $js_modal_height			= null;
	public $published				= null;
	
	function __construct(&$db) {
		parent::__construct('#__giftguides', 'id', $db);
	}
}

?>
<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class GiftGuidesModelGiftGuides extends JModel {
	public $_db	= null;

	function __construct() {
		parent::__construct();
        //global $mainframe, $option;

        $this->_db 		= $this->getDBO();
	}
	
	function loadGiftGuide($gid) {
	
		$query		= "SELECT * 
						FROM #__giftguides 
						WHERE id = {$gid}";
		$this->_db->setQuery($query);
		
		return $this->_db->loadObject();
	}
	
	function loadGiftGuideCategory($gid) {
		$query 		= "SELECT * 
						FROM #__giftguides_category 
						WHERE gid = {$gid} ORDER BY COALESCE(category_order,'999999') ASC";
		$this->_db->setQuery($query);
		return $this->_db->loadObjectList();
	}
	
	function loadGiftGuideProducts($cid) {
		$query		= "SELECT * 
						FROM #__giftguides_product 
						WHERE cid = {$cid} ORDER BY COALESCE(product_order,'999999') ASC";
		$this->_db->setQuery($query);
		return $this->_db->loadObjectList();
	}
}
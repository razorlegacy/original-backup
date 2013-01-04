<?php

defined('_JEXEC') or die();

jimport('joomla.application.component.view');

require_once (JPATH_COMPONENT.DS."classes".DS."giftguideTemplate.class.php");

class GiftGuidesViewResponse extends JView {

	/**
	* XML response for frontend submission
	* @param array $validate array of pass/fail messages
	* @param int $sid sweepstake ID
	*/
	function response($response) {
		
		$gid	= $response['gid'];
		
		//Load relevant category/product data
		$giftguidesModel	= $this->getModel('giftguides');
		$category			= $giftguidesModel->getCategory($gid);
		
		$this->assignRef('category', $category);
		$this->assignRef('giftguidesModel', $giftguidesModel);
		parent::display();
	}
}

?>
<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.view');

class GiftGuidesViewXml extends JView {

	function display($gid) {
		
		$giftguidesModel	=& $this->getModel('giftguides');
		$giftguide			= $giftguidesModel->loadGiftGuide($gid);
		$giftguideCategory	= $giftguidesModel->loadGiftGuideCategory($gid);
		
		//$giftguideProduct	= $giftguidesModel->loadGiftGuideProducts($gid);
		
		$this->assignRef('giftguidesModel', $giftguidesModel);
		$this->assignRef('giftguide', $giftguide);
		$this->assignRef('category', $giftguideCategory);
				
		parent::display();
	}
}
?>
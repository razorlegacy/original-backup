<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.view');

class GiftGuidesViewList extends JView {

	function display() {
		$userObj		= new userHelper();
		$minACL			= 1;
		
		if($userObj->checkACL($minACL)) {
			$uid		= '';
		} else {
			$uid		= $userObj->_userId;
		}
		
		JToolBarHelper::title('Gift Guide Manager', 'generic.png');
		JToolBarHelper::addNewX('createGiftGuide', 'Create Gift Guide');
		JToolBarHelper::custom('copyGiftGuide', 'copy.png', 'copy.png', 'Copy Gift Guide', false, false );
		JToolBarHelper::deleteList('', 'deleteGiftGuide', 'Delete Gift Guide');
		
		$giftguidesModel	= $this->getModel('giftguides');
		$giftguides			= $giftguidesModel->getGiftGuideList($uid);
		$this->assignRef('giftguides', $giftguides);
		
		//State object for table sort
		$state				=& $this->get('state');
		$lists['order_Dir']	= $state->get('filter_order_Dir');
		$lists['order']		= $state->get('filter_order');
		$showUsers			= $state->get('showUsers');
		
		$this->assignRef('lists', $lists);
		
		$pagination			= $giftguidesModel->getPagination();
		$this->assignRef('pagination', $pagination);
		$this->assignRef('user', $userObj);
		$this->assignRef('minACL', $minACL);
		$this->assignRef('showUsers', $showUsers);
		parent::display();
	}
}
?>
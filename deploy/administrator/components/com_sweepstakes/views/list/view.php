<?php
//Not called view.html.php b/c getView method in controller is used w/o specifying second parameter (view type)
defined('_JEXEC') or die();

jimport("joomla.application.component.view");

class SweepstakesViewList extends JView {

	/**
	* View: display a listing of sweepstakes
	*/
	function display() {
		$userObj	= new userHelper();
		$minACL		= 1;
		
		if($userObj->checkACL($minACL)) {
			$uid	= '';
		} else {			
			$uid	= $userObj->_userId;
		}

		JToolBarHelper::title('Sweepstakes Manager', 'generic.png');
		JToolBarHelper::deleteList();
		JToolBarHelper::addNewX();
		
		$sweepsModel	= $this->getModel('sweeps');
		$sweeps			= $sweepsModel->getSweeps($uid);
		$this->assignRef('sweeps', $sweeps);
		
		//State object for table sort
		$state 				=& $this->get('state');
		$lists['order_Dir'] = $state->get('filter_order_Dir');
		$lists['order']     = $state->get('filter_order');
		$showUsers			= $state->get('showUsers');
		
 		$this->assignRef('lists', $lists );
 		
		$pagination		= $sweepsModel->getPagination();
		$this->assignRef('pagination', $pagination);
		$this->assignRef('user', $userObj);
		$this->assignRef('minACL', $minACL);
		$this->assignRef('showUsers', $showUsers);
				
		parent::display();
	}
}
?>
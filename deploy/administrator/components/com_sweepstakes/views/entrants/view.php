<?php
//Not called view.html.php b/c getView method in controller is used w/o specifying second parameter (view type)
defined('_JEXEC') or die();

jimport("joomla.application.component.view");

class SweepstakesViewEntrants extends JView {

	/**
	* View: Display entrant listing based on sweepstake ID
	* @param int $sid Sweepstake ID
	*/
	function displayEntrantList($sid) {
		JToolBarHelper::title('Entrants Manager', 'generic.png');
		JToolBarHelper::cancel();
		JToolBarHelper::deleteList();		
		
		$entrantsModel	= $this->getModel('entrants');
		$entrants		= $entrantsModel->getEntrants($sid);
		$this->assignRef('entrants', $entrants);
		
		if (!$entrants) {
			return FALSE;
		}
		
		$pagination		= $entrantsModel->getPagination($sid);
		$this->assignRef('pagination', $pagination );
		$this->assignRef('sid', $sid);
		
		parent::display();
	}
}
?>
<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.view');
require_once (JPATH_COMPONENT.DS."classes".DS."entrantList.class.php");

class SweepstakesViewRandom extends JView {

	/**
	* View: Display interface to select random entrants from a sweepstake
	*/
	function displayEntrantRandom($sid) {
			
		$sweepsModel	= $this->getModel('sweeps');
		$fields			= $sweepsModel->getFields($sid);
		$sweeps			= $sweepsModel->getSweepstake($sid);
		$random_value	= JRequest::getVar('random_value');
		$entrantsModel	= $this->getModel('entrants');
		
		if(!empty($random_value)) {
			$limit		= $random_value;
			$entrantIds	= $entrantsModel->getEntrantsRandom($sid, $limit);
			$entrants	= $entrantsModel->getEntrantsById($entrantIds);
		} else {
			$entrants	= '';
		}
						
		$this->assignRef('sweeps', $sweeps);
		$this->assignRef('fields', $fields);
		$this->assignRef('entrantIds', $entrantIds);
		$this->assignRef('entrants', $entrants);		
		$this->assignRef('sid', $sid);
		$this->assignRef('random_value', $random_value);
		
		JToolBarHelper::title('Entrants Randomizer - '.$sweeps->name, 'generic.png');	
		JToolBarHelper::cancel();

		
		parent::display();
	}
}

?>
<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.view');

class SweepstakesViewExcel extends JView {

	/**
	* View: Display an Excel formated page for downloading entrant data
	*/
	function displayEntrantExcel($sid) {
		$sweepsModel	= $this->getModel('sweeps');
		$fields			= $sweepsModel->getFields($sid);
		$sweeps			= $sweepsModel->getSweepstake($sid);
		
		$entrantsModel	= $this->getModel('entrants');
		$entrants		= $entrantsModel->getEntrants($sid, true);
		
		$this->assignRef('sweeps', $sweeps);
		$this->assignRef('fields', $fields);
		$this->assignRef('entrants', $entrants);		
		$this->assignRef('sid', $sid);
		
		parent::display();

	}
}

?>
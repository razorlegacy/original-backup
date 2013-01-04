<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.view');

class SweepstakesViewRandomexcel extends JView {

	/**
	* View: Display an Excel formated page for downloading entrant data
	*/
	function displayRandomExcel($sid, $arrayIDs) {
	
		$sweepsModel	= $this->getModel('sweeps');
		$fields			= $sweepsModel->getFields($sid);
		$sweeps			= $sweepsModel->getSweepstake($sid);
		
		$entrantsModel	= $this->getModel('entrants');
		$entrantIds		= unserialize($arrayIDs);
		$entrants		= $entrantsModel->getEntrantsById($entrantIds);
		
		$this->assignRef('sweeps', $sweeps);
		$this->assignRef('fields', $fields);
		$this->assignRef('entrants', $entrants);		
		$this->assignRef('sid', $sid);
		
		parent::display();

	}
}

?>
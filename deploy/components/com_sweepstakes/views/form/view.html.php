<?php

defined('_JEXEC') or die();

jimport('joomla.application.component.view');

class SweepstakesViewForm extends JView {
	/**
	* loads sweepstake model from sweepstake ID
	* @param int $sid sweepstake ID
	*/
	function displaySweeps($sid) {
		$model			=& $this->getModel();
		$sweepstake		= $model->getSweepstake($sid);
		$this->assignRef('sweepstake', $sweepstake);
		parent::display();
	}
	
}

?>
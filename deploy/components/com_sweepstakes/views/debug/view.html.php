<?php

defined('_JEXEC') or die();

jimport('joomla.application.component.view');

class SweepstakesViewDebug extends JView {

	/**
	* Debug
	*/
	function displaySweeps() {
		$model			=& $this->getModel('sweepstake');
		$sweepstakes	= $model->getSweepstakes();
		$this->assignRef('sweepstakes', $sweepstakes);
		parent::display();
	}
}

?>
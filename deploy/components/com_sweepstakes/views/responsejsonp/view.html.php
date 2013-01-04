<?php

defined('_JEXEC') or die();

jimport('joomla.application.component.view');

class SweepstakesViewResponsejsonp extends JView {

	/**
	* XML response for frontend submission
	* @param array $validate array of pass/fail messages
	* @param int $sid sweepstake ID
	*/
	function response($validate, $sid, $confirmationCode) {
		$this->assignRef('validate', $validate);
		$this->assignRef('sid', $sid);
		parent::display();
	}
	
}

?>
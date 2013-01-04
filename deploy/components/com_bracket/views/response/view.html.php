<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
/**
 * HTML View class for the Bracket Component Votes
 *
 */
class BracketViewResponse extends JView {
	function display($period, $voted, $rival) {    	
		$bracketModel	 	= &$this->getModel();
		$voteResponse		= $bracketModel->updateVotes($period, $voted, $rival);
		$this->assignRef('voteResponse', $voteResponse);		
    	parent::display();
    }
}

?>
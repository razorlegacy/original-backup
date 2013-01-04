<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
/**
 * HTML View class for the Bracket Component config xml
 *
 */
class BracketViewXML extends JView
{
             
    function display($cid) {
    	$bracketModel	 	= &$this->getModel();
    	$bracketInfo			= $bracketModel->getBracketInfo($cid);
    	$bracketDates		= $bracketModel->getBracketDates($cid);
    	$bracketEntries		= $bracketModel->getBracketEntries($cid);
    	$bracketVotes		= $bracketModel->getBracketVotes($cid);
    	
    	$this->assignRef('bracketModel', $bracketModel);
    	$this->assignRef('bracketInfo', $bracketInfo);
    	$this->assignRef('bracketDates', $bracketDates);
    	$this->assignRef('bracketEntries', $bracketEntries);
    	$this->assignRef('bracketVotes', $bracketVotes);
    	
    	parent::display();
    }
}
?>
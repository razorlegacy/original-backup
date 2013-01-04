<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');
/**
 * Bracket Component Controller
 */
class BracketController extends JController
{

    /**
     * Method to display the view
     *
     * @access    public
     */
    function display() {
        $viewName		= JRequest::getVar('view', 'xml');
        $viewLayout		= JRequest::getVar('layout', 'default');
        $cid					= JRequest::getVar('cid');
		$view				=& $this->getView($viewName, 'html');
		$view->setModel($this->getModel('bracket'), true);
		$view->setLayout($viewLayout);
		$view->display($cid);
    }
    
    function recordVotes() {
		$period 			= JRequest::getVar('period');
    	$voted 				= JRequest::getVar('voted');
		$rival 				= JRequest::getVar('rival');
		$viewName		= JRequest::getVar('view', 'response');
        $viewLayout		= JRequest::getVar('layout', 'default');
    	$view				=& $this->getView('response','html');
    	$view->setModel($this->getModel('votes'), true);
    	$view->setLayout($viewLayout);
    	$view->display($period, $voted, $rival);
    }
}
?>
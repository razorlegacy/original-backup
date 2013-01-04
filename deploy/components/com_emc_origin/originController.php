<?php
defined('_JEXEC') or die();

jimport("joomla.application.component.controller");

class originController extends JController {

    function display() {
	    $viewName			= JRequest::getVar('view');
        $viewLayout			= JRequest::getVar('layout', 'default');
        $id					= JRequest::getVar('id', '', 'get', 'int');
        $date				= JRequest::getVar('date', '');
		$view				=& $this->getView($viewName);
       
        //load model
        $view->setModel($this->getModel('query'), true);
       
        $view->setLayout($viewLayout);
        $view->display($id, $date);
    }
    
    function json() {
    	$document 	= &JFactory::getDocument();
        $document 	= JDocument::getInstance('raw');
        $document->setMimeEncoding('application/json');
        
        $view 	= &$this->getView('json');
        $id		= JRequest::getVar('id');
        
        $view->setModel($this->getModel('query'));
        
        $view->setLayout('default');
    	$view->displayJson($id);
    }
    
    function ad() {
	    $document	= &JFactory::getDocument();
	    $document	= JDocument::getInstance('raw');
	    
	    $view 		= &$this->getView('ad');
	    $id			= JRequest::getVar('id');
	    
	    $view->setModel($this->getModel('query'));
	    $view->setLayout('ad');
	    $view->display($id);
    }
    
    function content() {
	    $document	= &JFactory::getDocument();
	    $document	= JDocument::getInstance('raw');
	    
	    $template	= JRequest::getVar('template');
	    $id			= JRequest::getVar('id');
	    $oid		= JRequest::getVar('oid');
	    $sid		= JRequest::getVar('sid');
	    
	    $view 		= &$this->getView('components');
	    $view->setLayout($template);
	    $view->display($id, $oid, $sid);
    }
}
?>
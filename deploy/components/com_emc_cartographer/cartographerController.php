<?php
defined('_JEXEC') or die();

jimport("joomla.application.component.controller");

class cartographerController extends JController {

        function display() {
		    $viewName          = JRequest::getVar('view', 'display');
            $viewLayout         = JRequest::getVar('layout', 'default');
            $id                     	= JRequest::getVar('id', '', 'get', 'int');
            $view                   =& $this->getView($viewName);
           
            //load model
            $view->setModel($this->getModel('query'), true);
           
            $view->setLayout($viewLayout);
            $view->display($id);
        }
}
?>
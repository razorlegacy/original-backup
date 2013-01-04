<?php
defined('_JEXEC') or die();

jimport("joomla.application.component.controller");

class OrochiController extends JController {

        function display() {
            $viewName          = JRequest::getVar('view', 'jsonp');
            $viewLayout         = JRequest::getVar('layout', 'default');
            $id                     	= JRequest::getVar('id', '', 'get', 'int');
            $view                   =& $this->getView($viewName, 'html');
           
            //load model
            $view->setModel($this->getModel('orochi'), true);
           
            $view->setLayout($viewLayout);
            $view->display($id);
        }
}
?>
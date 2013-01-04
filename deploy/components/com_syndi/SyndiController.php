<?php
defined('_JEXEC') or die();

jimport("joomla.application.component.controller");

class SyndiController extends JController {

        function display() {
            $viewName          = JRequest::getVar('view', 'jsonp');
            $viewLayout         = JRequest::getVar('layout', 'default');
            $sid                     = JRequest::getVar('sid', '', 'get', 'int');
            $view                   =& $this->getView($viewName, 'html');
           
            //load model
            $view->setModel($this->getModel('syndi'), true);
           
            $view->setLayout($viewLayout);
            $view->display($sid);
        }
}
?>
<?php
    defined( '_JEXEC' ) or die( 'Restricted access' );
    jimport('joomla.application.component.controller');
    
    class monitorController extends JController {
		
		function display() {
			$view = & $this->getView('workspace');
			$view->setModel($this->getModel('query'), true);
			$view->setLayout("list");
			$view->display();
		}
		
		function getdata() {
			//Setup
        	//$originHelper = new originHelper();
        	/*$document 	= &JFactory::getDocument();
            $doc 		= &JDocument::getInstance('raw');
            $document 	= $doc;
            */
            //Get data
            $data				= json_decode(file_get_contents('php://input'))->data;
			$record['start_date'] = date('Y-m-d', strtotime($data->start_date));
			$record['end_date'] = date('Y-m-d', strtotime($data->end_date));
        	$record['category'] = $data->category;
			
        	$model		= &$this->getModel('query');
			$monitor 	= json_decode($model->pullCategoriesData(false, $record['start_date'],$record['end_date'],false,$record['category']));
			//echo $monitor;
			$document 	= &JFactory::getDocument();
            $doc 		= &JDocument::getInstance('raw');
            $document 	= $doc;
            $document->setMimeEncoding('application/json');
           
        
        	$view =& $this->getView('json');
			$view->setLayout('list');
			//echo $monitor;
	        $view->displayDataUp($monitor);
			
        }
		
		function getCategoryData() {
			/*$start_date = JRequest::getVar('start_date');
			$record['start_date'] = date('Y-m-d', strtotime('2012-10-01T07:00:00.000Z'));
			$record['end_date'] = date('Y-m-d', strtotime('2012-10-05T07:00:00.000Z'));
			$record['category'] = JRequest::getVar('category');
			$record['dimensions'] = 'ga:eventCategory,ga:eventAction';
			*/
			//$model		= &$this->getModel('query');
			//$monitor 	= json_decode($model->pullCategoriesData($record['dimensions'], $record['start_date'],$record['end_date'],false,$record['category']));
			
			$view = &$this->getView('workspace');                   
			//$view->setModel($this->getModel('query'), true);
			$view->setLayout('edit');
			
			$view->editDisplay();
        }
		
		/**
        * List of all category events
        **/
        function jsonlist() {
        	$document 	= &JFactory::getDocument();
            $doc 		= &JDocument::getInstance('raw');
            $document 	= $doc;
            $document->setMimeEncoding('application/json');
           
        
        	$view =& $this->getView('json');
        	$view->setModel($this->getModel('query'), true);
	        $view->setLayout('list');
	        $view->displayData();
        }
		/**
        * Totals of all events
        **/
		function jsonfilter() {
        	$document 	= &JFactory::getDocument();
            $doc 		= &JDocument::getInstance('raw');
            $document 	= $doc;
            $document->setMimeEncoding('application/json');
           
        
        	$view =& $this->getView('json');
        	$view->setModel($this->getModel('query'), true);
	        $view->setLayout('filter');
	        //$view->displayFilter();
			$view->displayData();
        }
		
		/**
        * List of all category events updated
        **/
        function jsonlistup() {
        	$view =& $this->getView('json');
			$view->setLayout('list');
			//echo $monitor;
	        $view->displayDataUp($monitor);
        }
		
		/**
        * List of all actions of a category
        **/
        function jsonaction() {
			$document 	= &JFactory::getDocument();
            $doc 		= &JDocument::getInstance('raw');
            $document 	= $doc;
            $document->setMimeEncoding('application/json');
			
        	$view =& $this->getView('json');
			$view->setModel($this->getModel('query'), true);
			$view->setLayout('action');
			
			$record['category'] = JRequest::getVar('category');
			$record['start_date'] = date('Y-m-d', strtotime('2012-10-01T07:00:00.000Z'));
			$record['end_date'] = date('Y-m-d', strtotime('2012-10-05T07:00:00.000Z'));
			$record['dimensions'] = 'ga:eventAction';
			
			
	        $view->displayDataUp($record);
        }

	}
?>
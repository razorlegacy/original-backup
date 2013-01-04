<?php
    defined( '_JEXEC' ) or die( 'Restricted access' );
    jimport('joomla.application.component.controller');
     
    class originController extends JController {
    	
    	function display() {
    		$view 			= &$this->getView('workspace');
			//$view->setModel($this->getModel('query'), true);
			$view->setLayout('list');
			$view->display();
		}
		
		/***** ROUTING *****/
		/**
		* Edit
		**/
		function edit() {
			//$document 	= &JFactory::getDocument();
			//$document->setTitle('Browser Title');
			$id		= JRequest::getVar('id');
		
			$view 	= &$this->getView('workspace');                   
			//$model 	= &$this->getModel('query');
			//$origin	= $model->getOriginRow(JRequest::getVar('id'));
			
			//$view->setModel($model, true);
			$view->setLayout('workspace');
			$view->editDisplay($id);
		}
		
		
		
		
		/**
		* Cancel
		**/
		function cancel(){
            $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option'));
            $this->setRedirect($redirectTo);                      
        }
        
        /***** POST *****/
        /**
        * Create new Origin record
        **/
        function create() {
        	//Setup
        	$originHelper = new originHelper();
        	$document 	= &JFactory::getDocument();
            $doc 		= &JDocument::getInstance('raw');
            $user 		= &JFactory::getUser();
            $document 	= $doc;
            
            //Get data
            $data				= json_decode(file_get_contents('php://input'))->data;
        	$record['name']		= $data->name;
        	$record['config']	= $originHelper->originConfig($data->name, $data->type->value);
        	$record['manager'] 	= $record['modified_by'] = $user->id;
        	
        	//Save
        	$model		= &$this->getModel('save');
        	$oid		= $model->saveOrigin($record);
        	
        	//Link up blank schedule
        	$schedule['oid']	= $oid->id;
        	$model->saveGeneric($schedule, 'schedule');

        	//Response
			echo json_encode(array('oid'=>$oid->id, 'task'=>'edit'));
        }
        
        /**
        * Updates an Origin record config
        **/
        function saveOrigin() {
	        $document 	= &JFactory::getDocument();
            $doc 		= &JDocument::getInstance('raw');
            $document 	= $doc;
            $document->setMimeEncoding('application/json');
            
            $data 				= json_decode(file_get_contents('php://input'))->data;
            $record['id']		= $data->id;
            $record['oid']		= $data->id;
            $record['name']		= $data->name;
            $record['config']	= json_encode($data->config);
            
            $originModel = &$this->getModel('save');
            $originModel->saveGeneric($record, 'origin');
            
            echo $this->jsonOrigin($record['id']);
        }
        
        /**
        * Create content (add through drag&drop or editor)
        **/
        function createContent() {
	        $document 	= &JFactory::getDocument();
            $doc 		= &JDocument::getInstance('raw');
            $document 	= $doc;
            $document->setMimeEncoding('application/json');
			
			$data				= json_decode(file_get_contents('php://input'))->data;
			$record['oid']		= $data->oid;
			$record['sid']		= $data->sid;
			$record['content']	= json_encode($data->content_data);
			$record['config']	= json_encode($data->content_config);
			$record['render']	= $data->content_render;
			$record['state']	= $data->state;
			
			$originModel = &$this->getModel('save');
			$originModel->saveGeneric($record, 'content');
			
			//print_r($record);
			echo $this->jsonOrigin($record['oid']);
        }
        
        /**
        * Deletes an Origin content row
        **/
        function deleteContent() {
	        $document 	= &JFactory::getDocument();
            $doc 		= &JDocument::getInstance('raw');
            $document 	= $doc;
            $document->setMimeEncoding('application/json');
			
			$data				= json_decode(file_get_contents('php://input'))->data;
			$originModel		= &$this->getModel('save');
			$originModel->deleteGeneric('content', 'id', $data->id);
			
			echo $this->jsonOrigin($data->oid);
        }
        
        /**
		* Save Content (Both content data and config)
		**/
		function saveContent() {
			$document 	= &JFactory::getDocument();
            $doc 		= &JDocument::getInstance('raw');
            $document 	= $doc;
            $document->setMimeEncoding('application/json');
			
			$data				= json_decode(file_get_contents('php://input'))->data;
			$record['id']		= $data->content->id;
			$record['content']	= json_encode($data->content);
			$record['config']	= json_encode($data->config);
			
			$originModel	= &$this->getModel('save');
			$originModel->saveGeneric($record, 'content');
			
			//echo json_encode(array('test'=>'testing'));
		}
		
		/**
		* Save config (drag/resize on workspace)
		**/
		function saveContentConfig() {
			$document 	= &JFactory::getDocument();
            $doc 		= &JDocument::getInstance('raw');
            $document 	= $doc;
            $document->setMimeEncoding('application/json');
			
			$data			= json_decode(file_get_contents('php://input'))->data;
			$record['id']	= $data->id;
			$record['oid']	= $data->oid;
			$record['config']=json_encode($data->config);
						
			$originModel = &$this->getModel('save');
			$originModel->saveGeneric($record, 'content');
			
			echo $this->jsonOrigin($record['oid']);
			//print_r($record);
		}
		
		
		/**
		* Save ordering (re-calculates z-index)
		**/
		function saveOrder() {
			$document 	= &JFactory::getDocument();
            $doc 		= &JDocument::getInstance('raw');
            $document 	= $doc;
            $document->setMimeEncoding('application/json');
			$originModel= &$this->getModel('save');
			
			$data			= json_decode(file_get_contents('php://input'))->data;
			
			foreach($data as $key=>$value) {
				$record['id']		= $value->id;
				$record['oid']		= $value->oid;
				$record['config']	= json_encode($value->content_config);
				$originModel->saveGeneric($record, 'content');
				//print_r($record);
			}
			echo $this->jsonOrigin($data[0]->oid);
			
		}
        
        /***** JSON Feeds *****/
        /**
        * Lists all assets for an Origin unit
        **/
        function jsonAssets() {
	        $document 	= &JFactory::getDocument();
            $doc 		= &JDocument::getInstance('raw');
            $document 	= $doc;
            $document->setMimeEncoding('application/json');
            
            $view	= &$this->getView('json');
            $view->setLayout('assets');
            $view->displayAssets(JRequest::getVar('id'));
        }
        
        /**
        * List of all units
        **/
        function jsonList() {
        	$document 	= &JFactory::getDocument();
            $doc 		= &JDocument::getInstance('raw');
            $document 	= $doc;
            $document->setMimeEncoding('application/json');
            //$document->setMimeEncoding('application/rss+xml');
        
        	$view =& $this->getView('json');
        	$view->setModel($this->getModel('query'), true);
	        $view->setLayout('list');
	        $view->displayList();
        }
        
        /**
        * One Origin unit
        **/
        function jsonOrigin($id) {
	        $document 	= &JFactory::getDocument();
            $doc 		= &JDocument::getInstance('raw');
            $document 	= $doc;
            $document->setMimeEncoding('application/json');
            
            $view = &$this->getView('json');
            $view->setModel($this->getModel('query'), true);
            $view->setLayout('origin');
            $view->displayOrigin(JRequest::getVar('id', $id));
        }
        
        /**
        * Origin's Springboard Video account
        **/
        function jsonSpringboard() {
	        $document	= &JFactory::getDocument();
	        $doc 		= &JDocument::getInstance('raw');
	        $document	= $doc;
	        $document->setMimeEncoding('application/json');
	        
	        $view = &$this->getView('json');
	        $view->setLayout('springboardList');
	        $view->displaySpringboard();
        }
	}
?>
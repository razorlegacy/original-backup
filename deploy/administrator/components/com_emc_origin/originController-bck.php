<?php
    defined( '_JEXEC' ) or die( 'Restricted access' );
    jimport('joomla.application.component.controller');
    
    class originController extends JController {
    
    	function display() {
    		$layout			= JRequest::getVar('layout', 'list');
    		$view 			= & $this->getView('workspace');
    		
			$view->setModel($this->getModel('query'), true);
			$view->setLayout($layout);
			$view->display();
		}
		
		/**
		* Cancel
		**/
		function cancel(){
            $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option'));
            $this->setRedirect($redirectTo);                      
        }
		
		/**
		* Saves an origin
		**/
	    function saveOrigin(){
			$originHelper		= new originHelper();
			
			$origin	= JRequest::get('post');
			$origin['config']	= $originHelper->originConfig($origin['name'],$origin['type']);
			$model	= & $this->getModel('save');
			$origin	= $model->saveOrigin($origin);
			
			//Create schedule
			$schedule['oid']			= $origin->id;
			$schedule					= $model->saveGeneric($schedule, 'schedule');
			
			//go to second page
			$url = 'http://'.$_SERVER["HTTP_HOST"].'/administrator/index.php?option='.JRequest::getVar('option').'&task=editOrigin&id='.$origin->id.'&hidemainmenu=1';
			$redirectTo = JRoute::_($url);
			$this->setRedirect($redirectTo);
			
		}
		
		/**
		* Deletes an origin
		**/
		 function deleteOrigin() {
		 	$arrayIds	= JRequest::getVar('cid', null, 'default', 'array');
		 	
		 	$originModel	=& $this->getModel('save');
		 	$originModel->deleteOrigin($arrayIds);
		 	
		 	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option'));
            $this->setRedirect($redirectTo, 'Origin Deleted');
         }	
        
		/*
		* Edits an origin
		*/
		function editOrigin(){
			$view 	= & $this->getView('workspace');                   
			$model = & $this->getModel('query');
			$origin	= $model->getOriginRow(JRequest::getVar('id'));
			
			$view->setModel($model, true);
			$view->setLayout('workspace');
			$view->editOriginDisplay($origin);
		}
		
		/**
		* Save Origin Config
		**/
		function configSave() {
			$post				= JRequest::get('post', JREQUEST_ALLOWRAW);
			$config['id'] 		= $config['oid'] = $post['id'];
			$config['name']		= $post['name'];
			$config['config']	= json_encode($post);
			$originModel		=& $this->getModel('save');
			$originModel->saveGeneric($config, 'origin');
		}
		
		/**
		* Save Coordinates/Size
		**/
		function saveContentConfig() {
			$post				= JRequest::get('post');
			$config['oid']		= $post['oid'];
			$config['id']		= $post['id'];
			$config['config']	= json_encode($post);
			
			$originModel		=& $this->getModel('save');
			$originModel->saveGeneric($config, 'content');
		}

		/**
		* Workspace content operations
		**/
		function contentSave() {
			$post				= JRequest::get('post', JREQUEST_ALLOWRAW);
			$post['content']	= json_encode($post);
			$originModel		=& $this->getModel('save');
			$originModel->saveGeneric($post, 'content');
		}
		
		/**
		* Workspace content delete
		**/
		function contentDelete() {
			$post				= JRequest::get('post');
			$originModel		=& $this->getModel('save');
			$originModel->deleteGeneric('content', 'id', $post['id']);
		}
		
		/**
		* Create Content
		**/
		function createContent() {
			$post				= JRequest::get('post');
			
			$content['oid']		= $post['oid'];
			$content['sid']		= $post['sid'];
			$content['state']	= $post['state'];
			$content['config']	= json_encode($post);
			
			$originModel		=& $this->getModel('save');
			$cid	= $originModel->saveGeneric($content, 'content');
			echo $cid;
		}
		
		/**
		* Save Content UNUSED???
		**/
		function saveContent() {
			$content				= JRequest::get('post');
					
			$originModel		=& $this->getModel('save');
			$originModel->saveGeneric($content, 'content');
		}
		
		/**
		* Edit Content UNUSED???
		**/
/*
		function editContent() {
			$post				= JRequest::get('post');
			$content['oid']		= $post['oid'];
			$content['id']			= $post['id'];
			$content['content']	= json_encode(array('type'=>$post['type'], 'content'=>$post['content']));

			$originModel		=& $this->getModel('save');
			$originModel->saveGeneric($content, 'content');
		}
*/
		/**
		* Schedule Delete
		**/
		function scheduleDelete() {
			$post				= JRequest::get('post');
			$originModel		=& $this->getModel('save');
			
			$originModel->deleteGeneric('schedule', 'id', $post['id']);
			$originModel->deleteGeneric('content', 'sid', $post['id']);
		}
		
		
		/**
		* Save Date
		**/
		function scheduleSave() {
			$post					= JRequest::get('post');
			
			$schedule['id']			= $post['id'];
			$schedule['oid']		= $post['oid'];
			$schedule['start_date']	= date('Y-m-d', strtotime($post['start_date']));
			$schedule['end_date']	= date('Y-m-d', strtotime($post['end_date']));
					
			$originModel		=& $this->getModel('save');
			$originModel->saveGeneric($schedule, 'schedule');
		}
		
		/**
		* Saves image from temp to the correct folder id
		**/
		function saveImage($files, $originId) {
			foreach($files as $value) {
				$pathTemp		= "../assets/components/com_emc_origin/temp/{$value}";
				$path		= "../assets/components/com_emc_origin/{$originId}/{$value}";
				
				rename($pathTemp, $path);
			}
		}
		
		/**
		* Duplicates the associated content  of a schedule
		**/
		function cloneSchedule() {
			$post					= JRequest::get('post');
			$schedule['oid']		= $post['oid'];
			$schedule['start_date'] = date('Y-m-d', strtotime($post['start_date']));
			$schedule['end_date']	= date('Y-m-d', strtotime($post['end_date']));
			
			$originModel			=& $this->getModel('save');
			$sid					= $originModel->saveGeneric($schedule, 'schedule');
			$originModel->cloneContent($post['id'], $sid);
		}
		
		/**
		* Duplicates the associated content of an origin
		**/
		function cloneOrigin() {
			$post					= JRequest::get('post');
			
			$originModel			=& $this->getModel('save');
			$originModel->cloneOrigin($post['oid']);
		}
		
		/**
		* Delete a schedule and their content - MOVING TO EXISTING FUNCTION
		**/
/*
		function deleteSchedule() {
			$post				= JRequest::get('post');
			$originModel		=& $this->getModel('save');
			$originModel->deleteGeneric('schedule', 'id', $post['sid']);
			$originModel->deleteGeneric('content', 'sid', $post['sid']);
		}
*/
		
		/**
		* Template Loader.... UNUSED?
		**/
		function ajaxTemplate() {
			$post			= JRequest::get('post');
			$view			=& $this->getView('template');
			$view->setLayout('response');
			$view->response($post['template']);
		}
	}
?>
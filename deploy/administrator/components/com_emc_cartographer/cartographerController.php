<?php
    defined( '_JEXEC' ) or die( 'Restricted access' );
    jimport('joomla.application.component.controller');
    
    class cartographerController extends JController {
    
    	function display() {
    		$view = & $this->getView('workspace');
			$view->setModel($this->getModel('query'), true);
			$view->setLayout('list');
			$view->display();
		}
        
        function response() {
        	$post	= JRequest::get('post');
        	$view	=& $this->getView('template');
        	$view->setLayout('response');
        	$view->response($post['tmpl']);
        }
		
		/**
		*
		**/
		function cancel(){
            $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option'));
            $this->setRedirect($redirectTo);                      
        }
        
        /**
        *
        **/
        function updatePublished() {
        	$post						= JRequest::get('post');
        	$post['cid']				= $post['id'];
        	$cartographerModel			=& $this->getModel('save');
			$cartographerModel->saveGeneric($post, 'cartographer');
        }
		
		/**
		* Saves a Cartographer
		**/
	    function saveCartographer(){
			$cartographerTemplate		= new cartographerTemplate();
		
	    	$cartographer				= JRequest::get('post');
			$cartographer['content']	= $cartographerTemplate->cartographerConfig($cartographer['name']);
			
			$model					= & $this->getModel('save');
			$cartographer		= $model->saveCartographer($cartographer);
			
			//Create a default group
			$group['cid']			= $cartographer->id;
			$group					= $model->saveGeneric($group, 'groups');
			
			//Move onto second page
			$url = 'http://'.$_SERVER["HTTP_HOST"].'/administrator/index.php?option='.JRequest::getVar('option').'&task=editCartographer&id='.$cartographer->id.'&hidemainmenu=1';
			$redirectTo = JRoute::_($url);
			$this->setRedirect($redirectTo);
			/*$view	=& $this->getView('workspace');
			$view->setLayout('edit');
			
			$view->setModel($this->getModel('query'), true);
			$view->editCartographerDisplay($cartographer);*/
		}
		
		function editCartographer(){
			$view 			= & $this->getView('workspace');                   
			$model 			= & $this->getModel('query');
			$cartographer	= $model->getCartographerRow(JRequest::getVar('id'));
			
			$view->setModel($model, true);
			$view->setLayout('edit');
			$view->editCartographerDisplay($cartographer);
		}
		
		/**
		* Saves config options
		**/
		function saveConfig() {
			$post						= JRequest::get('post');
			$cartographer				 = $post; 
			$cartographer['content'] 	 = json_encode($post);
			$cartographer['cid']		 = $post['id'];
			
			if(isset($cartographer['image_key']) && $cartographer['image_key']!="") {
				$keys = explode(',',$cartographer['image_key']);
				$files = array();
				foreach($keys as $value) {
					array_push($files, $cartographer[$value]);
				}
				$this->saveImage($files, $cartographer['cid']);
			}
			
			$cartographerModel		=& $this->getModel('save');
			$cartographerModel->saveGeneric($cartographer, 'cartographer');
		}
		
		/**
		* Saves a marker
		**/
		function saveMarker() {
			$post				= JRequest::get('post', JREQUEST_ALLOWRAW);
			$marker				= $post;
			$marker['content'] 	= json_encode($post);
			
			if(isset($marker['image_key']) && $marker['image_key']!="") {
				$keys = explode(',',$marker['image_key']);
				$files = array();
				foreach($keys as $value) {
					array_push($files, $marker[$value]);
				}
				$this->saveImage($files, $marker['cid']);
			}
			
			$cartographerModel		=& $this->getModel('save');
			$cartographerModel->saveGeneric($marker, 'markers');
		}
		
		/**
		* Updates a marker's coordinates (updates frequently, on every drag-stop)
		**/
		function saveCoordinates() {
			$post					= JRequest::get('post');
			$marker['id']			= $post['id'];
			$marker['cid']		= $post['cid'];
			$marker['coordinates']	= json_encode(array('coordX'=>$post['coordX'], 'coordY'=>$post['coordY']));
			
			$cartographerModel		=& $this->getModel('save');
			$cartographerModel->saveGeneric($marker, 'markers');
		}
		
		/**
		* 
		**/
		function deleteMarker() {
			$post				= JRequest::get('post');
			$cartographerModel	=& $this->getModel('save');
			$cartographerModel->deleteGeneric('markers', 'id', $post['id']);
		}
		
		/**
		* Delete a group and their markers
		**/
		function deleteGroup() {
			$post				= JRequest::get('post');
			$cartographerModel	=& $this->getModel('save');
			$cartographerModel->deleteGeneric('groups', 'id', $post['id']);
			
			//Delete markers
			$cartographerModel->deleteGeneric('markers', 'gid', $post['id']);
		}
		
		/**
		* Updates a group
		**/
		function saveGroup() {
			$group				= JRequest::get('post');
			$group['content'] 	= json_encode($group);
			
			$cartographerModel		=& $this->getModel('save');
			$gid	= $cartographerModel->saveGeneric($group, 'groups');
			
			setcookie('cartographerGroup_'.$group['cid'], $gid);
		}
		
		/**
		* Saves image from temp to the correct folder id
		**/
		function saveImage($files, $cartographerId) {
			foreach($files as $value) {
				$pathTemp		= "../assets/components/com_emc_cartographer/temp/{$value}";
				$path		= "../assets/components/com_emc_cartographer/{$cartographerId}/{$value}";

				if($value && file_exists($pathTemp)) {				
					rename($pathTemp, $path);
				}
			}
		}
		
		/**
		* Deletes a Cartographer
		**/
		 function deleteCartographer() {
		 	$arrayIds	= JRequest::getVar('cid', null, 'default', 'array');
		 	
		 	$cartographerModel		=& $this->getModel('save');
		 	$cartographerModel->deleteCartographer($arrayIds);
		 	
		 	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option'));
            $this->setRedirect($redirectTo, 'Cartographer Deleted');
         }	
		
		/**
		* Saves the associated data order
		**/
		function saveOrdering() {
			$post				= JRequest::get('post');			
			$orochiModel		=& $this->getModel('save');
			$orochiModel->saveOrdering($post);
		}
		
	}
?>
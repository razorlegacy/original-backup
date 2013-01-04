<?php

    // no direct access
    defined( '_JEXEC' ) or die( 'Restricted access' );

    jimport('joomla.application.component.controller');

    /**
     * Orochi Component Administrator Controller
     */
    class orochiController extends JController
    {
        /**
         * Method to display the view
         * @access    public
         */
        function display() { 
             $view = & $this->getView('list', 'html');
			 $view->setModel($this->getModel('orochi'), true);
             $view->setLayout('default');
             $view->display();
        }
        
        /**
		*
		**/
		function cancel(){
            $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option'));
            $this->setRedirect($redirectTo);                      
        }
        
		/**
		* Saves a Orochi
		**/
	    function saveOrochi(){
	    	$orochiTemplate		= new orochiTemplate();
	    
			$orochi				= JRequest::get('post');
			$orochi['content']	= $orochiTemplate->orochiConfig();
			//$orochi['content'] = '{"video_autoStart":"true","video_autoMute":"true","cycle_fx":"fade","cycle_speed":"250","cycle_pagination_bg":"#000000","cycle_pagination_hex":"#FFFFFF","cycle_pagination_hover_hex":"#000000","link_hex":"#000000","link_hover_hex":"#0000FF","tab_position":"bottom","tab_text_hex":"#FFFFFF","tab_text_hover_hex":"#000000","tab_bg_hex":"#000000","tab_bg_hover_hex":"#FFFFFF","article_title_hex":"#000000","article_content_hex":"#000000","article_href_hex":"#000000","social_show":"false"}';
			
			$model			= & $this->getModel('save');
			$orochiId		= $model->saveOrochi($orochi);
			
			//Move onto second page
			$view			=& $this->getView('create', 'html');
			$view->setLayout('default');
			
			$view->setModel($this->getModel('orochi'), true);
			$view->editOrochiDisplay($orochiId);
		}
		
		function saveConfig(){
			$post					= JRequest::get('post');

			$post['syndi_bg_250']	= $this->saveImage($post['syndi_bg_250'],$post['id']);
			$post['syndi_bg_600']	= $this->saveImage($post['syndi_bg_600'],$post['id']);
			$post['social_image']	= $this->saveImage($post['social_image'],$post['id']);
						
			//$this->deleteTempFiles();
			
			$orochiObj['id']		= $post['id'];
			$orochiObj['title']		= $post['title'];
			$orochiObj['content']	= json_encode($post);
			$orochiObj['manager']	= $post['manager'];
			
			$model			= & $this->getModel('save');
			$model->saveGeneric($orochiObj, 'orochi');
		}
				
		function editOrochi(){
			$view 		= & $this->getView('create', 'html');                   
			$model 	= & $this->getModel('orochi');
			
			$view->setModel($model, true);
			$view->setLayout('default');
			
			$view->editOrochiDisplay(JRequest::getVar('id'));
		}
		
		/**
		* Deletes an Orochi
		**/
		 function remove(){
		 	$arrayIds	= JRequest::getVar('cid', null, 'default', 'array');
		 	$model		=& $this->getModel('save');
		 	$model->deleteOrochi($arrayIds);
		 	//$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option'));
            //$this->setRedirect($redirectTo, 'Syndi Deleted');

         }	
		
		/**
		* Delete Group
		**/
		function genericDelete() {
			$post			= JRequest::get('post');
			$orochiModel	=& $this->getModel('save');
			
			
			switch($post['deleteType']) {
				case "deleteContent":	$orochiModel->deleteGeneric('content', 'id', $post['id']);
										break;
				case "deleteGroup":		$orochiModel->deleteGeneric('groups', 'id', $post['id']);
										$orochiModel->deleteGeneric('content', 'gid', $post['id']);
										break;
				case "deleteMenu":		$orochiModel->deleteGeneric('menu', 'id', $post['id']);
										$orochiModel->deleteGeneric('groups', 'mid', $post['id']);
										$orochiModel->deleteGeneric('content', 'mid', $post['id']);
										break;
			}

		}
		
		/**
		* Saves content
		**/
		function saveForm() {
			$post				= JRequest::get('post', JREQUEST_ALLOWRAW);
			
			if(isset($post['image'])&&$post['image']!='') {
				$post['image'] =  $this->saveImage($post['image'],$post['oid']);
			}
			
			$post['content'] 	= json_encode($post);
			$orochiModel		=& $this->getModel('save');
			$orochiModel->saveForm($post);
		}
		
		/**
		* Generic Save
		**/
		function genericSave() {
			$post			= JRequest::get('post');
			$orochiModel	=& $this->getModel('save');
			$orochiModel->saveGeneric($post, $post['table']);
		}

		/**
		* Saves/Update a Menu
		**/
		function saveMenu() {
			$post							= JRequest::get('post');
			$orochiModel				=& $this->getModel('save');
			$post['menu_page_bg']	= $this->saveImage($post['menu_page_bg'],$post['oid']);
			$post['menu_bg']			= $this->saveImage($post['menu_bg'],$post['oid']);
			$post['content'] 				= json_encode($post);
			
			$menuId				= $orochiModel->saveGeneric($post, 'menu');
			
			// new menu
			if(!$post['id']) {
				//create the default group
				$orochiGroup['oid'] 	= $post['oid'];
				$orochiGroup['mid'] 	= $menuId;
				$orochiGroup['size']	= 1;
				$orochiGroup['link']	= 1;
				$orochiModel->saveGeneric($orochiGroup, 'groups');
			}
		}
				
		/**
		* Refresh modal's current group content listing
		**/		
		function refreshContent() {
			$post			= JRequest::get('post');
			$orochiModel	=& $this->getModel('orochi');
			$view			=& $this->getView('response', 'html');
			$view->setModel($this->getModel('orochi'), true);
			$view->templateResponse($post['tmpl'], $post['oid'], $post['mid'], $post['gid']);
		}
		
		/**
		* Refresh modal content form
		**/
		function refreshForm() {
			$post			= JRequest::get('post');
			$view			=& $this->getView('response', 'html');
			$view->templateResponse($post['tmpl']);
		}
		
		/**
		* Refresh modal menu form
		**/
		function refreshMenuForm() {
			$post			= JRequest::get('post');
			$orochiModel	=& $this->getModel('orochi');
			$view			=& $this->getView('response', 'html');
			$view->setModel($this->getModel('orochi'), true);
			$view->templateResponse($post['tmpl'], $post['oid'], $post['mid']);
		}
				
		/**
		* Refresh workspace
		**/
		function refreshWorkspace() {
			$post			= JRequest::get('post');
			//$orochiModel	=& $this->getModel('orochi');
			$view			=& $this->getView('response', 'html');
			$view->setModel($this->getModel('orochi'), true);
			$view->templateResponse($post['tmpl'], $post['oid']);
		}		
		
		/**
		* Saves the associated tab data order
		**/
		function saveOrdering() {
			$post				= JRequest::get('post');			
			$orochiModel		=& $this->getModel('save');
			$orochiModel->saveOrdering($post);
		}
		
		/**
		* Saves image from temp to the correct folder id
		**/
		function saveImage($nameFile, $orochiId) {
			$root 		= "/assets/components/com_orochi";
			$path		= "../assets/components/com_orochi";
			$temp 		= basename($nameFile);
			
			if($temp) {
				rename("{$path}/temp/{$temp}", "{$path}/{$orochiId}/{$temp}");
				return "{$root}/{$orochiId}/{$temp}";
			}
			else {
				return $nameFile;
			}
		}
		
		/**
		* Deletes all files in temp folder
		**/
		function deleteTempFiles() {
			$files = glob("../assets/components/com_orochi/temp/*.{jpg,gif,png}", GLOB_BRACE ); 
			foreach($files as $file) unlink($file);
		}
		
		/**
		*	Delete files
		**/
		function deleteFile() {
			$post = JRequest::get('post');
			
			if(file_exists($post['path'])) {
				unlink($post['path']);
				return true;
			}
			else {
				return false;
			}
		}
		
		
		function email() {
			$post	= JRequest::get('post', JREQUEST_ALLOWRAW);
			$model 	= & $this->getModel('orochi');
			$view	=& $this->getView('list', 'html');
			$view->setModel($model, true);
			$view->setLayout('email');
			$view->email($post);
		}
		
		
	}
	?>
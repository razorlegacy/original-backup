<?php

    // no direct access
    defined( '_JEXEC' ) or die( 'Restricted access' );

    jimport('joomla.application.component.controller');

    /**
     * Syndi Component Administrator Controller
     */
    class SyndiController extends JController
    {
          
           /**
         * Method to display the view
         *
         * @access    public
         */
        function display()
        { 
                 $view = & $this->getView('list', 'html');
				 $view->setModel($this->getModel('syndi'), true);
                 $view->setLayout('default');
                 $view->display();
        }
		
		/**
		* Create a new Syndi record
		**/
		function createSyndi() {
			$view 	= & $this->getView('list', 'html');                   
			$model 	= & $this->getModel('syndi');
			
			$view->setModel($model, true);
			$view->setLayout('create');
			
			if(JRequest::getVar('sid')) {
				$view->editSyndiDisplay(JRequest::getVar('sid'));
			} else {
				$view->createSyndiDisplay();                 
			}
		}
		
		/**
		* Saves the Syndi configuration
		**/
	    function saveSyndiConfig(){
								
			$syndiConfig						= JRequest::get('post');
			/*
			*config default
			*/

			if(!$syndiConfig['config']) {
				$syndiConfigObj['video_autoStart']				= 'true';
				$syndiConfigObj['video_autoMute']				= 'true';
				$syndiConfigObj['cycle_fx'] 					= 'fade';
				$syndiConfigObj['cycle_speed']					= '250';
				$syndiConfigObj['cycle_pagination_bg']			= '#000000';
				$syndiConfigObj['cycle_pagination_hex']			= '#FFFFFF';
				$syndiConfigObj['cycle_pagination_hover_hex']	= '#000000';
				$syndiConfigObj['link_hex']						= '#000000';
				$syndiConfigObj['link_hover_hex']				= '#0000FF';
				$syndiConfigObj['tab_position']					= 'bottom';
				$syndiConfigObj['tab_text_hex']					= '#FFFFFF';
				$syndiConfigObj['tab_text_hover_hex']			= '#000000';
				$syndiConfigObj['tab_bg_hex']					= '#000000';
				$syndiConfigObj['tab_bg_hover_hex']				= '#FFFFFF';
				$syndiConfigObj['article_title_hex']			= '#000000';
				$syndiConfigObj['article_content_hex']			= '#000000';
				$syndiConfigObj['article_href_hex']				= '#000000';
				$syndiConfig['config'] = json_encode($syndiConfigObj);
			}
			$syndiConfig['bypass']	= false;
			
			$model 				= & $this->getModel('save');
			$syndiId			= $model->saveSyndi($syndiConfig);
		
			//Move onto second page
			$view			=& $this->getView('form', 'html');
			$view->setLayout('tabs');
			$view->setModel($this->getModel('syndi'), true);
			$view->displayTabs($syndiId);


		}
		
		/**
		* Updates changes in Config from config tab
		**/
		function updateSyndiConfig() {
			$syndiConfig			= JRequest::get('post');
			$syndiConfig['config']	= json_encode($syndiConfig);
			$syndiConfig['bypass']	= true;
			
			$model 				= & $this->getModel('save');
			$syndiId			= $model->saveSyndi($syndiConfig);
		}
		
		/**
		* Deletes a Syndi record
		**/
		 function remove(){
             $arrayIDs = JRequest::getVar('cid', null, 'default', 'array' );
        
             $model = & $this->getModel('save');
             $model->deleteSyndi($arrayIDs);
        
             $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option'));
             $this->setRedirect($redirectTo, 'Syndi entry deleted');               
         }	
        
/*
		function edit(){
		   $sids = JRequest::getVar('sid', null, 'default', 'array' );
		  
		   if($sids === null){
				 JError::raiseError(500, 'sid parameter missing from the request');
		   }

		   $syndiId = (int)$sids[0]; 
		   $view = & $this->getView('form');
		   
		   if($model = & $this->getModel('syndi')) {
				 $view->setModel($model, true);
		   }
				 
		   $view->setLayout('config');
		   $view->displayEdit($syndiId);
		}
*/		 
		/**
		*
		**/
		function cancel(){
            $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option'));
            $this->setRedirect($redirectTo, 'Operation cancelled');                      
        }
        
/*
        function loadTemplate() {
			$post		= JRequest::get('post');
						
			$view		=& $this->getView('response', 'html');
			
			$view->setLayout($post['template']);
			$view->display($post['template']);
			
        }
*/
        /**
		* Generic Syndi edit form function
		*/
/*
		function editForm() {
			$post		= JRequest::get('post');
			$view		=& $this->getView('response', 'html');
			$view->setModel($this->getModel('syndi'), true);
			
			$view->setLayout($post['typetab'].'_form');
			$view->refreshForm($post['typetab'], $post['id']);
		}
*/
		
		/**
		* Loads all tabs and associated data for a specific syndi record
		**/
		function loadTabs() {
			$post		= JRequest::get('post');
			
			$view		 =& $this->getView('response', 'html');
			$view->setModel($this->getModel('syndi'), true);
			$view->setLayout('tab_full');
			$view->displayTab($post['sid']);  
		}
		
		
		
/*
		 function loadList() {
			$post		= JRequest::get('post');
			$view		 =& $this->getView('response', 'html');
			$view->setModel($this->getModel('syndi'), true);
			$view->setLayout($post['typetab'].'_list');
			$view->refreshList($post['typetab'], $post['tab_id']);
     
		}
*/
		
		/**
		* Edit/Delete tab data
		*/
		function updateTab() {
			$post	= JRequest::get('post');
			
			switch($post['update_task']) {
				case "updateTab":		$model	=& $this->getModel('save');
										$model->saveTab($post);
										break;
				case "deleteTab": 		$model	=& $this->getModel('save');
										$model->deleteTab($post);
										break;
			}
			
			
			$view		 =& $this->getView('response', 'html');
			$view->setModel($this->getModel('syndi'), true);
			$view->setLayout('tabs');
			$view->displayTab($post['sid']);
		}
		
		/**
		* Adds a new tab
		**/
		function addTab() {
			$post	= JRequest::get('post');			
			$model	= & $this->getModel('save');
			$tabId	= $model->saveTab($post);
		}
		
		/**
		* Saves the current order of tabs
		**/
		function saveTabsOrder() {
			$post	= JRequest::get('post');
			
			$syndiModel		=& $this->getModel('save');
			$syndiModel->saveTabsOrder($post);
		
		}
		
		/**
		* Saves the associated tab data order
		**/
		function saveOrdering() {
			$post			= JRequest::get('post');			
			$syndiModel		=& $this->getModel('save');
			$syndiModel->saveOrdering($post);
		}
		
		/**
		* Saves form data for a tab/Syndi
		**/
		function saveForm() {
			$post			= JRequest::get('post');
			
			$syndiModel		=& $this->getModel('save');
			
			$syndiModel->saveForm($post);
	
			$view		 =& $this->getView('response', 'html');
			$view->setModel($this->getModel('syndi'), true);
			$view->setLayout($post['typetab'].'_list');
			$view->refreshList($post['typetab'], $post['tab_id']);			
		}
		
		/**
		* Saves form data for a social tab (fb/twitter)?
		**/
		function saveSocialForm() {
			$syndiSocial							= JRequest::get('post');
			$syndiSocial['twitter_config']	= json_encode($syndiSocial);
			
			$model 			= & $this->getModel('save');
			$syndiId			= $model->saveForm($syndiSocial);
		}
		
		/**
		* Deletes a Syndi tab record
		**/
		function deleteGeneric() {
			$post	= JRequest::get('post');			
			$model	=& $this->getModel('syndi');
			$model->deleteRow($post['typetab'], $post['id']);

			$view		 =& $this->getView('response', 'html');
			$view->setModel($this->getModel('syndi'), true);
			$view->setLayout($post['typetab'].'_list');
			$view->refreshList($post['typetab'], $post['tab_id']);
			
		}
	}
	?>
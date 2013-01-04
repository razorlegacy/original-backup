    <?php
    // no direct access

    defined( '_JEXEC' ) or die( 'Restricted access' );

    jimport( 'joomla.application.component.view');


    class SyndiViewResponse extends JView
    {                		
		function display() {	
			parent::display();
		}
		
/*
		function displayEdit($syndiId)
        {                           
           JToolBarHelper::title('Syndi'.': [<small>Edit</small>]');
           JToolBarHelper::save();
           JToolBarHelper::cancel(); 
               
           $model = $this->getModel();
		   $syndirow = $model->getSyndiRow($syndiId);
		   		   
		   $this->assignRef('syndi', $syndirow);
           //JToolBarHelper::title("$syndirow".': [<small>Edit</small>]');                              
            parent::display();
        }
*/
		
		function displayTab($syndiId) {
			$tabsModel		= &$this->getModel('syndi');
			$tabsObj		= $tabsModel->loadTabs($syndiId);
			$syndi			= $tabsModel->getSyndiRow($syndiId);
	
			$this->assignRef('syndi', $syndi);
			$this->assignRef('tabsObj', $tabsObj);	     
            parent::display();
		}
		
		function displayList($type, $tabId) {
			$tabsModel	= &$this->getModel('syndi');
			$syndiTab		= $tabsModel->loadListTab($type, $tabId);
     
			$this->assignRef('syndiTab', $syndiTab);		     
            parent::display();
		}
		 
		 /**
		* Refresh form when click edit button
		* it is call from the Generic Syndi editForm()
		* (it is not in use right now)
		*/
		/*function refreshForm($typetab, $id) {
			$formModel	= &$this->getModel('syndi');
			
			switch($typetab) {
				case "video":	$syndiForm		= $formModel->getVideo($id);
									break;
				case "poll" : 	//Getting poll
									$syndiForm		= $formModel->getPoll($id);
									break;
			}
			
			$this->assignRef('syndi', $syndiForm);
			
            parent::display();
		}*/
		
		function refreshList($typetab, $tab_id) {
			$syndiModel		=& $this->getModel('syndi');
			$syndiTab		= $syndiModel->loadListTab($typetab, $tab_id);
			
			$this->assignRef('syndiTab', $syndiTab);
			parent::display();
		}
    }
?>	
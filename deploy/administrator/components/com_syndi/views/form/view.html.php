    <?php
    // no direct access

    defined( '_JEXEC' ) or die( 'Restricted access' );

    jimport( 'joomla.application.component.view');
	//require_once (JPATH_COMPONENT.DS."classes".DS."syndiTemplate.class.php");

    /**
     * HTML View class for the backend of the Greetings Component edit task
     *
     * @package    Greetings
     */

    class SyndiViewForm extends JView
    {		
/*
		function displayAdd() {
            JToolBarHelper::title('Syndi'.': [<small>Add</small>]');
            JToolBarHelper::custom('saveSyndiConfig', 'forward.png', 'forward.png', 'Continue', false, false );
            JToolBarHelper::cancel();
             
            $userObj		= new userHelper();
			$minACL			= 1;
			
			$this->validateForm();
			$this->assignRef('userObj', $userObj);
			$this->assignRef('minACL', $minACL);
       
	        parent::display();
		}
*/
		
/*

		function displayEdit($syndiId)
        {                           
           JToolBarHelper::title('Syndi'.': [<small>Edit</small>]');
           JToolBarHelper::custom('saveSyndiConfig', 'forward.png', 'forward.png', 'Continue', false, false );
           JToolBarHelper::cancel();
           
           $model 		= $this->getModel();
		   $syndirow 	= $model->getSyndiRow($syndiId);
		   
		   $syndiConfig	= unserialize($syndirow->config);
           
           	$userObj		= new userHelper();
			$minACL			= 1;
			
			$this->validateForm();
			$this->assignRef('userObj', $userObj);
			$this->assignRef('minACL', $minACL);
           		   
		   	$this->assignRef('syndi', $syndirow);
		   	$this->assignRef('syndiConfig', $syndiConfig);                     
           
           parent::display();
        }
*/

        /**
        * Displays the Syndi tabs view
        **/
        function displayTabs($syndiId) {
		
			$model 	= $this->getModel('syndi');
			$syndi	= $model->getSyndiRow($syndiId);
			$tabs	= $model->loadTabs($syndiId);
			
			JToolBarHelper::title($syndi->syndi_name.': [<small>Edit</small>]');
			JToolBarHelper::custom('cancel', 'cancel.png', 'cancel.png', 'Exit', false, false);
				
			$this->assignRef('tabsObj', $tabs);
			$this->assignRef('syndi', $syndi);
			
			parent::display();
        }
        
        /**
		* Javascript validator
		*/
		function validateForm() {
			?>
			<script type="text/javascript">

				function submitbutton(pressbutton) {
									
					if(pressbutton == 'cancel') {
						submitform(pressbutton);
						return;
					}
					
					if(pressbutton == 'saveSyndiConfig') {
						if($j('#syndi_name').val().length == 0) {
							syndiGeneral.message('Please enter a name for the Syndi', 'notice');
							return false;
						} else {
							jQuery('#adminForm input[name="task"]').attr('value', pressbutton);
							jQuery('#adminForm').submit();
						}
					}
					
				}

			</script>
			<?php
		}
        
        
        
        
    }
    ?>   
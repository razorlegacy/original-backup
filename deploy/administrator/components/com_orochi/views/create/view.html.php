    <?php
    // no direct access

    defined( '_JEXEC' ) or die( 'Restricted access' );

    jimport( 'joomla.application.component.view');

    /**
    * Orochi create class
     */

    class OrochiViewCreate extends JView {
       //NEEDED?       
       function display() {	
			parent::display();
		}
		
		/**
        * Edits a pre-existing Orochi record
        **/
        function editOrochiDisplay($id) {
        	
        	//JToolBarHelper::cancel();
           
        	$userObj		= new userHelper();
			$minACL			= 1;

        	$model			= $this->getModel();
        	
        	//SETUP
			//$orochiSetupMenu250	= $model->getMenu($id, "250");
        	//$orochiSetupMenu600	= $model->getMenu($id, "600");

			$orochiRow		= $model->getOrochiRow($id);
			$orochiMenu		= $model->getOrochiGM($id, 'menu');
			$orochiGroups	= $model->getOrochiGM($id, 'groups');
			$orochiContent	= $model->getGeneric('content', 'oid', $id);
			//$orochiContent	= $model->getContentGroups($id);
			
			$this->assignRef('orochi', $orochiRow);
			


			//$this->assignRef('orochiSetupMenu250', $orochiSetupMenu250);
			//$this->assignRef('orochiSetupMenu600', $orochiSetupMenu600);
			$this->assignRef('orochiMenu', $orochiMenu);


			$this->assignRef('orochiGroups', $orochiGroups);
			$this->assignRef('orochiContent', $orochiContent);
			$this->assignRef('userObj', $userObj);
			$this->assignRef('minACL', $minACL);
			
			JToolBarHelper::title("Syndi Edit <small>[{$orochiRow->title}]</small>", 'generic.png');
        	JToolBarHelper::custom('cancel', 'cancel.png', 'cancel.png', 'Exit', false, false);
			parent::display();
        }     
    }
	?>
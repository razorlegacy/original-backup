    <?php
    // no direct access

    defined( '_JEXEC' ) or die( 'Restricted access' );

    jimport( 'joomla.application.component.view');

    /**
    * Syndi listing class
     */

    class SyndiViewList extends JView
    {
                
        function display()
        {
           JToolBarHelper::title('Syndi Webservice Manager', 'generic.png');
		   JToolBarHelper::custom('createSyndi', 'new.png', 'new.png', 'Create Syndi', false, false );  		   
           JToolBarHelper::deleteList();   
          
			$userObj		= new userHelper();
			$minACL			= 1;
			
			if($userObj->checkACL($minACL)) {
				$uid		= '';
			} else {
				$uid		= $userObj->_userId;
			}
			
			$this->createSyndi();
			$model = $this->getModel('syndi');
			$syndi = $model->getSyndi($uid);
			
			$this->assignRef('syndi', $syndi);
			$this->assignRef('userObj', $userObj);
			$this->assignRef('minACL', $minACL);
			
           parent::display();

        }
        
        function createSyndiDisplay() {
        	$userObj		= new userHelper();
			$minACL			= 1;
			
			$this->assignRef('userObj', $userObj);
			$this->assignRef('minACL', $minACL);

        	parent::display();
        }
        
        /**
        * Edits a pre-existing Syndi record
        **/
        function editSyndiDisplay($sid) {
        	$userObj		= new userHelper();
			$minACL			= 1;

        	$model			= $this->getModel();
			$syndiRow		= $model->getSyndiRow($sid);
			
			$this->assignRef('syndi', $syndiRow);
			$this->assignRef('userObj', $userObj);
			$this->assignRef('minACL', $minACL);
			
			parent::display();
        }
        
        
        /**
		* Javascript validator
		*/
		function createSyndi() {
			?>
			<script type="text/javascript">
				function submitbutton(pressbutton) {
									
					if(pressbutton != 'createSyndi' ) {
						submitform(pressbutton);
						return;
					} else {
						syndiCreate.modal('index.php?option=com_syndi&task=createSyndi&format=raw');
					}	
				}
			</script>
			<?php
		}
        
    }
	?>
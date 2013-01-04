    <?php
    // no direct access

    defined( '_JEXEC' ) or die( 'Restricted access' );

    jimport( 'joomla.application.component.view');

    /**
    * Orochi listing class
     */

    class OrochiViewList extends JView
    {
                
        function display()
        {
        	//$acl				= new evolveUserHelper();
        	
           //JToolBarHelper::title('Syndi Manager', 'generic.png');   
           //if($acl->checkACL(1)) JToolBarHelper::deleteList();   
           
			$model = $this->getModel('orochi');
			$orochi = $model->getOrochi();
			
			$this->assignRef('orochi', $orochi);
			
           parent::display();

        }
        
        function email($post) {
        	$model			= $this->getModel();
        	$orochiRow		= $model->getOrochiRow($post['id']);
        	
        	$this->assignRef('emailObj', $post);
        	$this->assignRef('syndiObj', $orochiRow);
        	
			parent::display();
		}       
    }
	?>
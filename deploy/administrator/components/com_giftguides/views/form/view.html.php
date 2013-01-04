<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.view');
require_once (JPATH_COMPONENT.DS."classes".DS."giftguideTemplate.class.php");

$document 	=& JFactory::getDocument();
//$document->addScript('https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.js');
$document->addScript('components'.DS.'com_giftguides'.DS.'js'.DS.'giftguide.min.js');
$document->addScript('components'.DS.'com_giftguides'.DS.'js'.DS.'jquery.ui.min.js');
$document->addScript('components'.DS.'com_giftguides'.DS.'js'.DS.'giftguideForm.js');


class GiftGuidesViewForm extends JView {

	function displayCreate() {
		JToolBarHelper::title('Gift Guide Template Manager'.':[<small>New</small>]');
		JToolBarHelper::custom('saveGiftGuide', 'forward.png', 'forward.png', 'Continue', false, false );
		JToolBarHelper::cancel();
			
		$userObj		= new userHelper();
		$minACL			= 1;
		
		$this->validateForm();
		//$giftguidesModel	= $this->getModel('giftguides');
		
		$this->assignRef('userObj', $userObj);
		$this->assignRef('minACL', $minACL);
		
		parent::display();
	}
	
	function displayGiftGuideEdit($gid) {
		JToolBarHelper::title("Gift Guide Template Manager".":[<small>Edit</small>]");
		JToolBarHelper::cancel();
		JToolBarHelper::custom('saveExitGiftGuide', 'save.png', 'save.png', 'Save & Exit', false, false);
		JToolBarHelper::custom('saveGiftGuide', 'forward.png', 'forward.png', 'Continue', false, false );
		
		
		$userObj	= new userHelper();
		$minACL		= 1;
				
		$giftguidesModel	= $this->getModel('giftguides');
		$giftguides			= $giftguidesModel->getGiftGuide($gid);
		
		$this->validateForm();
		
		//Assigning object references
		$this->assignRef('userObj', $userObj);
		$this->assignRef('minACL', $minACL);
		$this->assignRef('giftguide', $giftguides);

		parent::display();
	}
	
	function displayCreateProduct($gid) {
		//Load giftguide name
		$giftguidesModel	= $this->getModel('giftguides');
		$giftguide			= $giftguidesModel->getGiftGuide($gid);
		$category			= $giftguidesModel->getCategory($gid);
	
		JToolBarHelper::title('Gift Guide'.':[<small>'.stripslashes($giftguide->giftguide_name).'</small>]');
		JToolBarHelper::cancel();
		JToolBarHelper::custom('cancel', 'save.png', 'save.png', 'Save & Exit', false, false);
		JToolBarHelper::custom('editGiftGuide', 'back.png', 'back.png', 'Back', false, false );
		
		$this->assignRef('giftguide', $giftguide);
		$this->assignRef('category', $category);
		
		parent::display();
	}
	
	
	/**
	* Javascript validator for sweepstake form
	*/
	function validateForm() {
		?>
		<script type="text/javascript">
			function submitbutton(pressbutton) {
								
				if(pressbutton == 'cancel') {
					submitform(pressbutton);
					return;
				}
				
				if(pressbutton == 'saveGiftGuide' || pressbutton == 'saveExitGiftGuide') {
					//Validation
					
					if(jQuery('#giftguide_name').val().length == 0) {
						GiftGuide.message('Please enter a Gift Guide name', 'notice');
						return false;
					} else {
						jQuery('#adminForm input[name="task"]').attr('value', pressbutton);
						jQuery('#adminForm').submit();
						//submitform(pressbutton);
					}
				}
				
			}
		</script>
		<?php
	}

	
	
	
	
}
?>
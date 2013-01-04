<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once (JPATH_COMPONENT.DS."classes".DS.'sliverNav.php');
jimport( 'joomla.application.component.view');
/**
 * HTML View class for the backend of the Slivers Component's scheduledImages
 *
 * @package    SliversAdmin
 */
class SliversViewSetupImages extends JView{
 /**
  * Throws out the html for editing a sliver
  *
	* @param int $sliverId
  */
	function displayEdit($sliverId) {
		if(!$sliverId) JError::raiseError(500, 'invalid sliver id');
	
		$nav = new sliverNav('images',$sliverId);
		
		JToolBarHelper::title('Sliver'.': [<small>Edit</small>]');
		JToolBarHelper::custom('scheduledImages+back', 'back.png', 'back.png', 'Back', false, false );
		JToolBarHelper::custom('scheduledImages+continue', 'forward.png', 'forward.png', 'Continue', false, false );
		JToolBarHelper::divider();
		JToolBarHelper::cancel();

		$scheduledImages = $this->getModel('scheduledImages')->getScheduledImagesForSliver($sliverId);
		$sliver = $this->getModel('slivers')->getSliver($sliverId);

		$this->assignRef('scheduledImages', $scheduledImages);
		$this->assignRef('sliver_id', $sliverId);
		$this->assignRef('sliver',$sliver);
		$this->assignRef('nav',$nav);

		parent::display();
	}
}
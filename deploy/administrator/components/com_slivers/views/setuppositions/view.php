<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
/**
 * HTML View class for the backend of the Slivers Component's add and edit tasks
 *
 * @package    SliversAdmin
 */
class SliversViewSetupPositions extends JView {
 /**
  * Throws out the html for editing a sliver
  *
	* @param int $sliverId
  */
	function displayEdit($sliverId) {
		if(!$sliverId) JError::raiseError(500, 'invalid sliver id');
		
		JToolBarHelper::title('Sliver'.': [<small>Edit</small>]');
		JToolBarHelper::custom('positions+current', 'apply.png', 'apply.png', 'Apply', false, false);
		JToolBarHelper::custom('positions+up', 'save.png', 'save.png', 'Save &amp; Exit', false, false);
		JToolBarHelper::custom('positions+back', 'back.png', 'back.png', 'Save & Go Back', false, false );
		JToolBarHelper::custom('positions+continue', 'forward.png', 'forward.png', 'Save & Continue', false, false );
		JToolBarHelper::divider();
		JToolBarHelper::cancel();
		
		$advanced = JRequest::getBool('advanced',false,'COOKIE');

		$model = $this->getModel('slivers');
		$videos = $this->getModel('videos')->getVideosForSliver($sliverId);
		$scheduledImages = $this->getModel('scheduledImages')->getScheduledImagesForSliver($sliverId);
		$buttonsModel = $this->getModel('buttons');
		$buttons = $buttonsModel->getButtonsForSliver($sliverId);
		$newbutton = $buttonsModel->getNewButton();

		$sliver = $model->getSliver($sliverId);
		$this->assignRef('sliver', $sliver);
		$this->assignRef('scheduledImages', $scheduledImages);
		$this->assignRef('buttons', $buttons);
		$this->assignRef('videos', $videos);
		$this->assignRef('newbutton',$newbutton);
		$this->assignRef('advanced',$advanced);

		parent::display();
	}
}

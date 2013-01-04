<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once (JPATH_COMPONENT.DS."classes".DS.'sliverNav.php');
jimport( 'joomla.application.component.view');
/**
 * HTML View class for the backend of the Slivers Component's add and edit tasks
 *
 * @package    SliversAdmin
 */
class SliversViewSetupVideos extends JView {

 /**
  * Throws out the html for editing a sliver
  *
	* @param int $sliverId 
  */
	function displayEdit($sliverId) {
		if(!$sliverId) JError::raiseError(500, 'invalid sliver id');

		$nav = new sliverNav('videos',$sliverId);

		// Top Nav
		JToolBarHelper::title('Sliver'.': [<small>Edit</small>]');
		JToolBarHelper::apply('videos+current');
		JToolBarHelper::save('videos+up','Save & Exit');
		JToolBarHelper::custom('videos+back', 'back.png', 'back.png', 'Go Back', false, false );
		JToolBarHelper::custom('videos+next', 'forward.png', 'forward.png', 'Continue', false, false );
		JToolBarHelper::divider();
		JToolBarHelper::cancel();

		$advanced = JRequest::getBool('advanced',false,'COOKIE');

		$model = $this->getModel();
		$videos = $model->getVideosForSliverByDate($sliverId);
		$sliver = $this->getModel('slivers')->getSliver($sliverId);

		$this->assignRef('sliver_id', $sliverId);
		$this->assignRef('advanced', $advanced);
		$this->assignRef('nav', $nav);
		$this->assignRef('sliver', $sliver);
		$this->assignRef('videos', $videos);

		$link = 'index.php?option='.JRequest::getVar('option').'&cid='.$sliverId.'&format=html&tmpl=component';
		$deletevideo = JRoute::_('index.php?option='.JRequest::getVar('option').'&task=removeVideos&id[]=',false);
		$editvideo = JRoute::_($link.'&task=editVideo&id=',false);
		$addvideo = JRoute::_($link.'&task=addVideo',false);

		$this->assignRef('addvideo',$addvideo);
		$this->assignRef('editvideo',$editvideo);
		$this->assignRef('deletevideo',$deletevideo);

		parent::display();
	}
}

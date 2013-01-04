<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once (JPATH_COMPONENT.DS."classes".DS.'sliverNav.php');
jimport( 'joomla.application.component.view');
/**
 * HTML View class for the backend of the Slivers Component's video add and edit tasks
 *
 * @package    SliversAdmin
 */
class SliversViewEditVideo extends JView {

 /**
  * Throws out the html for editing a sliver
  *
	* @param int $sliverId 
	* @param int $videoId 
  */
	function displayEdit($sliverId, $videoId) {
		if(!$sliverId) JError::raiseError(500, 'invalid sliver id');
		if(!$videoId) JError::raiseError(500, 'invalid video id');

		$advanced = JRequest::getBool('advanced',false,'COOKIE');

		$model = $this->getModel();
		$video = $model->getVideos(array($videoId));
		
		$this->assignRef('sliver_id',$sliverId);
		$this->assignRef('video', $video[0]);
		$this->assignRef('advanced', $advanced);

		$document =& JFactory::getDocument();
		$document->addStyleSheet('templates/system/css/system.css');

		parent::display();
	}
 /**
  * Throws out the html for creating a new video
  *
	* @param int $sliverId 
  */
	function displayAdd($sliverId, $date) {
		if(!$sliverId) JError::raiseError(500, 'invalid sliver id');

		$advanced = JRequest::getBool('advanced',false,'COOKIE');

		$model = $this->getModel();
		
		$newvideo = $model->getNewVideoFromDate($sliverId);
		
		if (!$newvideo)
			JError::raiseError(500, 'blank video failed to create'.(print_r($newvideo,true)));

		$this->assignRef('sliver_id',$sliverId);
		$this->assignRef('video', $newvideo);
		$this->assignRef('advanced', $advanced);

		$document =& JFactory::getDocument();
		$document->addStyleSheet('templates/system/css/system.css');

		parent::display();
	}
}

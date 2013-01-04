<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
require_once (JPATH_COMPONENT.DS."classes".DS.'sliverNav.php');
/**
 * HTML View class for the backend of the Slivers Component's add and edit tasks
 *
 * @package    SliversAdmin
 */
class SliversViewSetupGeneral extends JView {
	public $playlist_positions = array('top','right','bottom','left');
	public $animations = array('swing',
		'easeInQuad',
		'easeOutQuad',
		'easeInOutQuad',
		'easeInCubic',
		'easeOutCubic',
		'easeInOutCubic',
		'easeInQuart',
		'easeOutQuart',
		'easeInOutQuart',
		'easeInQuint',
		'easeOutQuint',
		'easeInOutQuint',
		'easeInSine',
		'easeOutSine',
		'easeInOutSine',
		'easeInExpo',
		'easeOutExpo',
		'easeInOutExpo',
		'easeInCirc',
		'easeOutCirc',
		'easeInOutCirc',
		'easeInElastic',
		'easeOutElastic',
		'easeInOutElastic',
		'easeInBack',
		'easeOutBack',
		'easeInOutBack',
		'easeInBounce',
		'easeOutBounce',
		'easeInOutBounce'
	);

 /**
  * Throws out the html for editing a sliver
  *
	* @param int $sliverId
  */
	function displayEdit($sliverId) {

		JToolBarHelper::title('Sliver'.': [<small>Edit</small>]');
		JToolBarHelper::apply('general+current');
		JToolBarHelper::save('general+up','Save & Exit');
		JToolBarHelper::custom('general+continue', 'forward.png', 'forward.png', 'Save & Continue',false);
		JToolBarHelper::divider();
		JToolBarHelper::cancel();

		$advanced = JRequest::getBool('advanced',false,'COOKIE');

		$model = $this->getModel();
		$users = $this->getModel('users')->getAllUsers();
		$videos = $this->getModel('videos')->getVideosForSliver($sliverId);
		$scheduledImages = $this->getModel('scheduledImages')->getScheduledImagesForSliver($sliverId);

		$sliver = $model->getSliver($sliverId);
		$nav = new sliverNav('general',$sliver->id);
		$this->assignRef('sliver', $sliver);
		$this->assignRef('scheduledImages', $scheduledImages);
		$this->assignRef('users', $users);
		$this->assignRef('video', $videos[0]);
		$this->assignRef('nav', $nav);
		$this->assignRef('advanced',$advanced);
		$this->assignRef('animations',$this->animations);
		$this->assignRef('playlist_positions',$this->playlist_positions);

		parent::display();
	}

 /**
  * Throws out the html for adding a new Sliver
  *
  */
	function displayAdd(){
		JToolBarHelper::title('Sliver'.': [<small>Add</small>]');
		JToolBarHelper::custom('general+continue', 'forward.png', 'forward.png', 'Create & Continue', false, false );
		JToolBarHelper::divider();
		JToolBarHelper::cancel();
		
		$advanced = JRequest::getBool('advanced',false,'COOKIE');

		$model = $this->getModel();
		$users = $this->getModel('users')->getAllUsers();
		$video = $this->getModel('videos')->getNewVideo();

		$sliver = $model->getNewSliver();

 		$this->assignRef('sliver', $sliver);
		$this->assignRef('users', $users);
		$this->assignRef('video', $video);
		$this->assignRef('advanced',$advanced);
		$this->assignRef('animations',$this->animations);
		$this->assignRef('playlist_positions',$this->playlist_positions);

		parent::display();
	}
}

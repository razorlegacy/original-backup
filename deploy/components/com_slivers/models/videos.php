<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

/**
 * videos model
 * @package Slivers
 */

class SliversModelVideos extends JModel {
	public $_db	= null;

	function __construct() {
		parent::__construct();
        $this->_db 		= $this->getDBO();
	}

 	/**
	* Returns an array of all the videos for a sliver.
	*
	* @param int $sliver_id id of the sliver from which all the videos belong to
	* @return array an array of video objects
	*/
	function getVideosForSliver($sliver_id){
		if(!is_numeric($sliver_id) || ($sliver_id = intval($sliver_id)) < 1)
			JError::raiseError(500,'invalid sliver id');
		$db =& $this->getDBO();

		$db->setQuery('SELECT height,width,autoPlay,autoPlayOn,startMuted,unmuteOnRollover,volume,posX,posY,DATE_FORMAT(starts,\'%m/%d/%Y\') starts,embed_code from #__slivers_videos WHERE sliver_id='.(int) $sliver_id.' ORDER BY starts');

		$videos = $db->loadObjectList();

		if ($videos === null)
			JError::raiseError(500, 'Error reading db');

		return $videos;
	}


}

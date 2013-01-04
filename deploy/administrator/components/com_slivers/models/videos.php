<?php
//No direct acesss
defined('_JEXEC') or die();
jimport('joomla.application.component.model');
jimport('joomla.utilities.arrayhelper' );

/**
 * Model for videos
 *
 * @package SliversAdmin
 */
class SliversModelVideos extends JModel {

	/**
	* Returns an array of all the videos for a sliver.
	*
	* @param int $sliver_id id of the sliver from which all the videos belong to
	* @return array an array of video objects
	*/
	function getVideosForSliver($sliver_id){
		$sliver_id = (int) $sliver_id;
		$db =& $this->getDBO();

		$db->setQuery('SELECT * from #__slivers_videos WHERE sliver_id='.$sliver_id.' ORDER BY starts');

		$videos = $db->loadObjectList();

		if ($videos === null)
			JError::raiseError(500, 'Error reading db');

		return $videos;
	}

	/**
	* Returns an array of all the videos for a sliver sorted by their order and date
	*
	* return is organized as:
	* [array videos on the same day sorted by order, array of other videos on different day sorted by order]
	* 
	*
	* @param int $sliver_id id of the sliver from which all the videos belong to
	* @return array an array of video objects
	*/
	function getVideosForSliverByDate($sliver_id){
		$sliver_id = (int) $sliver_id;
		$db =& $this->getDBO();

		$db->setQuery('SELECT * from #__slivers_videos WHERE sliver_id='.$sliver_id.' ORDER BY starts');

		$videos = $db->loadObjectList();

		if ($videos === null)
			JError::raiseError(500, 'Error reading db');

		$videosbydate = array();
		foreach ($videos as $video) {
			if(!isset($videosbydate[$video->starts])) {
				$videosbydate[$video->starts] = array();
			}
			$videosbydate[$video->starts][] = $video;
		}

		return $videosbydate;
	}

	/**
	* Returns an array of video objects
	*
	* @param  array $idlist list of video ids
	* @return array An array of video objects
	*/
	function getVideos(array $idlist){
		JArrayHelper::toInteger($idlist);
		
		$query = ' SELECT * FROM #__slivers_videos '.
							' WHERE id IN ('.implode(',', $idlist).')';
		$db =& $this->getDBO();
		$db->setQuery($query);
		$video = $db->loadObjectList();

		if ($video === null)
			JError::raiseError(500, 'video with ID: '.$id.' not found.');

		return $video;
	}

	/**
	* Saves the provided video properties
	*
	* @param array $videos associative array with video properties
	* @return TableVideos The table object for the properties just entered
	*/
	function save(array $videos){
		foreach($videos as $video){
			$videosTableRow =& $this->getTable('videos');
			//TODO: make autoPlayOn a property that is calculated in the config?
			if(isset($video['autoOpen']) && $video['autoOpen']) $video['autoPlayOn'] = 'init';
			else $video['autoPlayOn'] = 'open';

			!isset($video['autoPlay'])         && $video['autoPlay'] = false;
			!isset($video['startMuted'])       && $video['startMuted'] = false;
			!isset($video['unmuteOnRollover']) && $video['unmuteOnRollover'] = false;
			
			$video['posX'] = (int)$video['posX'];
			$video['posY'] = (int)$video['posY'];
			
			// Insert/update this record in the db
			if (!$videosTableRow->save($video)) {
				JError::raiseError(500, 'Error binding data: '.$videosTableRow->getError());
			}
		}
	}


/**
	* Updates all videos belonging to SliverID to the position supplied.
	*
	* @param int $sliver_id id for the sliver that you want to update the videos for
	* @param int $x horizontal offset - directly corresponds to css left px property
	* @param int $y vertical offset - directly corresponds to css top px property
	* @return TableVideo a sliver Table object with default properties
	*/
	function updateVideosPosition($sliver_id,$x,$y){
		$sliver_id = (int) $sliver_id;
		$x = (int) $x;
		$y = (int) $y;
		
		$query = 'UPDATE #__slivers_videos SET posX='.$x.', posY='.$y.' WHERE sliver_id='.$sliver_id;
		$db =& $this->getDBO();
		$db->setQuery($query);
		$result = $db->query();
		if(!$result)
			JError::raiseError(500, 'Error binding data: '.$db->getErrorMsg(true));
	}

/**
	* returns an empty video
	*
	* @param array $props an associative array of property name/property values that the video should be initialized with
	* @return TableVideo a sliver Table object with default properties
	*/
	function getNewVideo($props = null){
		$videosTableRow =& $this->getTable('videos');
		$videosTableRow->id = 0;
		if (isset($props)) {
			foreach ($props as $key => $val) {
				$videosTableRow->$key = $val;
			}
		}

		return $videosTableRow;
	}

/**
 * returns a video filled with $props and with a position based on the first video in $date
 * @param array $props an associative array of property name/value pairs that the video should be initialized with
 * date in this associative array is the date that this video's position will be based on. it will be the the first video found
 */
	function getNewVideoFromDate($sliverId,$props = null){
		$db =& $this->getDBO();
		$date = '';
		if (isset($props['starts'])) {
			$date = ' AND starts='.$db->Quote($props['starts']);
		}

		$query = ' SELECT * FROM #__slivers_videos '.
			' WHERE sliver_id='.$sliverId.$date.' LIMIT 1';
		$db->setQuery($query);
		$video = $db->loadObject();

		$videoRow = $this->getNewVideo($props);
		if ($video) {
			$videoRow->posX = $video->posX;
			$videoRow->posY = $video->posY;
			$videoRow->width = $video->width;
			$videoRow->height = $video->height;
		}

		return $videoRow;
	}

	/**
	* Deletes the provided videos.
	*
	* @param array $arrayIDs a list of video ids (int) to delete
	*/
	function delete(array $arrayIDs){
		JArrayHelper::toInteger($arrayIDs);

		$query = "DELETE FROM #__slivers_videos WHERE id IN (".implode(',', $arrayIDs).")";
		$db = $this->getDBO();
		$db->setQuery($query);
		if (!$db->query()){
			$errorMessage = $this->getDBO()->getErrorMsg();
			JError::raiseError(500, 'Error deleting videos: '.$errorMessage);
		}
	}



}

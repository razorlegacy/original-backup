<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

/**
 * Coloring books model
 * @package Slivers
 */

class SliversModelSlivers extends JModel {
	public $_db	= null;

	function __construct() {
		parent::__construct();
        $this->_db 		= $this->getDBO();
	}

	/**
	* Returns an array all coloring books the user has access to as generic objects.
	*
	* @param int $id id of the sliver
	* @return object sliver object
	*/
	function getSliver($id){
		$id = intval($id);
		if($id < 1) JError::raiseError(500, "invalid sliver_id");
		$query = ' SELECT id,tweenBG,sliver_height,sliver_color,autoOpen,autoClose,actionbar_height,actionbar_color,prefix,abdisappear,animation_resolution, sliv_open_animation, sliv_close_animation, ab_open_animation, ab_close_animation, sliv_open_duration, sliv_close_duration, ab_open_duration, ab_close_duration, ab_open_delay, playlist_position, playlist_thumb_max_height, playlist_thumb_max_width, playlist_thumb_active_outline_color, playlist_thumb_shadow_offset_x, playlist_thumb_shadow_offset_y, playlist_thumb_shadow_blur_radius, playlist_thumb_shadow_spread_radius, playlist_thumb_shadow_color FROM #__slivers '.
							' WHERE id = '.$id;
							
		$this->_db->setQuery($query);
		$sliver = $this->_db->loadObject();
		
		if ($sliver === null)
			JError::raiseError(500, 'sliver with ID: '.$id.' not found.: '.$query.$this->_db->getErrorMsg(true));
			
		return $sliver;
	}

}

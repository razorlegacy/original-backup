<?php
defined('_JEXEC') or die('Restricted Access');

/**
 * Table class representing Coloring Books
 *
 * @package   SliversAdmin
 */
class TableSlivers extends JTable {
	public $id = null;
	public $name = null;
	public $owner_id = null;
	public $tweenBG = true;
	public $abdisappear  = false;
	public $sliver_height = 250;
	public $sliver_color;
	public $autoOpen = false;
	public $autoClose = 0;
	public $actionbar_height = 50;
	public $actionbar_color;
	public $prefix = null;
	public $ab_open_animation;
	public $ab_close_animation;
	public $sliv_open_animation;
	public $sliv_close_animation;
	public $sliv_open_duration;
	public $sliv_close_duration;
	public $ab_open_delay;
	public $ab_open_duration;
	public $ab_close_duration;
	public $animation_resolution;
	public $playlist_position;
	public $playlist_thumb_max_height;
	public $playlist_thumb_max_width;
	public $playlist_thumb_active_outline_color;
	public $playlist_thumb_shadow_offset_x;
	public $playlist_thumb_shadow_offset_y;
	public $playlist_thumb_shadow_blur_radius;
	public $playlist_thumb_shadow_spread_radius;
	public $playlist_thumb_shadow_color;

	function TableSlivers(&$db){
		parent::__construct('#__slivers', 'id', $db);
	}

 /**
	* overrides the psuedo abstract check method
	* @return bool True on valid false on invalid
	*/
	public function check(){
		if(isset($this->name) && !$this->name){
			$this->setError('Invalid name');
			return false;
		} else if(isset($this->owner_id) && !$this->owner_id || !is_numeric($this->owner_id) || $this->owner_id < 1){
			$this->setError('Invalid owner');
			return false;
		} else if(isset($this->prefix) && !$this->prefix){
			$this->setError('Invalid prefix');
			return false;
		} else if(isset($this->actionbar_height) && strval((int) $this->actionbar_height) != $this->actionbar_height || $this->actionbar_height < 0){
			$this->setError('Invalid actionbar height');
			return false;
		} else if(isset($this->sliver_height) && strval((int) $this->sliver_height) != $this->sliver_height || $this->sliver_height < 0){
			$this->setError('Invalid sliver height');
			return false;
		} else if(isset($this->sliver_color) && !$this->sliver_color || substr($this->sliver_color,0,1) != '#'){
			$this->setError('Invalid sliver color');
			return false;
		} else if(isset($this->actionbar_color) && !$this->actionbar_color || substr($this->actionbar_color,0,1) != '#'){
			$this->setError('Invalid actionbar color');
			return false;
		} else if(isset($this->playlist_thumb_max_height) && strval((int) $this->playlist_thumb_max_height) != $this->playlist_thumb_max_height || $this->playlist_thumb_max_height < 0){
			$this->setError('Invalid thumbnail max height');
			return false;
		} else if(isset($this->playlist_thumb_max_width) && strval((int) $this->playlist_thumb_max_width) != $this->playlist_thumb_max_width || $this->playlist_thumb_max_width < 0){
			$this->setError('Invalid thumbnail max width');
			return false;
		} else if(isset($this->ab_open_delay) && strval((int) $this->ab_open_delay) != $this->ab_open_delay || $this->ab_open_delay < 0){
			$this->setError('Invalid thumbnail max width');
			return false;
		} else if(isset($this->playlist_position) && $this->playlist_position != 'left' && $this->playlist_position != 'bottom' && $this->playlist_position != 'right' && $this->playlist_position != 'top'){
			$this->setError('Invalid playlist position');
			return false;
		}




		return true;
	}
}

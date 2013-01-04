<?php
defined('_JEXEC') or die('Restricted Access');

/**
 * Table Pages class. Represents the db version of pages - images
 *
 * @package SliversAdmin
 */
class TableVideos extends JTable {
	public $id;
	public $sliver_id;
	public $name;
	public $height = 211;
	public $width = 375;
	public $autoPlay = true;
	public $autoPlayOn = 'open';
	public $startMuted = true;
	public $unmuteOnRollover = true;
	public $volume = 100;
	public $posX = 0;
	public $posY = 0;
	public $starts;
	public $embed_code;

	function TableVideos(&$db){
		parent::__construct('#__slivers_videos', 'id', $db);
	}

/**
	* overrides the psuedo abstract check method
	* @return bool True on valid false on invalid
	*/
	public function check(){
		if(  !isset($this->sliver_id) || !$this->sliver_id){
			$this->setError('Invalid sliver id');
			return false;
		}else if(isset($this->height) && $this->height < 1){
			$this->setError('Invalid height'.$this->height);
			return false;
		}else if(isset($this->width)  && $this->width  < 1){
			$this->setError('Invalid width');
			return false;
		}else if(isset($this->autoPlayOn) && $this->autoPlayOn != 'init' && $this->autoPlayOn != 'open'){
			$this->setError('Invalid autoplay state');
			return false;
		}else if(isset($this->volume) && ($this->volume < 0 || $this->volume > 100)){
			$this->setError('Invalid volume');
			return false;
		}else if(isset($this->posX) && !is_int($this->posX)){
			$this->setError('Invalid x offset');
			return false;
		}else if(isset($this->posY) && !is_int($this->posY)){
			$this->setError('Invalid top offset');
			return false;
		}else if(isset($this->starts) && (!$this->starts || !preg_match('/\d{4}[^\d]\d\d[^\d]\d\d/',$this->starts))){
			$this->setError('Invalid start date');
			return false;
		}
		return true;
	}
}

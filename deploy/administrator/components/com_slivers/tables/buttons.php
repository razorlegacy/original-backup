<?php
defined('_JEXEC') or die('Restricted Access');

/**
 * Table button class. Represents the db version of buttons
 *
 * @package SliversAdmin
 */
class TableButtons extends JTable {
	public $id;
	public $sliver_id;
	public $x_offset = 0;
	public $y_offset = 0;
	public $width = 200;
	public $height = 50;
	public $area;
	public $action;
	public $url;
	public $on;
	public $name;

	function TableButtons(&$db){
		parent::__construct('#__slivers_buttons', 'id', $db);
	}

	public function bind($from, $ignore=array()){
		$fromArray    = is_array( $from );
		$fromObject   = is_object( $from );

		if (!$fromArray && !$fromObject){
			$this->setError( get_class( $this ).'::bind failed. Invalid from argument' );
			return false;
		}
		if (!is_array( $ignore )) {
				$ignore = explode( ' ', $ignore );
		}

		$integervars = array('id','sliver_id','x_offset','y_offset','width','height');
		
		foreach ($integervars as $v){
			// internal attributes of an object are ignored
			if (!in_array( $v, $ignore )){
				if ($fromArray && isset( $from[$v] )) {
					$from[$v] = (int)$from[$v];
				} else if ($fromObject && isset( $from->$v )) {
					$from->$v = (int)$from->$v;
				}
			}
		}
		return parent::bind($from,$ignore);
	}

	 /**
	* overrides the psuedo abstract check method
	* @return bool True on valid false on invalid
	*/
	public function check(){
		if(isset($this->width) && (!is_int($this->width) ||  $this->width < 0)){
			$this->setError('Invalid width');
			return false;
		}else if( isset($this->height) && (!is_int($this->height) || $this->height < 0)){
			$this->setError('Invalid height');
			return false;
		}else if(isset($this->x_offset) && !is_int($this->x_offset)){
			$this->setError('Invalid x offset');
			return false;
		}else if(isset($this->y_offset) && !is_int($this->y_offset)){
			$this->setError('Invalid y offset');
			return false;
		}else if(isset($this->area) && ($this->area != 'sliver' && $this->area != 'actionbar')){
			$this->setError('Invalid area');
			return false;
		}else if(isset($this->on) && ($this->on != 'rollover' && $this->on != 'click')){
			$this->setError('Invalid trigger (on)');
			return false;
		}else if(isset($this->action) && ($this->action != 'link' && $this->action != 'dfplink' && $this->action != 'opensliver' && $this->action != 'closesliver')){
			$this->setError('Invalid action:'.$this->action);
			return false;
		}else if(!isset($this->sliver_id) || !is_int($this->sliver_id)){
			$this->setError('Invalid sliver id:'.$this->sliver_id);
			return false;
		}
		
		return true;
	}
}

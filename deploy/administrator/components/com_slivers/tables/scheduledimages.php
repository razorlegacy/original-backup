<?php
defined('_JEXEC') or die('Restricted Access');

/**
 * Table Pages class. Represents the db version of pages - images
 *
 * @package SliversAdmin
 */
class TableScheduledImages extends JTable {
	public $id;
	public $starts;
	public $sliver_id;
	public $actionbar_uri;
	public $flash_uri;
	public $flash_width = 0;
	public $flash_height = 0;

	function TableScheduledImages(&$db){
		parent::__construct('#__slivers_scheduledImages', 'id', $db);
	}

	 /**
	* overrides the psuedo abstract check method
	* @return bool True on valid false on invalid
	*/
	public function check(){
		if(
				isset($this->starts) && (!$this->starts || !preg_match('/\d{4}[^\d]\d\d[^\d]\d\d/',$this->starts))
			|| isset($this->actionbar_uri) && !$this->actionbar_uri
			|| isset($this->flash_uri) && !$this->flash_uri
			|| isset($this->sliver_id) && !$this->sliver_id
		) return false;
		return true;
	}
//This is somewhat absurd...I have to do all this in order to have integer values cast.
// In the end I'm not sure if its even worth it. Every value is quoted anyway.
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
		$integervars = array('id','sliver_id','flash_width','flash_height');

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
}

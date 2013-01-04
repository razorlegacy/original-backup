<?php
defined('_JEXEC') or die();

/**
* Table: Entrants table
* @staticvar int $uid Table auto-increment Primary Key
* @staticvar int $sid Sweepstake ID
* @staticvar array $fields Serialized sweepstake field entries
* @staticvar mixed $timestamp Current timestamp on insert/update
*/
class TableEntrants extends JTable {
	//Column names for #__sweeps_entrants
	public $uid			= null;
	public $sid			= null;
	public $fields		= null;
	public $timestamp	= null;
	
	function __construct(&$db) {
		parent::__construct("#__sweeps_entrants", "uid", $db);
	}
}

?>
<?php
defined('_JEXEC') or die();

/**
* Table: Sweepstakes table
* @staticvar int $id Sweepstake ID (PK), auto-increment
* @staticvar string $name Name of sweepstake
* @staticvar mixed $date_start Starting date for sweepstake
* @staticvar mixed $date_end Ending date for sweepstake
* @staticvar mixed $fields Serialized array of sweepstake fields
* @staticvar int $min_age Minimum age for sweepstake
* @staticvar bool $multiple_entrants Flag for allowing multiple entries (0 False/1 True)
* @staticvar string $close Sweepstake closing text
* @staticvar string $terms Terms & Conditions (SI)
* @staticvar string $privacy Privacy Policy (SI)
* @staticvar string $rules Sweepstake Rules (SI and PB)
* @staticvar mixed $timestamp Current timestamp on insert/update
* @staticvar int $author Joomla user who created sweepstake
* @staticvar bool $published Published flag (unused, always 1)
* @staticvar string $description Contest description (PB)
* @staticvar string $after_submission Post submission meesage (PB)
*/
class TableSweeps extends JTable {
	//Column names for #__sweeps
	public $id					= null;
	public $name				= null;
	public $date_start			= null;
	public $date_end			= null;
	public $fields				= null;
	public $min_age				= null;
	public $multiple_entrants 	= null;
	public $close				= null;
	public $terms				= null;
	public $privacy				= null;
	public $rules				= null;
	public $timestamp			= null;
	public $author				= null;
	public $published			= null;
	public $description			= null;
	public $after_submission	= null;
	
	function __construct(&$db) {
		parent::__construct("#__sweeps", "id", $db);
	}
}

?>
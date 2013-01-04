<?php
defined('_JEXEC') or die();

class originHelper {
	public $originType		= array();
		
	function __construct() {
		$this->originType	= array('horizon'=>'Horizon', 'ascend'=>'Ascend', 'meridian'=>'Meridian', 'nova'=>'Nova');
		return $this->originType;
	}
	
	function originConfig($name, $originType) {
		$configJSON	= array();
		
		$configJSON['name']			= $name;
		$configJSON['type']			= $originType;
		$configJSON['ga']			= 'UA-12310597-3';
		$configJSON['bgHex']		= '#ffffff';
		$configJSON['status']		= 'active';
		return json_encode($configJSON);	
	}

	/**
	* Type to Color converter
	**/
	function originTypeColor($type) {
		switch($type) {
			case "embed":
				return "purple";
			case "flash":
				return "silver";
			case "image":
				return "yellow";
			case "link":
				return "blue";
			case "trigger":
				return "green";
			case "remove":
				return "red";
		}
	}

}
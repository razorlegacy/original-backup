<?php
defined('_JEXEC') or die();
/**
* Helper class for the creation of new sweepstakes
*/
class sweepstakesHelper {

	private $fieldType		= array();
	private $fieldRequired	= array();

	private $defaultName	= array();
	private $defaultType	= array();
	private $defaultRequired= array();

	function __construct() {
		$this->fieldType		= array("text", "birthdate", "checkbox", "state", "province");
		$this->fieldRequired	= array(1=>"Required", 0=>"Not Required");
	
		$this->defaultName		= array("E-mail", 
										"First Name", 
										"Last Name", 
										"Address", 
										"City", 
										"State", 
										"Zip", 
										"Birthdate", 
										"Phone");
		$this->defaultType		= array("text", 
										"text",
										"text",
										"text",
										"text",
										"state",
										"text",
										"birthdate",
										"text");
		$this->defaultRequired	= array(1,1,1,1,1,1,1,1,1);
	}
	
	/**
	* Helper to output
	* @param mixed $output Whatever to output
	*/
	function build($output) {
		echo $output;
	}
	
	/**
	* Helper to load the field array into a variable
	* @param string $type Which field array to load
	* @return array Array of the default fields
	*/
	function outputPrivate($type) {
		switch($type) {
			case "defaultName":		return $this->defaultName;
									break;
			case "defaultType":		return $this->defaultType;
									break;
			case "defaultRequired":	return $this->defaultRequired;
									break;
		}
	}
	
	/**
	* Creates a HTML dropdown menu specifically for input types
	* @param string $name Name for the HTML input element
	* @param mixed $default Default selected value
	*/
	function type($name, $default="") {
		
		//Sanitize $default
		$default	= explode("_", $default);
		$default	= $default[0];
		
		$selectForm	= "<select name='{$name}'>";
		foreach($this->fieldType as $key=>$value) {
			if($value == $default) {
				$selected	= " selected";
			} else {
				$selected	= "";
			}
			$selectForm	.= "<option value='{$value}'{$selected}>{$value}</option>";
		}
		$selectForm		.= "</select>";
		$this->build($selectForm);
	}
	
	/**
	* Creates a HTML dropdown menu specifically for input required fields
	* @param string $name Name for the HTML input element
	* @param mixed $default Default selected value
	*/
	function required($name, $default="") {
		//Sanitize $default
		$default	= explode("_", $default);
		$default	= $default[0];
		
		$selectForm	= "<select name='{$name}'>";
		foreach($this->fieldRequired as $key=>$value) {				
			if($key == $default && $default != "") {
				$selected	= " selected";
			} else {
				$selected	= "";
			}
			$selectForm		.= "<option value='{$key}'{$selected}>{$value}</option>";
		}
		$selectForm			.= "</select>";
		$this->build($selectForm);
	}
	
	
}
?>
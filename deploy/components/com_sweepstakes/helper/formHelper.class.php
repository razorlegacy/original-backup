<?php defined('_JEXEC') or die();

class formHelper {
	
	private $_states	= array();
	private $_months	= array();
	private $_days		= array();
	private $_years		= array();
	
	function __construct() {
		$this->_states		= $this->_states();
		$this->_provinces	= $this->_provinces();
	}
	
	/**
	* @param string $name Name of select input
	* @param array $exclude Array of excluded state by abbreviation
	* @return string Select dropdown with states
	*/
	function selectStates($name, $exclude = array(), $abbr=true) {

		$selectState	= "";
		$selectState	= "<select name='{$name}' id='{$name}'>\n";
		foreach($this->_states as $key=>$value) {
			if(!in_array($key, $exclude)) {
				if($abbr) {
					$optionName	= $key;
				} else {
					$optionName	= $value;
				}
				
				$selectState	.= "<option value='{$key}'>{$optionName}</option>\n";
			}
		}
		$selectState	.= "</select>\n";
		
		return $selectState;
	}
	
	/**
	* @param string $name Name of select input
	* @param array $exclude Array of excluded CAN provinces
	* @return string Select dropdown with CAN provinces
	*/
	function selectProvinces($name, $exclude = array()) {

		$selectProvince	= "";
		$selectProvince	= "<select name='{$name}' id='{$name}'>\n";
		foreach($this->_provinces as $key=>$value) {
			if(!in_array($key, $exclude)) {
				$optionName		= $value;
				$selectProvince	.= "<option value='{$key}'>{$optionName}</option>\n";
			}
		}
		$selectProvince	.= "</select>\n";
		
		return $selectProvince;
	}
	
	/**
	* @return string Select dropdowns for birthdate consisting of Months, Days and Years
	*/
	function selectBirthdate($name, $monthType="numeric") {
		
		$name				= explode("_", $name);
		
		$this->_months		= $this->_months($monthType);
		$this->_days		= $this->_days();
		$this->_years		= $this->_years();
		
		$selectBirthdate	= "";
		
		
		//Month creation
		$selectBirthdate	= "<select name='{$name[0]}_month_{$name[1]}'>\n";
		foreach($this->_months as $key=>$value) {
		$selectBirthdate	.= "<option value='{$value}'>{$value}</option>\n";
		}
		$selectBirthdate	.= "</select>\n";
		
		//Day creation
		$selectBirthdate	.= "<select name='{$name[0]}_day_{$name[1]}'>\n";
		foreach($this->_days as $key=>$value) {
		$selectBirthdate	.= "<option value='{$value}'>{$value}</option>\n";
		}
		$selectBirthdate	.= "</select>\n";
		
		//Year creation
		$selectBirthdate	.= "<select name='{$name[0]}_year_{$name[1]}'>\n";
		foreach($this->_years as $key=>$value) {
		$selectBirthdate	.= "<option value='{$value}'>{$value}</option>\n";
		}
		$selectBirthdate	.= "</select>\n";
		
		return $selectBirthdate;
	}
	
	/**
	*
	*/
	function _months($type="numeric") {
		$months	= array(
					1=>"Jan",
					2=>"Feb",
					3=>"Mar",
					4=>"Apr",
					5=>"May",
					6=>"Jun",
					7=>"Jul",
					8=>"Aug",
					9=>"Sep",
					10=>"Oct",
					11=>"Nov",
					12=>"Dec");
		switch($type) {
			default:
			case "numeric": $this->_months	= array_keys($months);
							break;
			case "text":	$this->_months	= array_values($months);
							break;
		}
		
		return $this->_months;
	}
	
	/**
	*
	*/
	function _days() {
		$days	= array();
		for($i=1; $i<32; $i++) {
			array_push($days, $i);
		}
		$this->_days	= $days;
		return $this->_days;
	}
	
	/**
	*
	*/
	function _years($cutOff="") {
		$years		= array();
		$currYear	= date('Y');
		for($i=$currYear; $i>1900; $i--) {
			array_push($years, $i);
		}
		$this->_years	= $years;
		return $this->_years;
	}
	
	/**
	*
	*/
	function _states() {
		$states = array(
			'AL'=>"Alabama",
		    'AK'=>"Alaska", 
		    'AZ'=>"Arizona", 
		    'AR'=>"Arkansas", 
		    'CA'=>"California", 
		    'CO'=>"Colorado", 
		    'CT'=>"Connecticut", 
		    'DE'=>"Delaware", 
		    'DC'=>"District Of Columbia", 
		    'FL'=>"Florida", 
		    'GA'=>"Georgia", 
		    'HI'=>"Hawaii", 
		    'ID'=>"Idaho", 
		    'IL'=>"Illinois", 
		    'IN'=>"Indiana", 
		    'IA'=>"Iowa", 
		    'KS'=>"Kansas", 
		    'KY'=>"Kentucky", 
		    'LA'=>"Louisiana", 
		    'ME'=>"Maine", 
		    'MD'=>"Maryland", 
		    'MA'=>"Massachusetts", 
		    'MI'=>"Michigan", 
		    'MN'=>"Minnesota", 
		    'MS'=>"Mississippi", 
		    'MO'=>"Missouri", 
		    'MT'=>"Montana",
		    'NE'=>"Nebraska",
		    'NV'=>"Nevada",
		    'NH'=>"New Hampshire",
		    'NJ'=>"New Jersey",
		    'NM'=>"New Mexico",
		    'NY'=>"New York",
		    'NC'=>"North Carolina",
		    'ND'=>"North Dakota",
		    'OH'=>"Ohio", 
		    'OK'=>"Oklahoma", 
		    'OR'=>"Oregon", 
		    'PA'=>"Pennsylvania", 
		    'RI'=>"Rhode Island", 
		    'SC'=>"South Carolina", 
		    'SD'=>"South Dakota",
		    'TN'=>"Tennessee", 
		    'TX'=>"Texas", 
		    'UT'=>"Utah", 
		    'VT'=>"Vermont", 
		    'VA'=>"Virginia", 
		    'WA'=>"Washington", 
		    'WV'=>"West Virginia", 
		    'WI'=>"Wisconsin", 
		    'WY'=>"Wyoming");
		    
		return $states;
	}
	
	/**
	*
	*/
	function _provinces() {
		$provinces	= array(
			"Alberta"=>"Alberta",
			"British Columbia"=>"British Columbia",
			"Manitoba"=>"Manitoba",
			"New Brunswick"=>"New Brunswick",
			"Newfoundland and Labrador"=>"Newfoundland and Labrador",
			"Northwest Territories"=>"Northwest Territories",
			"Nova Scotia"=>"Nova Scotia",
			"Nunavut"=>"Nunavut",
			"Ontario"=>"Ontario",
			"Prince Edward Island"=>"Prince Edward Island",
			"Saskatchewan"=>"Saskatchewan",
			"Yukon"=>"Yukon");
		return $provinces;
	}
}
?>
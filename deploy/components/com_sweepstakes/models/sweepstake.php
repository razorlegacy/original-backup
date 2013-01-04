<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class SweepstakesModelSweepstake extends JModel {

	var $_id				= null;
	var $_unsetPost			= array();
	var $_birthdate			= null;
	var $_birthdateField	= null;
	var $_entrantPost		= null;
	
	function __construct() {
		parent::__construct();
		$id					= JRequest::getVar('id', 0);
		$this->_id			= $id;
		$this->_unsetPost	= array('option', 'controller', 'task', 'sid');
	}
	
	/**
	* Retrieve a sweepstake based on ID
	* @param int $sid Sweepstake ID
	* @return object Returns selected sweepstake object
	*/
	function getSweepstake($sid) {
		$db			= $this->getDBO();
		$db->setQuery("SELECT * FROM #__sweeps WHERE id='".$sid."'");
		
		$sweepstake	= $db->loadObject();
		
		if($sweepstake == null) {
			JError::raiseError(500, 'Error reading DB');
		}
		
		return $sweepstake;
	}
	
	/**
	* Gets sweepstake fields for a given sweepstake ID
	* @param int $sid Sweepstake ID
	* @return array Associative array of unserialized fields
	*/
	function getSweepstakeFields($sid) {
		$fields			= $this->getSweepstake($sid);
		$fields			= unserialize($fields->fields);
		
		return $fields;
	}
	
	/**
	* Validates entry data based on 'Required' field
	* @param array $entrant Generated POST array by frontend sweepstake during user submit
	* @param int $sid Sweepstake ID
	* @return array Returns an array, either empty (no error) or with error fields
	*/
	function validateEntrant($entrant, $sid) {
		$arrayError	= array();
		$fields		= $this->getSweepstakeFields($sid);
		
		$min_age	= $this->getSweepstake($sid);
		$min_age	= $min_age->min_age;
			
		//Store shortcuts
		$fieldNames		= $fields['name'];
		$fieldTypes		= $fields['type'];
		$fieldTypesR	= array_flip($fieldTypes);
		$fieldRequired	= $fields['required'];
		
		$birthdateEntry		= $this->_birthdateValidator($fieldTypes, $entrant, $min_age);
		
			$this->_birthdate	= $birthdateEntry;		
			//remove Birthdate input fields and replace with joined one
			$entrantBirthdate	= "";
	
			foreach($entrant as $key=>$value) {
				if(preg_match('/birthdate_/', $key)) {
					unset($entrant[$key]);
					$entrantBirthdate	= $key;
				}
			}
			$entrantBirthdate	= explode("_", $entrantBirthdate);
			$entrant[$entrantBirthdate[0]."_".$entrantBirthdate[2]]		= $this->_birthdate;
		
		
		//Store to private variable for later use
		$this->_entrant		= $entrant;
		
		//Build required array for checking
		$required		= array_combine($fieldTypes, $fieldRequired);
		$result			= array_intersect_key($entrant, $fieldTypesR);

		$continue		= true;
		foreach($required as $key=>$value) {			
			//field is required
			if($value == 1 && empty($result[$key])) {
				//Build error array for XML
				array_push($arrayError, $key);
			}
		}
		return $arrayError;
	}
	
	/**
	* Private: Searches array fields for a match
	* @param array $fields Fields to search
	* @param string $match Partial string to match
	* @return string Whole value of match
	*/
	function _findField($fields, $match) {	
		foreach($fields as $value) {
			if(preg_match('/'.$match.'_/', $value)) {
				return $value;
				break;
			}
		}
	}
	
	/**
	* Private: Combines user input into one birthdate field and checks it against sweeps min. age
	* @param array $fields Sweepstake field types
	* @param array $entrants User submission
	* @param int $min_age Minimum age for sweepstake
	* @return mixed Re-formated birthdate entry if available
	*/
	function _birthdateValidator($fields, $entrants, $min_age) {
		$birthdateField		= false;
		$birthdateEntry		= "";
		$birthdateValidate	= "";
		
		$birthdateField			= $this->_findField($fields, "birthdate");
		//Store to private variable for later use
		$this->birthdateField	= $birthdateField;
		
		//Joins birthdate fields into one
		if($birthdateField) {
			$birthdateField		= explode("_", $birthdateField);
			$birthdateEntry		= $entrants[$birthdateField[0]."_month_".$birthdateField[1]];
			$birthdateEntry		.= "-";
			$birthdateEntry		.= $entrants[$birthdateField[0]."_day_".$birthdateField[1]];
			$birthdateEntry		.= "-";
			$birthdateEntry		.= $entrants[$birthdateField[0]."_year_".$birthdateField[1]];
			
			//Stupid strtotime argument order for age verification...
			$birthdateValidate	= $entrants[$birthdateField[0]."_day_".$birthdateField[1]];
			$birthdateValidate	.= "-";
			$birthdateValidate	.= $entrants[$birthdateField[0]."_month_".$birthdateField[1]];
			$birthdateValidate	.= "-";
			$birthdateValidate	.= $entrants[$birthdateField[0]."_year_".$birthdateField[1]];
		} else {
			return false;
		}
		
		if($this->_determine_age($birthdateValidate) >= $min_age) {
			return $birthdateEntry;
		} else {
			return false;
		}
	}
	
	/**
	* Private: Determines age from an birthdate input and current date
	* @param date $birth_date Date: DD-MM-YYYY
	* @return int Age difference
	*/
	function _determine_age($birth_date) {
		$birth_date_time 	= strtotime($birth_date);
		$to_date 			= date('m/d/Y', $birth_date_time);
		
		list($birth_month, $birth_day, $birth_year) = explode('/', $to_date);
		
		$now 							= time();
		$current_year 					= date("Y");
		$this_year_birth_date 			= $birth_month.'/'.$birth_day.'/'.$current_year;
		$this_year_birth_date_timestamp = strtotime($this_year_birth_date);
		$years_old						= $current_year - $birth_year;
		
		if($now < $this_year_birth_date_timestamp) {
			$years_old = $years_old - 1;
		}
		return $years_old;
	}
	
	/**
	 * Saves user entry in database
	 * @param array $entrant Generated POST array by frontend sweepstake during user submit
	 * @param int $sid Sweepstake ID
	 * @return int Insert ID on success
	 */
	function saveEntrant($sid) {
		global $mainframe;
		$arrayError	= array();
		
		
		$entrant			= $this->_entrant;
		//stores entrant data
		$entrantAry			= array();
		
		$entrantsTableRow	=& $this->getTable("entrants");
		
		//Prepare data for entrants database
		$fields			= $this->getSweepstakeFields($sid);
		$fieldTypes		= array_flip($fields['type']);
		
		foreach($fieldTypes as $key=>$value) {
			if(array_key_exists($key, $entrant)) {
				$entrantAry[$key]	= urldecode($entrant[$key]);
			} else {
				$entrantAry[$key]	= null;
			}
		}
				
		//Create array for binding
		$entrantAry		= array("sid"=>$sid, "fields"=>serialize($entrantAry), "timestamp"=>date("Y-m-d H:i:s"));
			
		if(!$entrantsTableRow->bind($entrantAry)) {
			JError::raiseError(500, "Error binding data");
		}
		
		if(!$entrantsTableRow->check()) {
			JError::raiseError(500, "Invalid data");
		}		
		
		if(!$entrantsTableRow->store()) {
			$errorMessage	= $entrantsTableRow->getError();
			JError::raiseError(500, "Error binding data: ".$errorMessage);
		} else {
			// late static binding e.g.: _tbl_key -> uid -> 23, thus, returns 23
			return $entrantsTableRow->{$entrantsTableRow->_tbl_key};
		}
	}

	//Debug: get *all* sweepstakes
	function getSweepstakes() {
		$db				= $this->getDBO();
		$db->setQuery("SELECT * FROM #__sweeps");
		
		$sweepstakes	= $db->loadObjectList();
		
		if($sweepstakes == null) {
			JError::raiseError(500, 'Error reading DB');
		} else {
			foreach ($sweepstakes as $sweep) {
				$sweep->link = "/index.php?option=com_sweepstakes&view=sweepstake&sid={$sweep->id}";
			}
			
			return $sweepstakes;
		}
	}

	/**
	 * getConfirmationCode
	 * 
	 * Generates a confirmation code based off of a given unique
	 * ID.
	 * 
	 * @param	integer	Unique ID
	 * @return	string	Confirmation code
	 */
	function getConfirmationCode($id)
	{
		// generate a crc based off of our ID and make sure it's positive
		return abs(crc32($id));
	}
}
?>
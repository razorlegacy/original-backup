<?php
defined('_JEXEC') or die();
/**
* Helper class to manage the Joomla user object. Helps with permission levels, name display, etc.
*/
class userHelper {

	public $_user		= null;
	public $_userId		= null;
	public $_userName	= null;
	public $_userType	= null;
	public $_userACL	= array();

	function __construct() {
		$this->_userACL		= array(0=>"Super Administrator", 1=>"Administrator", 2=>"Manager");
		$this->_user		=& JFactory::getUser();
		$this->_userId		= $this->_user->id;
		$this->_userName	= $this->_user->name;
		$this->_userType	= $this->_user->usertype;
	}

	/**
	* Nested function to check if user meets minimum user access level
	* @return int Grant or Deny access
	*/
	function checkACL($minLevel) {
		return $this->_grantAccess($this->_getACL($this->_userType), $minLevel);
	}

	/**
	* Translates Joomla User levels to a numerical value. Smaller the number, the higher access. 0 == Super Administrator
	* @return int corresponding ACL value
	*/
	function _getACL($userLevel) {	
		$key	= array_search($this->_userType, $this->_userACL);
		return $key;
	}
	
	function _convertACL($acl) {
		$value	= $this->_userACL[$acl];
		return $value;
	}
	
	/**
	* Decides if to grant access based on current and minimum ACL level
	* @param int $userACL Current user's permission level
	* @param int $minACL Minimum access level required
	* @return bool True or False
	*/
	function _grantAccess($userACL, $minACL) {
		if($userACL > $minACL) {
			return false;
		} elseif ($userACL <= $minACL) {
			return true;
		}
	}
	
	/**
	* Pulls a list of all matching user accounts
	* @param int $minACL Minimum account permission level to pull
	* @return object Object of user accounts (name, IDs and usertypes)
	*/
	function loadUsers($minACL) {
		$userTypeArray		= array();
		for($i = 0; $i<=$minACL; $i++) {
			array_push($userTypeArray, "'".$this->_convertACL($i)."'");
		}
		
		$db 	=& JFactory::getDBO();
		$query	= "SELECT id, name, usertype 
					FROM #__users 
					WHERE usertype 
					IN (".implode(',', $userTypeArray).") 
					AND block = 0 
					ORDER BY name ASC";
		$db->setQuery($query);
		$users	= $db->loadObjectList();
		
		return $users;
	}
	
	function userDropDown($minACL, $manager, $userObj, $fieldName) {
		$userObj	= $userObj->_user;
		if($this->checkACL($minACL)) {
			if(!$manager) {
				$userDefault	= $userObj->id;
			} else {
				$userDefault	= $manager;
			}
			
			$userSelect			= $this->loadUsers(2);
			
			$optionSelect		= "<select name='{$fieldName}'>";
			
			foreach($userSelect as $value) {
				if($value->id == $userDefault) {
					$selected	= " SELECTED";
				} else {
					$selected	= "";
				}
				$optionSelect		.= "<option value='{$value->id}'{$selected}>{$value->name}</option>";
			}
			$optionSelect		.= "</select>";
		} else {
			$optionSelect				= "{$userObj->name}<input type='hidden' name='manager' value='{$userObj->id}'/>";
		}
		
		return $optionSelect;
	}
}
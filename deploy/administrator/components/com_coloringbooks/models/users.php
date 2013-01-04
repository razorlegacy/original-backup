<?php
//No direct acesss
defined('_JEXEC') or die();
jimport('joomla.application.component.model');

/**
 * Model to represent joomla users.
 *
 * @package ColoringBooksAdmin
 */
class ColoringBooksModelUsers extends JModel {

	/**
	* Pulls a list of all matching user accounts
	* @return object Object of user accounts (name, IDs and usertypes)
	*/
	function getAllUsers() {

		$db 	=& JFactory::getDBO();
		$query	= "SELECT id, name, usertype
					FROM #__users
					ORDER BY name ASC";
		$db->setQuery($query);
		$users	= $db->loadObjectList();

		return $users;
	}
}?>
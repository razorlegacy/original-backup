<?php
//No direct acesss
defined('_JEXEC') or die();
jimport('joomla.application.component.model');
jimport( 'joomla.utilities.arrayhelper' );

/**
 * Model for Buttons. Buttons are defined as areas which when interacted with produce a predefined behavior.
 *
 * @package SliversAdmin
 */
class SliversModelButtons extends JModel {

 	/**
	* Returns an array of all the buttons for a sliver.
	*
	* @param int $sliver_id id of the sliver from which all the buttons belong to
	* @return array an array of button objects
	*/
	function getButtonsForSliver($sliver_id){
		if(!is_numeric($sliver_id) || ($sliver_id = intval($sliver_id)) < 1)
			JError::raiseError(500,'invalid sliver id');
		$db =& $this->getDBO();

		$db->setQuery('SELECT * from #__slivers_buttons WHERE sliver_id='.(int)$sliver_id);

		$buttons = $db->loadObjectList();

		if ($buttons === null)
			JError::raiseError(500, 'Error reading db');

		return $buttons;
	}

	/**
	* Returns an array of Button objects
	*
	* @param  array $idlist list of integer Button ids
	* @return array an array of Button objects
	*/
	function getButtons(array $idlist){
		JArrayHelper::toInteger($arrayIDs);
		
		$query = ' SELECT * FROM #__slivers_buttons '.
							' WHERE id IN ('.implode(',', $arrayIDs).')';
		$db =& $this->getDBO();
		$db->setQuery($query);
		$button = $db->loadObjectList();

		if ($button === null)
			JError::raiseError(500, 'Button not found.');

		return $button;
	}

	/**
	* Saves the provided Button properties
	*
	* @param array $button associative array with button properties
	* @return TableButton The table object for the properties just entered
	*/
	function save(array $button){
		$buttonsTableRow =& $this->getTable('buttons');

		//when switching areas reset the position if the user didn't already set a manual position
		if(isset($button['id']) && isset($button['area'])){
			$buttonsTableRow->load($button['id']);
			if($buttonsTableRow->area != $button['area']
				&& $buttonsTableRow->x_offset == $button['x_offset']
				&& $buttonsTableRow->y_offset == $button['y_offset']){
				$button['x_offset'] = 0;
				$button['y_offset'] = 0;
			}
		}

		// Insert/update this record in the db
		if (!$buttonsTableRow->save($button)) {
			$errorMessage = $buttonsTableRow->getError();
			JError::raiseError(500, 'Error binding data: '.$errorMessage);
		}

		return $buttonsTableRow;
	}

	/**
	* returns an empty button
	*
	* @return TableButton a button Table object with default properties
	*/
	function getNewButton($sliver_id = null){
		$buttonsTableRow =& $this->getTable('buttons');
		$buttonsTableRow->id = 0;
		$buttonsTableRow->action = 'closesliver';
		$buttonsTableRow->area = 'sliver';
		$buttonsTableRow->on = 'click';
		$buttonsTableRow->sliver_id = $sliver_id;

		return $buttonsTableRow;
	}

	/**
	* Delete the buttons with the provided ids.
	*
	* @param array $arrayIDs a list of button ids (int) to delete
	*/
	function delete(array $arrayIDs){
		JArrayHelper::toInteger($arrayIDs);

		$query = "DELETE FROM #__slivers_buttons WHERE id IN (".implode(',', $arrayIDs).")";
		$db = $this->getDBO();
		$db->setQuery($query);
		if (!$db->query()){
			$errorMessage = $this->getDBO()->getErrorMsg();
			JError::raiseError(500, 'Error deleting buttons: '.$errorMessage);
		}
	}
}

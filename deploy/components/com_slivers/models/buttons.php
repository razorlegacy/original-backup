<?php
//No direct acesss
defined('_JEXEC') or die();
jimport('joomla.application.component.model');

/**
 * Model for Buttons
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

		$db->setQuery('SELECT id,width,height,x_offset,y_offset,area,action,`on`,url,name from #__slivers_buttons WHERE sliver_id='. (int) $sliver_id);

		$buttons = $db->loadObjectList();

		if ($buttons === null)
			JError::raiseError(500, 'Error b reading db');

		return $buttons;
	}

	/**
	* Returns an array of Button objects
	*
	* @param  array $idlist list of Button ids
	* @return array an array of Button objects
	*/
	function getButtons($idlist){
		foreach($idlist as &$id){
			if(!is_numeric($id) || ($id=intval($id)) < 1) JError::raiseError(500,'Invalid button id');
		}
		$query = ' SELECT id,width,height,x_offset,y_offset,area,action,on,url,name FROM #__slivers_buttons '.
							' WHERE id IN ('.implode(',', $arrayIDs).')';
		$db =& $this->getDBO();
		$db->setQuery($query);
		$button = $db->loadObjectList();

		if ($button === null)
			JError::raiseError(500, 'Button not found.');

		return $button;
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



}

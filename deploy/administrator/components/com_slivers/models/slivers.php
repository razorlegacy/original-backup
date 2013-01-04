<?php
//No direct acesss
defined('_JEXEC') or die();
jimport('joomla.application.component.model');
jimport( 'joomla.utilities.arrayhelper' );
// http://valums.com/ajax-upload/
require_once (JPATH_COMPONENT.DS."classes".DS.'qquploader.php');

/**
 * Model for Slivers.
 * A Sliver is ad that can appear at the top of any web page as a static horizontal bar that
 * can be expanded into a more interactive unit.
 *
 * @package SliversAdmin
 */
class SliversModelSlivers extends JModel {
 private $base_file_path;
 private $base_uri =  "/assets/components/com_slivers";

 	/**
	* Constructor
	*
	*/
	function __construct(){
		parent::__construct();
		$this->base_file_path    = JPATH_ROOT.DS."assets".DS.'components'.DS."com_slivers";
		//temp
	}

 	/**
	* Returns an array with all the slivers the user has access to as generic objects.
	*
	* @return array an array of generic slivers objects
	*/
	function getAllSlivers(){
		$db =& $this->getDBO();
		$user =& JFactory::getUser();
		if($user->authorize('com_slivers', 'viewAlterOtherSlivers')){
			$db->setQuery('SELECT s.*,u.name owner from #__slivers s LEFT JOIN #__users u ON u.id=s.owner_id');
		}else{
			$db->setQuery('SELECT * from #__slivers WHERE owner_id='.$db->getEscaped($user->id));
		}
			$slivers = $db->loadObjectList();

		if ($slivers === null)
			JError::raiseError(500, 'Error reading db');

		return $slivers;
	}

	/**
	* Returns the sliver with the provided sliver id
	*
	* @param int $id id of the sliver
	* @return object sliver
	*/
	function getSliver($id){
		if(!is_numeric($id) || ($id = intval($id)) < 1)
			JError::raiseError(500,'invalid sliver id');
		$query = ' SELECT s.*, u.name owner FROM #__slivers s LEFT JOIN #__users u ON u.id=s.owner_id'.
							' WHERE s.id = '.$id;
		$db =& $this->getDBO();
		$db->setQuery($query);
		$sliver = $db->loadObject();

		if ($sliver === null)
			JError::raiseError(500, 'Sliver with ID: '.$id.' not found.');

		return $sliver;
	}

	/**
	* Saves the provided sliver properties
	*
	* @param array $sliver hash with sliver's properties
	* @return TableSliver The table object for the properties just entered
	*/
	function save(array $sliver){
		$sliverTableRow =& $this->getTable('slivers');
		$sliver['owner_id'] = JFactory::getUser()->id;
		if(!isset($sliver['tweenBG'])) $sliver['tweenBG'] = false;
		// Insert/update this record in the db
		if (!$sliverTableRow->save($sliver)) {
			$errorMessage = $sliverTableRow->getError();
			JError::raiseError(500, 'Error binding data: '.$errorMessage);
		}
		//If we get here and with no raiseErrors, then everything went well
		return $sliverTableRow;
	}

	/**
	* Returns an empty sliver with all the default properties.
	*
	* @return TableSliver a slivers Table object with default properties
	*/
	function getNewSliver(){
		$sliverTableRow =& $this->getTable('slivers');
		$sliverTableRow->id = 0;
		$sliverTableRow->name = '';
		$user =& JFactory::getUser();
		$sliverTableRow->owner_id = $user->id;
		$sliverTableRow->playlist_position = 'right';
		$sliverTableRow->playlist_thumb_max_height = 60;
		$sliverTableRow->playlist_thumb_max_width = 60;
		$sliverTableRow->playlist_thumb_shadow_offset_x = 0;
		$sliverTableRow->playlist_thumb_shadow_offset_y = 0;
		$sliverTableRow->playlist_thumb_shadow_blur_radius = 5;
		$sliverTableRow->playlist_thumb_shadow_spread_radius = 3;
		$sliverTableRow->sliv_open_animation = 'easeOutExpo';
		$sliverTableRow->sliv_close_animation = 'easeOutExpo';
		$sliverTableRow->sliv_close_duration = 750;
		$sliverTableRow->sliv_open_duration = 1000;
		$sliverTableRow->animation_resolution = 25;
		$sliverTableRow->ab_open_animation = 'easeOutQuad';
		$sliverTableRow->ab_close_animation = 'easeOutQuad';
		$sliverTableRow->ab_close_duration = 400;
		$sliverTableRow->ab_open_duration = 200;
		$sliverTableRow->ab_open_delay = 200;
		$sliverTableRow->playlist_thumb_active_outline_color = 'rgba(96,185,206,0.35)';
		$sliverTableRow->playlist_thumb_shadow_color = 'rgba(96,185,206,0.35)';

		return $sliverTableRow;
	}

	/**
	* Deletes the slivers provided.
	*
	* @param array $arrayIDs a list of Sliver ids (int) to delete
	*/
	function delete(array $arrayIDs){
		JArrayHelper::toInteger($arrayIDs);
		
		$query = "DELETE FROM #__slivers WHERE id IN (".implode(',', $arrayIDs).")";
		$db = $this->getDBO();
		$db->setQuery($query);
		if (!$db->query()){
			$errorMessage = $this->getDBO()->getErrorMsg();
			JError::raiseError(500, 'Error deleting slivers: '.$errorMessage);
		}
	}

}

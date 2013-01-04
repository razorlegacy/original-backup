<?php
//No direct acesss
defined('_JEXEC') or die();
jimport('joomla.application.component.model');
jimport( 'joomla.utilities.arrayhelper' );
// http://valums.com/ajax-upload/
require_once (JPATH_COMPONENT.DS."classes".DS.'qquploader.php');

/**
 * Model for ScheduledImages: A scheduled image is supposed to be any sort of image which is
 * supposed to be shown on specific date.
 *
 * @package SliversAdmin
 */
class SliversModelScheduledImages extends JModel {
 private $base_file_path;
 private $base_uri =  "/assets/components/com_slivers";

 	/**
	* Constructor
	*
	*/
	function __construct(){
		parent::__construct();
		$this->base_file_path    = JPATH_ROOT.DS."assets".DS.'components'.DS."com_slivers";
	}

	/**
	* returns an empty Scheduled Image
	*
	* @return TableScheduledImages a scheduled images Table object with default properties
	*/
	function getNewScheduledImage(){
		$scheduledImageTableRow =& $this->getTable('scheduledImage');
		$scheduledImageTableRow->id = 0;
		$scheduledImageTableRow->name = '';

		return $scheduledImageTableRow;
	}


	/**
	* Returns the specified scheduled-image
	*
	* @param int $id id of the scheduled image
	* @return object Scheduled Image
	*/
	function getScheduledImage($id){
		if(!is_numeric($id) || ($id = intval($id)) < 1)
			JError::raiseError(500,'invalid sliver id');

		$query = 'SELECT * FROM #__slivers_scheduledImages '.
							' WHERE id = '.(int)$id;
		$db =& $this->getDBO();
		$db->setQuery($query);
		$scheduledImage = $db->loadObject();

		if ($scheduledImage === null)
			JError::raiseError(500, 'scheduledImage with ID: '.$id.' not found.');

		return $scheduledImage;
	}

	/**
	* Get scheduled Images that belong to the provided sliver.
	*
	* @param int $sliver_id id of the sliver
	* @return array array of page objects
	*/
	function getScheduledImagesForSliver($sliver_id){
		if(!is_numeric($sliver_id) || ($sliver_id = intval($sliver_id)) < 1)
			JError::raiseError(500,'invalid sliver id');
		$db =& $this->getDBO();

		$sliver_id = intval($sliver_id);

		$sql = "SELECT * from #__slivers_scheduledImages WHERE sliver_id = %d ORDER BY starts";
		$sql = sprintf($sql,$sliver_id);

		$db->setQuery($sql);

		$scheduledImages = $db->loadObjectList();

		if ($db->getErrorNum() !== 0)
			JError::raiseError(500, 'Error reading db:'.$db->getErrorMsg().' '.$sql);

		return $scheduledImages;
	}

	/**
	* Saves the provided scheduledImage properties.
	*
	* @param array $scheduledImage hash with scheduled image properties
	* @return TableScheduledImages The table object for the properties just entered
	*/
	function save(array $scheduledImage){
		//Parameter not necessary because our model is named GreetingsModelGreetings (used to illustrate that you can specify an alternative name to the JTable extending class)
		$scheduledImageTableRow =& $this->getTable('scheduledImages');
		
		// Insert/update this record in the db
		if (!$scheduledImageTableRow->save($scheduledImage)) {
			$errorMessage = $scheduledImageTableRow->getError();
			JError::raiseError(500, 'Error binding data: '.$errorMessage);
		}
		
		//If we get here and with no raiseErrors, then everything went well
		return $scheduledImageTableRow;
	}

	/**
	* Deletes a sliver scheduledImage.
	*
	* @param int $scheduledImageID
	*/
	function delete($scheduledImageID){
		$scheduledImageID = (int) $scheduledImageID;
		$scheduledImageRow = $this->getTable('scheduledImages');
		$scheduledImageRow->load($scheduledImageID);

		if(!$scheduledImageRow->delete())
			JError::raiseError(500,"Could not delete scheduledImage :".$scheduledImageRow->getError());

	}
}

<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

/**
 * Coloring books model
 * @package Slivers
 */

class SliversModelScheduledImages extends JModel {
	public $_db	= null;

	function __construct() {
		parent::__construct();
        $this->_db 		= $this->getDBO();
	}

	function getScheduledImagesForSliver($sliver_id){
		$sliver_id = intval($sliver_id);
		if($sliver_id < 1) JError::raiseError(500, "invalid sliver_id");
		$query = ' SELECT id,DATE_FORMAT(starts,\'%m/%d/%Y\') starts,actionbar_uri,flash_uri,flash_width,flash_height FROM #__slivers_scheduledImages '.
							' WHERE sliver_id = '.$sliver_id;
		$this->_db->setQuery($query);
		$scheduledImage = $this->_db->loadObjectList();

		if ($scheduledImage === null)
			JError::raiseError(500, 'sliver with ID: '.$sliver_id.' not found.');

		return $scheduledImage;
	}

}
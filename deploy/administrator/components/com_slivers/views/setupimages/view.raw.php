<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
jimport( 'joomla.environment.browser' );
require_once (JPATH_COMPONENT.DS."classes".DS.'sliverNav.php');
jimport( 'joomla.application.component.view');
/**
 * HTML View class for the backend of the Slivers Component's scheduledImages
 *
 * @package    SliversAdmin
 */
class SliversViewSetupImages extends JView{

/**
  * Throws out the JSON for a page's state
  *
	* @param int $page
  */
	function displayImage($scheduledImageId){
		$model = $this->getModel();
		$scheduledImage = $model->getScheduledImage($scheduledImageId);

		// Get the document object.
		$document =& JFactory::getDocument();
		$browser =& JBrowser::getInstance();
		$agentString = $browser->getAgentString();

		// Set the MIME type for JSON output.
		if(preg_match('/MSIE/i',$agentString)) $document->setMimeEncoding( 'text/html' );
		else $document->setMimeEncoding( 'application/json' );

		$this->assignRef('state', $scheduledImage);
		parent::display();
	}
}
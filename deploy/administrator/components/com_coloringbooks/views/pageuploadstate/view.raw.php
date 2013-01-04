<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
jimport( 'joomla.environment.browser' );
/**
 * JSON View class for the backend of the ColoringBooks Component uploadImage Task
 *
 * @package    ColoringBooks
 */
class ColoringBooksViewPageUploadState extends JView {

 /**
  * Throws out the JSON for a page's state
  *
  * @package    ColoringBooks
	* @param int $page 
  */
	function display($page){

		// Get the document object.
		$document =& JFactory::getDocument();
		$browser =& JBrowser::getInstance();
		$agentString = $browser->getAgentString();
		
		// Set the MIME type for JSON output.
		if(preg_match('/MSIE/i',$agentString)) $document->setMimeEncoding( 'text/html' );
		else $document->setMimeEncoding( 'application/json' );
				
		$this->assignRef('state', $page);

		parent::display();
	}
}